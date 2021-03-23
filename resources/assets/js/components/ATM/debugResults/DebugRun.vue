<template>
  <div>
    <project-tool-bar :messageInfo="projectTestCaseResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/DebugResult/Project/?page=1+25'>{{ lang.breadcrumb.project_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a style="font-weight: 500;" :href="'/atm/DebugResult/Project/' + projectId + '/TestCase/?page=1+25'">{{ lang.breadcrumb.result_detail }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.case_result }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
    </project-tool-bar>

    <search-pagination :total="total" layout="id, name, startDate, endDate, operation, driver, overwrite" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getRunResultProjectTestCaseRuns.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'runCreatedAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="NavigationToCaseInstructionsResults"
          :cell-class-name="cellStyle">
          <el-table-column
            :resizable="true"
            :label="lang.table.id"
            prop="runId"
            align="left"
            show-overflow-tooltip
            sortable="custom">
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.create_at"
            prop="runCreatedAt"
            align="left"
            sortable="custom"
            show-overflow-tooltip>
              <template slot-scope="scope">
                <i class="icon_r"></i>
                {{ scope.row.runCreatedAt ? scope.row.runCreatedAt : lang.table.not_run}}
              </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.overwrite"
            align="left"
            show-overflow-tooltip>
              <template slot-scope="scope">
                <template v-if="scope.row.testCaseOverwriteName">
                    {{scope.row.testCaseOverwriteName}}
                </template>
              </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.status"
            prop="runStatus">
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.success_total"
            class-name="column_color_1"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{ scope.row.instructionPassCount }} / {{ scope.row.executableInstructionNumber }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.error"
            prop="instructionFailCount"
            class-name="column_color_2"
            show-overflow-tooltip>
            <!-- <template slot-scope="scope"> -->
              <!-- {{ scope.row.instructionExecutedCount - scope.row.instructionPassCount }} -->
            <!-- </template> -->
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.priority"
            prop="runPriority">
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            label="Group"
            prop="group"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.trigger_source"
            prop="triggerSource"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.driver"
            prop="driverPackName"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.table.operating"
            :resizable="true"
            align="left"
            width="100">
            <template slot-scope="scope">
              <el-button class="button_text_table" @click='ViewTask(scope.row)'>{{ lang.operator.view_task }}</el-button>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    props: ['message'],
    data() {
      return {
        projectId: null,
        testCaseId: null,
        permissionRule: {},
        lang: {},
        projectTestCaseResultMessage: {},
        queryObj: {
          ids: '',
          name: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        orderBy: 'runCreatedAt desc',
        setLoop: null
      }
    },
    computed: {
      ...mapGetters(['getRunResultProjectTestCaseRuns'])
    },
    watch: {
      getRunResultProjectTestCaseRuns: function() {
        this.total = this.getRunResultProjectTestCaseRuns.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readRunResultProjectTestCaseRuns', 'readTestCaseResultForMessage', 'terminateTestCaseRun', 'ViewTaskByRunId']),
      NavigationToCaseInstructionsResults(row) {
        window.location.href = '/atm/DebugResult/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/Runs/' + row.runId + '/Instruction?page=1+25';
      },
      getMessageDetails() {
        const obj = {
          testCaseId: this.testCaseId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = this.orderBy;
        obj.data.runType = 'DEVELOPMENT';
        this.readRunResultProjectTestCaseRuns(obj);
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'runCreatedAt desc';
        }
        this.getMessageDetails();
      },
      cellStyle({row, column, rowIndex, columnIndex}) {
        if (row.runStatus == 'PASS' && columnIndex == 3) {
          if (row.resultOverwritten && row.resultOverwritten == 1) {
            return 'pass_css_orange'
          } else {
            return 'pass_css'
          }
        }
        if (row.runStatus == 'ERROR' || row.runStatus == 'FAIL') {
          if (columnIndex == 3) {
            return 'fail_css';
          }
        }
        if (row.runStatus == 'NEW' && columnIndex == 3) {
          return 'new_css'
        }
        if (row.runStatus == 'WIP' && columnIndex == 3) {
          return 'wip_css'
        }
        if (row.runStatus == 'TERMINATED' && columnIndex == 3) {
          return 'terminated_css'
        }
      },
      terminateTestCaseRunById(row) {
        this.terminateTestCaseRun(row).then((res) => {
          this.$notify({
            title: this.lang.dialog.title.success,
            message: this.lang.dialog.title.testcase_stop_success,
            type: 'success'
          });
        }, (err) => {
          console.log(err);
        });
      },
      ViewTask(row) {
        this.ViewTaskByRunId(row.runId).then((res) => {
          window.location.href = '/ems/Task?uuid=' + res.data[0] + '&tasks';
        })
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
      this.testCaseId = window.location.pathname.split('/')[6];
      this.getMessageDetails();
      const param = {
        id: this.testCaseId
      };
      this.readTestCaseResultForMessage(param).then((res) => {
        this.projectTestCaseResultMessage = res.data[0];
      }, (err) => {
        console.log(err);
      });
      const thiz = this;
      this.setLoop = setInterval(function() {
        thiz.getMessageDetails();
      }, 60000)
    },
    destroyed() {
      clearInterval(this.setLoop);
    }
  };
</script>


