<template>
  <div>
    <search-pagination
      :total="total"
      :layout=layout
      :lang="lang"
      :pagination="pagination"
      :changePageToUrl="changePageToUrl"
      @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          border
          :data="tableData"
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
          <template v-if="runType == 'runList'">
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
          </template>
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
            :label="lang.table.run_date"
            sortable="custom"
            prop="runCreatedAt"
            show-overflow-tooltip>
              <template slot-scope="scope">
                <template v-if="runType == 'testCaseRun'">
                  <i class="icon_r"></i>
                </template>
                {{ scope.row.runCreatedAt ? scope.row.runCreatedAt : lang.table.not_run}}
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
          <template v-if="runType == 'testCaseRun' || !changePageToUrl">
            <el-table-column
              :label="lang.table.operating"
              :resizable="true"
              align="left">
              <template slot-scope="scope">
                <template v-if="runType == 'testCaseRun'">
                  <template v-if="!scope.row.finished">
                    <el-button class="button_text_table" @click='terminateTestCaseRunById(scope.row)'>{{ lang.operator.terminate_operation }}</el-button>
                  </template>
                  <el-button class="button_text_table" @click='ViewTask(scope.row)'>{{ lang.operator.view_task }}</el-button>
                </template>
                <template v-if="!changePageToUrl">
                  <el-button class="button_text_table" @click="runDetailReport(scope.row)">{{ lang.operator.view_report }}</el-button>
                </template>
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </search-pagination>

    
    <run-report
      layout=""
      pagination="total, sizes, prev, pager, next, jumper"
      :lang="lang"
      :changePageToUrl="false"
      :reportDetails="runDetails"
      @closeDialog="cancelReportDetailData">
    </run-report>
  </div>
</template>


<script>
  import runReport from '../runListReport/runReport.vue'
  
  export default {
    props: {
      lang: {
        default: {},
      },
      layout: {
        default: ''
      },
      pagination: {
        default: ""
      },
      total: {
        default: 0,
      },
      tableData: {
        default: function () {
          return [];
        },
      },
      runType: {
        default: null,
      },
      changePageToUrl: {
        default: true,
      }
    },
    data() {
      return {
        column: null,
        runDetails: {}
      };
    },
    components: { runReport },
    methods: {
      cellStyle({row, column, rowIndex, columnIndex}) {
        if (this.runType === 'runList') {
          this.column = 4;
        } else {
          this.column = 3;
        }
        if (row.runStatus == 'PASS' && columnIndex == this.column) {
          if (row.resultOverwritten && row.resultOverwritten == 1) {
            return 'pass_css_orange'
          } else {
            return 'pass_css'
          }
        }
        if (row.runStatus == 'ERROR' || row.runStatus == 'FAIL') {
          if (columnIndex == this.column) {
            return 'fail_css';
          }
        }
        if (row.runStatus == 'NEW' && columnIndex == this.column) {
          return 'new_css'
        }
        if (row.runStatus == 'WIP' && columnIndex == this.column) {
          return 'wip_css'
        }
        if (row.runStatus == 'TERMINATED' && columnIndex == this.column) {
          return 'terminated_css'
        }
      },
      NavigationToCaseInstructionsResults(row) {
        this.$emit('navigator', row);
      },
      sortChange(column) {
        this.$emit('changeSortParam', column)
      },
      getSearchPaginationModel(val) {
        this.$emit('searchChange', val);
      },
      //testCaseRun
      terminateTestCaseRunById(row) {
        this.$emit('terminate', row);
      },
      ViewTask(row) {
        this.$emit('navigatorTask', row);
      },
      runDetailReport(row) {
        this.runDetails = {};
        this.runDetails = row;
      },
      cancelReportDetailData() {
        this.runDetails = {};
      }
    },
  };
</script>