<template>
  <div>
    <project-tool-bar :messageInfo="projectResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a href='/atm/RunResult/Project/?page=1+25'>{{ lang.breadcrumb.project_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.result_detail }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="operation">
        <el-button class="button_text_table el_button_project_overview" @click="NavigationToProjectChart">{{ lang.operator.project_overview }}</el-button>
        <el-button class="button_text_table el_button_summary_result" @click="resetSearch">{{ lang.operator.summary_result }}</el-button>
        <el-button class="button_text_table el_button_error_testcase" @click="readTestCaseResultFailSearch">{{ lang.operator.error_testcase }}</el-button>
      </div>
    </project-tool-bar>
    
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getTestCaseExecutionInfoByProjectId.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'latestRunUpdatedAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="NavigationToCaseInstructionsResults">
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
            prop="latestRunUpdatedAt"
            :label="lang.table.run_date"
            show-overflow-tooltip>
              <template slot-scope="scope">
                {{ scope.row.latestRunUpdatedAt ? scope.row.latestRunUpdatedAt : lang.table.not_run}}
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
              {{ scope.row.latestRunInstructionPassCount }} / {{ scope.row.latestRunInstructionExecutedCount }}
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
              {{ scope.row.latestRunInstructionExecutedCount - scope.row.latestRunInstructionPassCount }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.number_of_run"
            width="150"
            prop="totalRunCount"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.create_at"
            align="left"
            prop="latestRunCreatedAt"
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
  import moment from 'moment';

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
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
        orderBy: 'latestRunUpdatedAt desc',
        falseResult: false
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
      NavigationToProjectChart() {
        window.location.href = '/atm/RunResult/Project/' + this.projectId + '/Charts';
      },
      NavigationToCaseInstructionsResults(row) {
        window.location.href = '/atm/RunResult/Project/' + this.projectId + '/TestCase/' + row.testCaseId + '/Runs?page=1+25';
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
              obj.data.testCaseName = '%' + this.queryObj[i] + '%';
            } else if (i == 'startDate') {
              obj.data.testCaseStartDate = this.queryObj[i];
            } else if (i == 'endDate') {
              obj.data.testCaseEndDate = this.queryObj[i];
            } else {
              obj.data[i] = this.queryObj[i];
            }
          }
        }
        obj.data.orderBy = this.orderBy;
        obj.data.latestRunId = 'not null';
        if (this.falseResult) {
          obj.data.statusNotIn = 'PASS';
          obj.data.location = true;
        }
        this.readRunResultProjectTestCases(obj);
      },
      resetSearch() {
        localStorage.removeItem('projectCaseFalseResult');
        this.falseResult = false;
        this.getMessageDetails();
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'latestRunUpdatedAt desc';
        }
        this.getMessageDetails();
      },
      readTestCaseResultFailSearch() {
        localStorage.setItem('projectCaseFalseResult', true);
        this.falseResult = true;
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
      this.falseResult = localStorage.getItem('projectCaseFalseResult') || false;
    },
    mounted() {
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


