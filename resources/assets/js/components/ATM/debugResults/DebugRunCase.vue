<template>
  <div>
    <project-tool-bar :messageInfo="projectResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/DebugResult/RunList/?page=1+25'>{{ lang.breadcrumb.list_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.result_detail }}
          </el-breadcrumb-item>
        </el-breadcrumb>
      </div>
    </project-tool-bar>

    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getRunCaseResult.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'runCreatedAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="NavigationToCaseInstructionsResults"
          :cell-class-name="cellStyle">
          <el-table-column
            :resizable="true"
            :label="lang.table.id"
            align="left"
            prop="runId"
            show-overflow-tooltip
            sortable="custom">
            <template slot-scope="scope">
              NO.{{ scope.row.runId }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.name"
            show-overflow-tooltip
            sortable="custom"
            prop="runName"
            align="left">
            <template slot-scope="scope">
              <i class="icon_r"></i>
              {{scope.row.runName}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.run_date"
            sortable="custom"
            prop="runCreatedAt"
            show-overflow-tooltip>
              <template slot-scope="scope">
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
            class-name="column_color_2"
            prop="instructionFailCount"
            show-overflow-tooltip>
            <!-- <template slot-scope="scope">
              {{ scope.row.instructionExecutedCount - scope.row.instructionPassCount }}
            </template> -->
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
        </el-table>
      </template>
    </search-pagination>

  </div>
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
        runId: null,
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
        orderBy: 'runCreatedAt desc',
        falseResult: false,
        rollBackStatus: false,
        setLoop: null
      }
    },
    computed: {
      ...mapGetters(['getRunCaseResult'])
    },
    watch: {
      getRunCaseResult: function() {
        this.total = this.getRunCaseResult.metadata.count;
        if (this.falseResult) {
          if (this.getRunCaseResult.metadata.count) {
            this.rollBackStatus = true;
          } else {
            this.$notify.info({
              title: this.lang.dialog.title.prompt,
              message: this.lang.dialog.title.no_error_testcase
            });
          }
        }
      }
    },
    methods: {
      ...mapActions(['readRunCaseResults', 'readRunListResultForMessage', 'rollBackRunList']),
      NavigationToCaseInstructionsResults(row) {
        window.location.href = '/atm/DebugResult/Project/' + row.runProjectId + '/TestCase/' + row.testCaseId + '/Runs/' + row.runId + '/Instruction?page=1+25';
      },
      getMessageDetails() {
        const obj = {
          runSetId: this.runId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = this.orderBy;
        obj.data.mode = 'DEVELOPMENT';
        if (this.falseResult) {
          obj.data.falseResult = this.falseResult;
        }
        this.readRunCaseResults(obj);
      },
      readTestCaseResultFailSearch() {
        this.falseResult = true;
        this.getMessageDetails();
      },
      rollBackRunSetFailTestCases() {
        const obj = {
          id: this.runId
        };
        this.rollBackRunList(obj).then((res) => {
          this.rollBackStatus = false;
          this.$notify.info({
            title: this.lang.dialog.title.rerun_completed,
            message: this.lang.dialog.title.rerun_start
          });
        }, (err) => {
          console.log(err)
        })
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
        if (row.runStatus == 'PASS' && columnIndex == 4) {
          if (row.resultOverwritten && row.resultOverwritten == 1) {
            return 'pass_css_orange'
          } else {
            return 'pass_css'
          }
        }
        if (row.runStatus == 'ERROR' || row.runStatus == 'FAIL') {
          if (columnIndex == 4) {
            return 'fail_css';
          }
        }
        if (row.runStatus == 'NEW' && columnIndex == 4) {
          return 'new_css'
        }
        if (row.runStatus == 'WIP' && columnIndex == 4) {
          return 'wip_css'
        }
        if (row.runStatus == 'TERMINATED' && columnIndex == 4) {
          return 'terminated_css'
        }
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
      this.runId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
      const runList = {
        id: this.runId
      };
      this.readRunListResultForMessage(runList).then((res) => {
        this.projectResultMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
      const thiz = this;
      this.setLoop = setInterval(function() {
        thiz.getMessageDetails();
      }, 60000);
    },
    destroyed() {
      clearInterval(this.setLoop);
    }
  };
</script>

