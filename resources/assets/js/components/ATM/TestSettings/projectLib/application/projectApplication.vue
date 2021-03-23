<template>
  <project-container>
    <div slot="toolbar">
      <project-tool-bar>
        <div slot="breadcrumb">
          <el-breadcrumb separator="/">
            <el-breadcrumb-item>
              <a style="font-weight: 500;" href='/atm/TestSetting/Project/?page=1+25'>{{ lang.breadcrumb.project_lib }}</a>
            </el-breadcrumb-item>
            <el-breadcrumb-item>{{ lang.breadcrumb.application }}</el-breadcrumb-item>
          </el-breadcrumb>
        </div>
        <div slot="name" class="text_ellipsis">
          {{ projectMessage.name }}
        </div>
        <div slot="creator" class="text_ellipsis">
          {{ projectMessage.createdAt }}
        </div>
        <div slot="operation">
          <template v-if="permissionRule.add_applications">
            <add :lang="lang" @applicationAddDone="getMessageDetails"></add>
          </template>
        </div>
      </project-tool-bar>
    </div>
    <div slot="container">
      <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
        <template v-slot:table>
          <el-table
            :data="getProjectApplications.data"
            row-class-name="row_css"
            :default-sort="{prop: 'createdAt', order: 'descending'}"
            @sort-change="sortChange"
            @row-dblclick="navigationToProjectApplicationSection"
            style="width: auto">
            <el-table-column
              :resizable="true"
              align="left"
              prop="id"
              sortable="custom"
              :label="lang.table.id"
              width="100">
            </el-table-column>
            <el-table-column
              :label="lang.table.name"
              :resizable="true"
              align="left"
              sortable="custom"
              prop="name"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <i class="icon_a"></i>
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
            <template v-if="permissionRule.delete_applications || permissionRule.edit_applications">
              <el-table-column
                :label="lang.table.operating"
                :resizable="true"
                align="left"
                width="150"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <template v-if="permissionRule.edit_applications">
                    <edit
                      :lang="lang"
                      :row="scope.row"
                      @applicationEditDone="getMessageDetails">
                    </edit>
                  </template>
                  <template v-if="permissionRule.delete_applications">
                    <el-button class="button_text_table" @click="removeProjectApplication(scope)">{{lang.operator.delete}}</el-button>
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
  import { mapGetters, mapActions } from 'vuex'
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
        projectMessage: {},
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
      getProjectApplications: function() {
        this.total = this.getProjectApplications.metadata.count;
      }
    },
    components: { Add, Edit },
    computed: {
      ...mapGetters(['getProjectApplications'])
    },
    methods: {
      ...mapActions(['readProjectApplications', 'deleteProjectApplication', 'readProjectFormessage']),
      navigationToProjectApplicationSection(row, event) {
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/Application/' + row.id + '/Section?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        obj.projectId = this.projectId;
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.orderBy ? obj.data.orderBy = this.orderBy : null;
        this.readProjectApplications(obj);
      },
      removeProjectApplication(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = scope.row;
          obj.projectId = this.projectId;
          this.deleteProjectApplication(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
        }).catch((err) => {
          console.log(err);
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
      });
    }
  };
</script>
