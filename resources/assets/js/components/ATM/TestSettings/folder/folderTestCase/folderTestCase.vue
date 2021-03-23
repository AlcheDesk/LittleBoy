<template>
  <project-container>
    <div slot="toolbar">
      <project-tool-bar>
        <div slot="breadcrumb">
          <el-breadcrumb separator="/">
            <el-breadcrumb-item>
              <a style="font-weight: 500;" href='/atm/TestSetting/Folder/?page=1+25'>{{ lang.breadcrumb.folder }}</a>
            </el-breadcrumb-item>
            <el-breadcrumb-item>{{ lang.breadcrumb.test_case }}</el-breadcrumb-item>
          </el-breadcrumb>
        </div>
        <div slot="name" class="text_ellipsis">
          {{ folderMessage.name }}
        </div>
        <div slot="creator" class="text_ellipsis">
          {{ folderMessage.createdAt }}
        </div>
        <div slot="operation">
          <template v-if="permissionRule.add_folder_testcase">
            <add :lang="lang" @folderTestCaseAddDone="getMessageDetails"></add>
          </template>
          <folder-test-case-to-refernce
            class="button_text_table"
            :lang="lang"
            :selections="multipleSelection"
            @clearSelect="clearMultipleSelect">
          </folder-test-case-to-refernce>
        </div>
      </project-tool-bar>
    </div>
    <div slot="container">
      <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
        <template v-slot:table>
          <el-table
            border
            ref="folderTestCaseTable"
            :data="getFolderTestCases.data"
            row-class-name="row_css"
            :default-sort="{prop: 'createdAt', order: 'descending'}"
            @sort-change="sortChange"
            @select-all="selectAll"
            @selection-change="handleSelectionChange"
            :row-key="setRowKey"
            style="width: auto">
            <el-table-column
              :label="lang.table.id"
              :resizable="true"
              align="left"
              sortable="custom"
              prop="id"
              width="100"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              type="selection"
              align="left"
              :reserve-selection="true"
              width="50">
            </el-table-column>
            <el-table-column
              :label="lang.table.name"
              :resizable="true"
              align="left"
              sortable="custom"
              prop="name"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <i class="icon_t"></i>
                {{scope.row.testCase.name}}
              </template>
            </el-table-column>
            <el-table-column
              :label="lang.table.project"
              :resizable="true"
              align="left"
              sortable="custom"
              prop="name"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <i class="icon_p"></i>
                {{scope.row.testCase.projectName}}
              </template>
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
              align="left"
              sortable="custom"
              prop="createdAt"
              show-overflow-tooltip>
              <template slot-scope="scope">
                {{scope.row.testCase.createdAt}}
              </template>
            </el-table-column>
            <el-table-column
              :label="lang.table.comment"
              :resizable="true"
              align="left"
              prop="comment"
              show-overflow-tooltip>
              <template slot-scope="scope">
                {{scope.row.testCase.comment}}
              </template>
            </el-table-column>
            <template v-if="permissionRule.delete_folder_testcase">
              <el-table-column
                :label="lang.table.operating"
                :resizable="true"
                width="100"
                align="left">
                <template slot-scope="scope">
                  <el-button class="button_text_table" @click="removeFolderTestCase(scope)">{{lang.operator.delete}}</el-button>
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
  import FolderTestCaseToRefernce from './folderTestCaseToReference.vue'

  export default {
    props: ['message'],
    data() {
      return {
        folderMessage: {},
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        orderBy: 'createdAt desc',
        multipleSelection: [],
      }
    },
    computed: {
      ...mapGetters(['getFolderTestCases'])
    },
    components: { Add, FolderTestCaseToRefernce },
    watch: {
      getFolderTestCases: function() {
        this.total = this.getFolderTestCases.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readFolderTestCases', 'deleteFolderTestCase', 'readFolderForMessage', 'validateTestCaseRefrence']),
      getMessageDetails() {
        const obj = {};
        obj.folderId = this.folderId;
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.orderBy ? obj.data.orderBy = this.orderBy : null;
        this.readFolderTestCases(obj);
      },
      removeFolderTestCase(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.testCase.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = scope.row;
          this.deleteFolderTestCase(obj).then((res) => {
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
      },
      setRowKey(row) {
        return row.testCase.name + row.id;
      },
      selectAll(section) {
        if (section.length > 1) {
          this.$refs.folderTestCaseTable.clearSelection();
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.select_all_error_message
          });
        }
      },
      handleSelectionChange(val) {
        if (val.length > this.multipleSelection.length + 1) {
          return;
        }
        this.multipleSelection = val;
        var row = val.length ? val[val.length - 1] : null;
        if (row) {
          const obj = {
            testCaseId: row.testCaseId
          };
          return this.validateTestCaseRefrence(obj).then((res) => {
            if (res.metadata.count < 0 || res.metadata.count >= 10) {
              var a = this.multipleSelection.pop();
              this.$refs.folderTestCaseTable.toggleRowSelection(a, false);
              this.$notify.error({
                title: this.lang.dialog.title.operation_error,
                message: this.lang.dialog.title.error_message
              });
            }
          })
        }
      },
      clearMultipleSelect() {
        this.$refs.folderTestCaseTable.clearSelection();
      },
    },
    created() {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
    },
    mounted() {
      this.folderId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
      const folder = {
        id: this.folderId
      };
      this.readFolderForMessage(folder).then((res) => {
        this.folderMessage = res.data[0];
      }, (err) => {
        console.log(err);
      });
    }
  };
</script>

<style>
  .el-transfer-panel__body {
    text-align: left;
  }
</style>
