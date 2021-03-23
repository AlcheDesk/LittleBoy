<template>
  <div>
    <el-dialog class="dialog" :close-on-press-escape="false" :append-to-body="true" :show-close="false" :destroy-on-close="true" :close-on-click-modal="false" :visible.sync="runDetailsDialog">
      <div slot="title" style="display: flex;">
        <div class="list_name" style="font-weight: 600;">
          <label>{{ lang.table.testcase_name }}：</label>
          <span>{{reportDetails.testCaseName}}</span>
        </div>
        <div class="list_status" style="font-weight: 600;">
          NO.{{reportDetails.testCaseId}}
        </div>
        <div class="list_status">
          <label>{{ lang.table.status }}：</label>
          <template v-if="reportDetails.runStatus == 'FAIL' || reportDetails.runStatus == 'ERROR'">
            <span class="text_fail">{{reportDetails.runStatus}}</span>
          </template>
          <template v-else-if="reportDetails.runStatus == 'PASS'">
            <span class="text_success">{{reportDetails.runStatus}}</span>
          </template>
          <template v-else-if="reportDetails.runStatus == 'WIP'">
            <span class="text_wip">{{reportDetails.runStatus}}</span>
          </template>
          <template v-else>
            <span>{{reportDetails.runStatus}}</span>
          </template>
        </div>
        <div class="list_status">
          <label>{{ lang.table.overwrite }}：</label>
          <span>{{reportDetails.testCaseOverwriteName  || null }}</span>
        </div>
      </div>

      <!-- content -->
      <div class="report_container">
        <div class="list_content">
           <div class="list_status">
              <div class="list_content">
                <div class="flex_4">
                  <label>{{ lang.table.comment }}：</label>
                </div>
                <div class="list_comment">
                  <span>{{reportDetails.comment}}</span>
                </div>
              </div>
              <div class="list_content">
                <div class="flex_4">
                  <label style="font-weight: 600; color: #A6B5D9;">{{ lang.table.operating_environment }}：</label>
                </div>
                <div class="list_comment">
                  <div>{{ reportDetails.environment}}</div>
                </div>
              </div>
            </div>
            <div class="list_status" style="text-align: right;">
              <div class="list_content">
                <div class="list_status">
                  <label>{{ lang.table.run_date }}：</label>
                  <span>{{new Date(reportDetails.runCreatedAt).toLocaleString()}}</span>
                </div>
              </div>
              <div class="list_content">
                <div class="list_status">
                  <label>Group：</label>
                  <span>{{reportDetails.group}}</span>
                </div>
              </div>
              <div class="list_content">
                <div class="list_status">
                  <label>{{ lang.table.driver }}：</label>
                  <span>{{reportDetails.driverPackName}}</span>
                </div>
              </div>
              <div class="list_content">
                <div class="list_status">
                  <label>{{ lang.table.trigger_source }}：</label>
                  <span>{{reportDetails.triggerSource}}</span>
                </div>
              </div>
              <div class="list_content">
                <div class="list_status">
                  <el-button class="button_text_table" @click="showDevInfoDialog">{{ lang.dialog.title.code_info }}</el-button>
                </div>
              </div>
           </div>
          </div>
          <div class="list_content">
            <label style="font-weight: 600; color: #A6B5D9;">{{ lang.dialog.title.step }}：</label>
          </div>
          <div class="list_content">
            <div class="case_block">
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
                    :data="getRunResultProjectTestCaseRunInstructions.data"
                    style="width: 100%"
                    row-class-name="row_css"
                    :cell-class-name="cellStyle">
                    <el-table-column
                      :resizable="true"
                      :label="lang.dialog.title.step"
                      align="left"
                      min-width="300"
                      show-overflow-tooltip>
                      <template slot-scope="scope">
                        <span>{{ scope.row.logicalOrderIndex }}.{{scope.row.target}} >> {{scope.row.action}} >> {{scope.row.inputData}}</span>
                        <span> {{ lang.dialog.title.expected_value }}: {{scope.row.expectedValue || 'N/A'}};  {{ lang.dialog.title.actual_value }}: {{scope.row.returnValue || 'N/A'}}</span>
                        <span> {{ lang.table.comment }}: {{scope.row.comment}}</span>
                      </template>
                    </el-table-column>
                    <el-table-column
                      :resizable="true"
                      :label="lang.table.action"
                      prop="action"
                      align="left"
                      show-overflow-tooltip>
                    </el-table-column>
                    <el-table-column
                      :resizable="true"
                      align="left"
                      :label="lang.table.option"
                      show-overflow-tooltip>
                        <template slot-scope="scope">
                          {{ stepOptionsTable(scope) }}
                        </template>
                    </el-table-column>
                    <el-table-column
                      :resizable="true"
                      align="left"
                      :label="lang.table.status"
                      prop="status">
                    </el-table-column>
                    <el-table-column
                      :label="lang.table.operating"
                      :resizable="true"
                      align="left">
                      <template slot-scope="scope">
                        <el-button class="button_text_table" @click='viewInstaructionResults(scope.row)'>{{ lang.dialog.title.run_log }}</el-button>
                        <template v-if="['WebFunction', 'VirtualWebFunction', 'VirtualWebBrowser', 'WebBrowser'].includes(scope.row.instruction.type)">
                          <el-button class="button_text_table" @click="viewInstaructionResultsImg(scope.row)">{{ lang.dialog.title.view_screenshot }}</el-button>
                        </template>
                      </template>
                    </el-table-column>
                  </el-table>
                </template>
              </search-pagination>
            </div>
          </div>
        </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>


    <el-dialog  :title="lang.dialog.title.run_log" :close-on-press-escape="false" :append-to-body="true" :show-close="false" :destroy-on-close="true" :close-on-click-modal="false" :visible.sync="viewStepLogsDialog">
       <div class="list_content">
        <template v-if="stepDetails.status == 'FAIL' || stepDetails.status == 'ERROR'">
          <el-button class="fail_css" size="mini" round>{{stepDetails.status}}</el-button>
        </template>
        <template v-else-if="stepDetails.status == 'PASS'">
          <el-button class="pass_css" size="mini" round>{{stepDetails.status}}</el-button>
        </template>
        <template v-else-if="stepDetails.status == 'WIP'">
          <el-button class="wip_css" size="mini" round>{{stepDetails.status}}</el-button>
        </template>
        <template v-else>
          <el-button class="new_css" size="mini" round>{{stepDetails.status}}</el-button>
        </template>
         <span style="font-weight: 600; color: black; margin-left: 15px; margin-top: 5px;">{{ lang.dialog.title.step }}：instruction {{ stepDetails.logicalOrderIndex }}.{{stepDetails.target}} >> {{stepDetails.action}} >> {{stepDetails.inputData}}</span>
       </div>
       <div style="margin: 25px;">
         <template v-for="item in getRunResultProjectTestCaseRunInstructionlog.data">
          <p>
            {{ item.createdAt  + '>>>' +  item.message }}
          </p>
         </template>
       </div>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="viewStepLogsDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.dialog.title.code_info" 
      :close-on-press-escape="false" 
      :append-to-body="true" 
      :show-close="false" 
      :destroy-on-close="true" 
      :close-on-click-modal="false" 
      :visible.sync="viewDevInfoDialog">
       <div style="margin: 25px;">
        <p>
          {{ reportDetails.devInfo }}
        </p>
       </div>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="viewDevInfoDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import runTemplate from '../runResultsTemplate/runTemplate.vue'

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
    reportDetails: {
      default: {}
    },
    changePageToUrl: {
      default: false
    }
  },
  data() {
    return {
      caseRunData: [],
      total: null,
      runDetailsDialog: false,
      queryObj: {
        ids: '',
        name: '',
        startDate: '',
        endDate: '',
        pageNumber: 1,
        pageSize: 25,
      },
      total: 0,
      viewStepLogsDialog: false,
      stepDetails: {},
      viewDevInfoDialog: false
    }
  },
  watch: {
    reportDetails: function () {
      if (this.reportDetails && this.reportDetails.testCaseName) {
        this.getMessageDetails();
        this.runDetailsDialog = true;
      } else {
        this.runDetailsDialog = false;
      }
    },
    getRunResultProjectTestCaseRunInstructions: function () {
      this.total = this.getRunResultProjectTestCaseRunInstructions.metadata.count || 0;
    }
  },
  computed: {
    ...mapGetters(['getRunResultProjectTestCaseRunInstructions', 'getRunResultProjectTestCaseRunInstructionlog'])
  },
  components: { runTemplate },
  methods: {
    ...mapActions(['readRunResultProjectTestCaseInstructions', 'readRunResultProjectTestCaseInstructionLogs']),
    getMessageDetails() {
      const obj = {
        runId: this.reportDetails.runId
      };
      obj.data = {
        location: true
      };
      for (var i in this.queryObj) {
        if (this.queryObj[i] != '') {
          obj.data[i] = this.queryObj[i];
        }
      }
      obj.data.mode = 'PRODUCTION';
      this.readRunResultProjectTestCaseInstructions(obj);
    },
    stepOptionsTable: function(scope) {
      var arr = [];
      var str = '';
      if (scope.row.instruction.instructionOptions) {
        for (let i = 0; i < scope.row.instruction.instructionOptions.length; i++) {
          if (scope.row.instruction.instructionOptions[i].valueRequired) {
            arr.push(scope.row.instruction.instructionOptions[i].name + ':' + scope.row.instruction.instructionOptions[i].value);
          } else {
            arr.push(scope.row.instruction.instructionOptions[i].name);
          }
        }
      }
      str = arr.join(',');
      return str;
    },
    cellStyle({row, column, rowIndex, columnIndex}) {
      if (row.status == 'PASS' && columnIndex == 3) {
        if (row.resultOverwritten && row.resultOverwritten == 1) {
          return 'pass_css_orange'
        } else {
          return 'pass_css'
        }
      }
      if (row.status == 'ERROR' || row.status == 'FAIL') {
        if (columnIndex == 3) {
          return 'fail_css';
        }
      }
      if (row.status == 'NEW' && columnIndex == 3) {
        return 'new_css'
      }
      if (row.status == 'WIP' && columnIndex == 3) {
        return 'wip_css'
      }
      if (row.status == 'TERMINATED' && columnIndex == 3) {
        return 'terminated_css'
      }
    },
    getSearchPaginationModel(val) {
      this.queryObj = val;
      this.getMessageDetails();
    },
    closeDialog() {
      this.runDetailsDialog = false;
      this.$emit('closeDialog');
    },
    viewInstaructionResults(row) {
      this.stepDetails = row;
      this.instructionId = row.id;
      if (row.instruction.type === 'REST_API') {
        this.instructionType = 'REST_API';
        localStorage.setItem('instructionResultData', JSON.stringify(row))
      } else {
        this.instructionType = row.instruction.type;
      }
      const obj = {
        id: row.id
      };
      obj.data = {
        mode: 'PRODUCTION',
        orderBy: 'createdAt asc'
      };
      this.readRunResultProjectTestCaseInstructionLogs(obj);
      this.viewStepLogsDialog = true;
      this.logicalOrderIndex = row.logicalOrderIndex;
    },
    viewInstaructionResultsImg(row) {
      this.viewStepLogsDialog = false;
      var url = '/result/' + row.runId + '/' + row.logicalOrderIndex + '/';
      window.open(url);
    },
    showDevInfoDialog() {
      this.viewDevInfoDialog = true;
    }
  },
}
</script>