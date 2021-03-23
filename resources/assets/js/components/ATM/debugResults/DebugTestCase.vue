<template>
  <div>
    <project-tool-bar :messageInfo="projectResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a href='/atm/DebugResult/Project/?page=1+25'>{{ lang.breadcrumb.project_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.result_detail }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getTestCaseExecutionInfoByProjectId.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'latestDevRunUpdatedAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="NavigationToRunDebugResults">
          <el-table-column
            :resizable="true"
            :label="lang.table.id"
            align="left"
            width="120"
            prop="testCaseId"
            show-overflow-tooltip
            sortable="custom">
            <template slot-scope="scope">
              NO.{{ scope.row.testCaseId }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.name"
            show-overflow-tooltip
            sortable="custom"
            prop="testCaseName"
            align="left">
            <template slot-scope="scope">
              <i class="icon_t"></i>
              {{scope.row.testCaseName}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            sortable="custom"
            prop="latestDevRunUpdatedAt"
            :label="lang.table.run_date"
            show-overflow-tooltip>
              <template slot-scope="scope">
                {{ scope.row.latestDevRunUpdatedAt ? scope.row.latestDevRunUpdatedAt : lang.table.not_run}}
              </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.success_total_last"
            width="150"
            class-name="column_color_1"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{ scope.row.latestDevRunInstructionPassCount }} / {{ scope.row.latestDevRunInstructionExecutedCount }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.error"
            width="80"
            class-name="column_color_2"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{ scope.row.latestDevRunInstructionExecutedCount - scope.row.latestDevRunInstructionPassCount }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.number_of_run"
            width="150"
            prop="totalDevRunCount"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.create_at"
            align="left"
            prop="latestDevRunCreatedAt"
            sortable="custom"
            show-overflow-tooltip>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex';

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        projectId: null,
        projectResultMessage: {},
        queryObj: {
          ids: '',
          name: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        orderBy: 'latestDevRunUpdatedAt desc',
      }
    },
    computed: {
      ...mapGetters(['getTestCaseExecutionInfoByProjectId'])
    },
    watch: {
      getTestCaseExecutionInfoByProjectId: function() {
        this.total = this.getTestCaseExecutionInfoByProjectId.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readRunResultProjectTestCases', 'readProjectResultForMessage']),
      NavigationToRunDebugResults(row) {
        window.location.href = '/atm/DebugResult/Project/' + this.projectId + '/TestCase/' + row.testCaseId + '/Runs?page=1+25';
      },
      getMessageDetails() {
        const obj = {
          projectId: this.projectId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            if (i == 'ids') {
              obj.data.testCaseIds = this.queryObj[i];
            } else if (i == 'name') {
              obj.data.testCaseName = this.queryObj[i];
            } else {
              obj.data[i] = this.queryObj[i];
            }
          }
        }
        obj.data.orderBy = this.orderBy;
        obj.data.latestDevRunId = 'not null';
        this.readRunResultProjectTestCases(obj);
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'latestDevRunUpdatedAt desc';
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
      this.permissionRule = JSON.parse(this.message);
      this.projectId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
      const project = {
        id: this.projectId
      };
      this.readProjectResultForMessage(project).then((res) => {
        this.projectResultMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>

<style scoped>
.testcasenamecol {
  min-width: 200px;
}
.el-date-editor.el-input {
  width: 100% !important;
}
.el-row {
  margin:  0px !important;
}
.icon-container {
  float: right;
  margin-top: 5px;
}
.icon-tools {
  display: inline-block;
  padding: 5px 5px;
}
.icon-tools_set {
  display: inline-block;
  padding: 5px 5px;
}
</style>

