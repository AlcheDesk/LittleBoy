<template>
  <project-container>
    <div slot="toolbar">
      <project-tool-bar>
        <div slot="breadcrumb">
          <el-breadcrumb separator="/">
            <el-breadcrumb-item>
              <a style="font-weight: 500;" href='/atm/TestSetting/Project/?page=1+25'>{{ lang.breadcrumb.project_lib }}</a>
            </el-breadcrumb-item>
            <el-breadcrumb-item>
              <a style="font-weight: 500;" :href="'/atm/TestSetting/Project/' + projectId + '/Application/?page=1+25'">{{ lang.breadcrumb.application }}</a>
            </el-breadcrumb-item>
            <el-breadcrumb-item>{{ lang.breadcrumb.section }}</el-breadcrumb-item>
          </el-breadcrumb>
        </div>
        <div slot="name" class="text_ellipsis">
          {{applicationMessage.name}}
        </div>
        <div slot="creator" class="text_ellipsis">
          {{applicationMessage.createdAt}}
        </div>
        <div slot="operation">
          <template v-if="permissionRule.add_sections">
            <add :lang="lang" @sectionAddDone="getMessageDetails"></add>
          </template>
        </div>
      </project-tool-bar>
    </div>
    <div slot="container">
      <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
        <template v-slot:table>
          <el-table
            :data="getApplicationSections.data"
            class="table_style"
            row-class-name="row_css"
            :default-sort="{prop: 'createdAt', order: 'descending'}"
            @sort-change="sortChange"
            @row-dblclick="navigationToElementIpuntContainer"
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
              :label="lang.table.name"
              :resizable="true"
              sortable="custom"
              align="left"
              prop="name"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <i class="icon_s"></i>
                {{scope.row.name}}
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
            <el-table-column
              :label="lang.table.comment"
              :resizable="true"
              align="left"
              prop="comment"
              show-overflow-tooltip>
            </el-table-column>
            <template v-if="permissionRule.edit_sections || permissionRule.delete_sections">
              <el-table-column
              :label="lang.table.operating"
                :resizable="true"
                width="150"
                align="left">
                <template slot-scope="scope">
                  <template v-if="permissionRule.edit_sections">
                    <edit
                      :lang="lang"
                      :row="scope.row"
                      @sectionEditDone="getMessageDetails">
                    </edit>
                  </template>
                  <template v-if="permissionRule.delete_sections">
                    <el-button class="button_text_table" @click="removeProjectApplicationSection(scope)">{{lang.operator.delete}}</el-button>
                  </template>
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
  import Add from './Add.vue'
  import Edit from './Edit.vue'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        total: 0,
        projectId: null,
        applicationId: null,
        applicationMessage: {},
        orderBy: 'createdAt desc',
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
      };
    },
    watch: {
      getApplicationSections: function() {
        this.total = this.getApplicationSections.metadata.count;
      }
    },
    computed: {
      ...mapGetters(['getApplicationSections'])
    },
    components: { Add, Edit },
    methods: {
      ...mapActions(['readApplicationSections', 'deleteApplicationSection', 'readApplicationForMessage']),
      navigationToElementIpuntContainer(row) {
        localStorage.setItem('elementOrderBy', this.orderBy);
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/Application/' + this.applicationId + '/Section/' + row.id + '/Element/?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        obj.applicationId = this.applicationId;
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.orderBy ? obj.data.orderBy = this.orderBy : null;
        this.readApplicationSections(obj);
      },
      removeProjectApplicationSection(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = scope.row;
          this.deleteApplicationSection(obj).then((res) => {
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
      this.applicationId = window.location.pathname.split('/')[6];
      this.getMessageDetails();
      const application = {
        id: this.applicationId
      };
      this.readApplicationForMessage(application).then((res) => {
        this.applicationMessage = res.data[0];
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