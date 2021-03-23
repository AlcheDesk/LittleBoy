<template>
  <div>
    <project-container>
      <div slot="toolbar">
        <project-tool-bar>
          <div slot="breadcrumb">
            {{ lang.breadcrumb.project_lib }}
          </div>
          <div slot="name">
            {{ lang.breadcrumb.project_list }}
          </div>
          <div slot="operation">
            <template v-if="permissionRule.add_projects">
              <add :lang="lang" @projectAddDone="getMessageDetails"></add>
            </template>
            <template v-if="permissionRule.view_system_setting">
              <el-button class="button_text_table" @click="navigationSetting">{{lang.operator.setting}}</el-button>
            </template>
          </div>
        </project-tool-bar>
      </div>
      <div slot="container">
        <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
          <template v-slot:table>
            <el-table
              :data="getProjects.data"
              row-class-name="row_css"
              :default-sort="{prop: 'id', order: 'descending'}"
              @sort-change="sortChange"
              @row-dblclick.self="Navigation"
              style="width: auto">
              <el-table-column
                :label="lang.table.id"
                :resizable="true"
                align="left"
                prop="id"
                width="100"
                sortable="custom"
                show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                :label="lang.table.name"
                :resizable="true"
                align="left"
                prop="name"
                sortable="custom"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <i class="icon_p"></i>
                  {{scope.row.name}}
                </template>
              </el-table-column>
              <el-table-column
                :label="lang.table.project_type"
                :resizable="true"
                align="left"
                prop="type"
                show-overflow-tooltip>
              </el-table-column>
              <!-- <el-table-column
                label="创建者"
                :resizable="true"
                align="left"
                prop="creator"
                show-overflow-tooltip>
              </el-table-column> -->
              <el-table-column
                :label="lang.table.create_at"
                :resizable="true"
                sortable="custom"
                align="left"
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
              <template v-if="Object.keys(permissionRule).length">
                <el-table-column
                  :label="lang.table.operating"
                  show-overflow-tooltip
                  align="left">
                  <template slot-scope="scope">
                    <template v-if="permissionRule.import_projects">
                      <el-button class="button_text_table" @click="downLoadProject(scope)">{{lang.operator.export}}</el-button>
                    </template>
                    <template v-if="permissionRule.view_projects">
                      <el-button class="button_text_table el_button_info" @click="initViewProjectDetails(scope)">{{lang.operator.view}}</el-button>
                    </template>
                    <template v-if="permissionRule.edit_projects">
                      <edit
                        :lang="lang"
                        :row="scope.row"
                        @projectEditDone="getMessageDetails">
                      </edit>
                    </template>
                    <template v-if="permissionRule.copy_projects">
                      <el-button class="button_text_table" @click="initSaveAsDialog(scope)">{{lang.operator.copy}}</el-button>
                    </template>
                    <template v-if="permissionRule.delete_projects">
                      <el-button class="button_text_table el_button_delete" @click="removeProject(scope)">{{lang.operator.delete}}</el-button>
                    </template>
                  </template>
                </el-table-column>
              </template>
            </el-table>
          </template>
        </search-pagination>
      </div>
    </project-container>

    <el-dialog  :title="lang.dialog.title.view" :close-on-click-modal="false" :visible.sync="viewProjectDetails" :show-close="false">
      <el-form :model="Info" label-width="100px" label-position="right" label-suffix=":">
       <!--  <el-form-item label="创建者">
          <el-input size="small" v-model="Info.creator" disabled></el-input>
        </el-form-item> -->
        <el-form-item :label="lang.table.name">
          <el-input size="small" v-model="Info.name" disabled></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.create_at">
          <el-input size="small" v-model="Info.createdAt" disabled></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.update_at">
          <el-input size="small" v-model="Info.updatedAt" disabled></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.project_type">
          <el-input size="small" v-model="Info.type" disabled></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input size="small" v-model="Info.comment" disabled></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="viewProjectDetails = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="viewProjectDetails = false">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.operator.open" :close-on-click-modal="false" :visible.sync="openNewPageDialog" :show-close="false">
      <el-form label-width="0px" label-position="right" label-suffix=":">
        <el-form-item>
          <div style="display: flex;">
            <div style="flex: 1; text-align: center;">
              <el-button class="el_button_open" size="medium" round @click="NavigationToTestCase">{{ lang.breadcrumb.test_case }}</el-button>
            </div>
            <div style="flex: 1; text-align: center;">
              <el-button type="primary" size="medium" round @click="NavigationToApiElement">{{ lang.breadcrumb.api_management }}</el-button>
            </div>
           <!--  <div style="flex: 1; text-align: center;">
              <el-button type="soap_button" size="medium" round @click="NavigationToApiElement">{{ lang.breadcrumb.soap_management }}</el-button>
            </div> -->
            <div style="flex: 1; text-align: center;">
              <el-button type="success" size="medium" round @click="NavigationToApplication">{{ lang.breadcrumb.element_management }}</el-button>
            </div>
          </div>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="openNewPageDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>
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
      permissionRule: {},
      lang: {},
      total: 0,
      viewProjectDetails: false,
      Info: {
        id: null,
        name: '',
        creator: '',
        createdAt: '',
        updatedAt: '',
        comment: '',
        type: ''
      },
      queryObj: {
        ids: '',
        name: '',
        comment: '',
        startDate: '',
        endDate: '',
        pageNumber: 1,
        pageSize: 25
      },
      orderBy: 'id desc',
      openNewPageDialog: false,
      projectId: null,
    }
  },
  watch: {
    getProjects: function() {
      this.total = this.getProjects.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getProjects'])
  },
  components: { Add, Edit },
  methods: {
    ...mapActions(['readProjects', 'deleteProject', 'saveasProject', 'readFileDownLoadMessage']),
    downLoadProject(scope) {
      const url = 'http://' + window.location.host + '/atm/export/project/' + scope.row.id;
      window.open(url);
      
    },
    getMessageDetails() {
      const obj = {};
      for (var i in this.queryObj) {
        if (this.queryObj[i] != '') {
          obj[i] = this.queryObj[i];
        }
      }
      obj.orderBy = this.orderBy;
      this.readProjects(obj);
    },
    navigationSetting() {
      window.location.href = '/atm/TestSetting/Project/SystemSetting/?page=1+25';
    },
    Navigation (row, event) {
      this.projectId = row.id;
      this.openNewPageDialog = true;
    },
    NavigationToTestCase() {
      window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase/?page=1+25';
    },
    NavigationToApiElement() {
      window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/ApiElement/?page=1+25';
    },
    NavigationToApplication () {
      window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/Application/?page=1+25';
    },
    removeProject(scope) {
      this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning',
        closeOnClickModal: false,
        dangerouslyUseHTMLString: true
      }).then(() => {
        const obj = scope.row;
        this.deleteProject(obj).then((res) => {
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
    initSaveAsDialog(scope) {
      this.$confirm(this.lang.dialog.title.copy + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.copy, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning',
        dangerouslyUseHTMLString: true
      }).then(() => {
        const obj = {
          id: scope.row.id
        }
        this.saveasProject([obj]).then((res) => {
          this.$notify({
            title: this.lang.dialog.title.notification,
            message: this.lang.dialog.title.copy_project_notification,
            type: 'info'
          });
          const thiz = this;
          setTimeout(function() {
            thiz.getMessageDetails();
            thiz.$notify({
              title: thiz.lang.dialog.title.success,
              message: thiz.lang.dialog.title.copy_project_success,
              type: 'success'
            });
          }, 30000);
        }, (err) => {
          console.log(err);
        });
      }).catch(() => {
        this.$message({
          type:'info',
          message: this.lang.dialog.title.uncopy
        });
      });
    },
    initViewProjectDetails(scope) {
      this.Info = scope.row;
      this.viewProjectDetails = true;
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
  created() {
    var message =  JSON.parse(this.message);
    this.permissionRule = message.permissions;
    this.lang = message.lang;
    this.getMessageDetails();
  }
};
</script>

