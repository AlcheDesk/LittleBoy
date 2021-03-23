<template>
  <project-container>
    <div slot="toolbar">
      <project-tool-bar>
        <div slot="breadcrumb">
          <el-breadcrumb separator="/">
            <el-breadcrumb-item>
              <a style="font-weight: 500;" href='/atm/TestSetting/Project'>{{ lang.breadcrumb.project_lib }}</a>
            </el-breadcrumb-item>
            <el-breadcrumb-item>{{ lang.breadcrumb.soap_element }}</el-breadcrumb-item>
          </el-breadcrumb>
        </div>
        <div slot="name" class="text_ellipsis">
          {{projectMessage.name}}
        </div>
        <div slot="creator" class="text_ellipsis">
          {{projectMessage.createdAt}}
        </div>
        <div slot="operation">
          <template v-if="permissionRule.add_elements">
            <el-button class="button_text_table" @click="navigationToAddApiElement">{{ lang.operator.new }}</el-button>
          </template>
        </div>
      </project-tool-bar>
    </div>
    <div slot="container">
      <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
        <template v-slot:table>
          <el-table
              :data="apiElements"
              class="table_style"
              row-class-name="row_css"
              @row-dblclick="navigationToEditApiElement"
              :default-sort="{prop: 'createdAt', order: 'descending'}"
              @sort-change="sortChange"
              style="width: auto">
              <el-table-column
                :label="lang.table.id"
                sortable="custom"
                :resizable="true"
                align="left"
                prop="id"
                show-overflow-tooltip
                width="100">
              </el-table-column>
              <el-table-column
                :label="lang.dialog.title.api_name"
                :resizable="true"
                sortable="custom"
                align="left"
                prop="name"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <i class="icon_api"></i>
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
                :label="lang.table.action"
                :resizable="true"
                align="left"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  {{scope.row.parameter.method}}
                </template>
              </el-table-column>
              <el-table-column
                label="URL"
                :resizable="true"
                align="left"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  {{scope.row.parameter.url}}
                </template>
              </el-table-column>
              <el-table-column
                :label="lang.table.create_at"
                :resizable="true"
                align="left"
                sortable="custom"
                prop="createdAt"
                show-overflow-tooltip>
              </el-table-column>
              <template v-if="permissionRule.delete_elements">
                <el-table-column
                  :label="lang.table.operating"
                  :resizable="true"
                  width="150"
                  align="left">
                  <template slot-scope="scope">
                    <el-button class="button_text_table" @click="removeProjectApplicationSection(scope)">{{lang.operator.delete}}</el-button>
                  </template>
                </el-table-column>
              </template>
          </el-table>
        </template>
      </search-pagination>
    </div>
  </project-container>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import moment from 'moment'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        projectId: null,
        total: 0,
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        projectMessage: {},
        orderBy: 'createdAt desc',
        apiElements: []
      };
    },
    watch: {
      getProjectApiElements: function() {
        this.apiElements = [];
        this.total = this.getProjectApiElements.metadata.count;
        this.getProjectApiElements.data.forEach((element) => {
          if (!element.isDriver) {
            this.apiElements.push(element)
          }
        });
      }
    },
    computed: {
      ...mapGetters(['getProjectApiElements'])
    },
    methods: {
      ...mapActions(['readProjectApiElements', 'deleteProjectApiElement', 'readProjectFormessage', 'countTestCaseOverwriterElement']),
      navigationToAddApiElement() {
        localStorage.setItem('apiElementType', 'add');
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/ApiElementAdd';
      },
      countInstructionOverwriteApiElement(row, callback) {
        const param = {
          elementId: row.id
        };
        this.countTestCaseOverwriterElement(param).then((res) => {
          if (res.metadata.count) {
            this.$confirm(this.lang.dialog.title.api_element_warning_message_1 + res.metadata.count + this.lang.dialog.title.api_element_warning_message_1, this.lang.dialog.title.edit, {
              confirmButtonText: this.lang.operator.confirm,
              cancelButtonText: this.lang.operator.cancel,
              type: 'warning'
            }).then(() => {
              callback(row);
            }).catch((err) => {
              this.$message({
                type:'info',
                message: this.lang.dialog.title.unedit
              });
            });
          } else {
            callback(row);
          }
        }, (err) => {
          console.log(err, '..');
        })
      },
      ApiElementEdit(row) {
        localStorage.setItem('apiElementEditData', JSON.stringify(row));
        localStorage.setItem('apiElementType', 'edit');
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/ApiElementEdit';
      },
      navigationToEditApiElement(row) {
        if (this.permissionRule.edit_elements) {
          this.countInstructionOverwriteApiElement(row, this.ApiElementEdit);
        };
      },
      getMessageDetails() {
        const obj = {};
        obj.id = this.projectId;
        obj.data = {
          type: 'SOAP_API'
        };
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.orderBy ? obj.data.orderBy = this.orderBy : null;
        this.readProjectApiElements(obj);
      },
      removeProjectApplicationSection(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = {};
          obj.id = this.projectId;
          obj.data = {};
          obj.data.id = scope.row.id;
          this.deleteProjectApiElement(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
        }).catch((err) => {
          this.$message({
            type:'info',
            message: this.lang.operator.undelete
          });
        });
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'createdAt desc';
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
      this.getMessageDetails();
      const project = {
        id: this.projectId
      };
      this.readProjectFormessage(project).then((res) => {
        this.projectMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>

<style scoped>

.el-date-editor.el-input {
  width: 100% !important;
}
</style>