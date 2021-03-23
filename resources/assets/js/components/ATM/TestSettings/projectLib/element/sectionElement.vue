<template>
  <div>
    <template v-if="permissionRule.add_elements">
      <el-row :gutter="20" class="tool_bar_header">
        <el-col :span="6" class="operation">
          <add
            :lang="lang"
            @elementAddDone="getMessageDetails">
          </add>
      </el-col>
      </el-row>
    </template>
    
    <search-pagination
      :total="total"
      :lang="lang"
      layout="id, name, comment, operation"
      @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="elements"
          border
          class="table_style"
          row-class-name="row_css"
          :default-sort="{prop: 'id', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="editSectionElement"
          style="width: auto">
          <el-table-column
            :label="lang.table.id"
            sortable="custom"
            prop="id"
            align="left"
            width="100"
            :resizable="true"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.table.name"
            :resizable="true"
            align="left"
            prop="name"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <i class="icon_e"></i>
              {{scope.row.name}}
            </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.element_type"
            :resizable="true"
            align="left"
            prop="type"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.dialog.title.position_attribute"
            :resizable="true"
            align="left"
            prop="locatorType"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.dialog.title.attribute_value"
            :resizable="true"
            align="left"
            prop="locatorValue"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.table.comment"
            :resizable="true"
            align="left"
            prop="comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_elements">
            <el-table-column
              :label="lang.table.operating"
              width="100"
              :resizable="true"
              align="left">
              <template slot-scope="scope">
                <el-button class="button_text_table" @click="removeSectionElement(scope)">{{lang.operator.delete}}</el-button>
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </search-pagination>

    <el-dialog :close-on-click-modal="false" :visible.sync="elementTestCaseRelationDialog">
      <span slot="title" style="font-size: 18px;">
        <i class="el-icon-warning"></i>
        <span>{{ lang.dialog.title.un_delete_element }}
          <i style="color: teal;">{{ element }}</i>
        </span>
      </span>
      <div style="text-align: left; margin-left: 20px; font-size: 15px;">
        <p style="margin: 0px;">{{ lang.dialog.title.delete }}
          <i style="color: teal;">{{ element }}</i>
          {{ lang.dialog.title.not_available }}
          <i style="color: teal;">{{ count }}</i>
          {{ lang.dialog.title.containing_message }}
        </p>
        <p style="margin: 0px;">{{ lang.dialog.title.containing_message_2 }}</p>
      </div>
      <div style="margin-left: 20px; margin-top: 10px;">
        <el-table
          border
          :data="testCaseRelations">
          <el-table-column
            align="center"
            :label="lang.dialog.title.project"
            prop="projectName"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            align="center"
            :label="lang.breadcrumb.test_case"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{scope.row.testCaseName}}
              <i style="color: teal;" v-if="scope.row.refrence">{{ this.lang.operator.reference }}</i>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="elementTestCaseRelationDialog = false">{{ this.lang.operator.cancel }}</el-button>
      </span>
    </el-dialog>

    <edit
      :lang="lang"
      :updateElement="EditElement"
      @elementCancelEdit="cancelEdit"
      @elementEditDone="getMessageDetails">
    </edit>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import Add from './Add'
  import Edit from './Edit'


  export default {
    props: ['message'],
    data() {
      return {
        projectId: null,
        applicationId: null,
        sectionId: null,
        permissionRule: {},
        total: 0,
        EditElement: {},
        orderBy: 'id desc',
        elements: [],
        elementTestCaseRelationDialog: false,
        testCaseRelations: [],
        element: '',
        count: 0,
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
      }
    },
    computed: {
      ...mapGetters(['getSectionElements']),
    },
    components: { Add, Edit },
    watch: {
      getSectionElements: function() {
        this.elements = [];
        this.total = this.getSectionElements.metadata.count || 0;
        this.getSectionElements.data.forEach((element) => {
          if (!element.isDriver) {
            this.elements.push(element)
          }
        });
      }
    },
    methods: {
      ...mapActions(['readSectionElements', 'deleteSectionElement', 'readElementRelevance']),
      getMessageDetails() {
        let obj = {
          sectionId: this.sectionId
        }
        obj.data = {
          orderBy: this.orderBy,
          isDriver: false
        };
        for (var i in this.queryObj) {
          if (this.queryObj[i] && this.queryObj[i] != '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.readSectionElements(obj);
      },
      cancelEdit() {
        this.EditElement = {};
      },
      removeSectionElement(scope) {
        this.element = '';
        this.element = scope.row.name;
        const data = {
          elementId: scope.row.id
        };
        this.readElementRelevance(data).then((res) => {
          if (!res.metadata.count) {
            this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
              confirmButtonText: this.lang.operator.confirm,
              cancelButtonText: this.lang.operator.cancel,
              type: 'warning',
              dangerouslyUseHTMLString: true
            }).then(() => {
              var obj = scope.row;
              obj.sectionId = this.sectionId;
              this.deleteSectionElement(obj).then((res) => {
                this.getMessageDetails();
              }, (err) => {
                console.log(err);
              });
            }).catch(() => {
              this.$message({
                type:'info',
                message: this.lang.operator.undelete
              });
            });
          } else {
            this.count = 0;
            this.count = res.metadata.count;
            this.elementTestCaseRelationDialog = true;
            this.testCaseRelations = [];
            this.testCaseRelations = res.data;
          }
        }, (err) => {
          console.log(err);
        })
      },
      editSectionElement(row) {
        if (this.permissionRule.edit_elements) {
           this.EditElement = row;
        }
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'id desc';
        }
        this.getMessageDetails();
      },
      getSearchPaginationModel(val) {
        this.queryObj = val;
        this.getMessageDetails();
      }
    },
    created: function () {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
      this.applicationId = window.location.pathname.split('/')[6];
      this.sectionId = window.location.pathname.split('/')[8];
      this.getMessageDetails();
    }
  };
</script>

