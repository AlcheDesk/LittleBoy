<template>
  <div>
    <el-dialog class="dialog" :close-on-press-escape="false" :append-to-body="true" :show-close="false" :destroy-on-close="true" :close-on-click-modal="false" :visible.sync="listReportDetailsDialog">
      <div slot="title" class="dialog-title">
         {{ lang.dialog.title.view_report_details }}
        <template v-if="falseResult">
          <el-button style="float: right; margin-right:30px;" class="button_text_table el_button_summary_result" @click="resetSearch">{{ lang.operator.summary_result }}</el-button>
        </template>
        <template v-else>
          <el-button style="float: right; margin-right:30px;" class="button_text_table el_button_error_testcase" @click="readTestCaseResultFailSearch">{{ lang.operator.error_testcase }}</el-button>
        </template>
      </div>

      <!-- content -->
      <div class="report_container">
        <div class="list_content">
          <div class="list_name">
            <label>{{ lang.dialog.title.list_name }}：</label>
            <span>{{reportDetails.name}}</span>
          </div>
          <div class="list_status">
            <label>{{ lang.table.success_total }}：</label>
            <span>{{reportDetails.passedRunNumber}}/{{reportDetails.totalRunNumber}}</span>
          </div>
          <div class="list_status">
            <label>{{ lang.table.error }}：</label>
            <span>{{reportDetails.failedRunNumber}}</span>
          </div>
          <div class="list_status">
            <label>{{ lang.table.status }}：</label>
            <template v-if="reportDetails.status == 'FAIL' || reportDetails.status == 'ERROR'">
             <span class="text_fail">{{reportDetails.status}}</span>
            </template>
            <template v-else-if="reportDetails.status == 'PASS'">
              <span class="text_success">{{reportDetails.status}}</span>
            </template>
            <template v-else-if="reportDetails.status == 'WIP'">
              <span class="text_wip">{{reportDetails.status}}</span>
            </template>
            <template v-else>
              <span>{{reportDetails.status}}</span>
            </template>
            </div>
          </div>
          <div class="list_content">
            <label>{{ lang.table.run_date }}：</label>
            <span>{{new Date(reportDetails.startAt).toLocaleString()}}</span>
          </div>
          <div class="list_content">
            <div class="list_status">
              <label>{{ lang.table.comment }}：</label>
            </div>
            <div class="list_comment">
              <span>{{reportDetails.comment}}</span>
            </div>
          </div>
          <div class="list_content">
            <div class="case_block">
              <run-template
                :layout="layout"
                :changePageToUrl="false"
                :pagination="pagination"
                :runType="runType"
                :total="total"
                :lang="lang"
                :tableData="caseRunData"
                @searchChange="getSearchPaginationModel"
                @changeSortParam="sortChange">
              </run-template>
            </div>
          </div>
        </div>

      <div slot="footer" class="dialog-footer">
        <el-button @click="closeDialog">{{ lang.operator.cancel }}</el-button>
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
    runType: {
      default: null,
    },
    reportDetails: {
      default: {}
    },
  },
  data() {
    return {
      caseRunData: [],
      total: null,
      listReportDetailsDialog: false,
      queryObj: {
        ids: '',
        name: '',
        startDate: '',
        endDate: '',
        pageNumber: 1,
        pageSize: 25,
      },
      total: 0,
      orderBy: 'runCreatedAt desc',
      falseResult: false,
    }
  },
  watch: {
    reportDetails: function () {
      if (this.reportDetails && this.reportDetails.name) {
        this.getMessageDetails();
        this.listReportDetailsDialog = true;
      } else {
        this.listReportDetailsDialog = false;
      }
    },
    getRunCaseResult: function () {
      this.caseRunData = [];
      this.caseRunData = this.getRunCaseResult.data || [];
      this.total = this.getRunCaseResult.metadata.count || 0;
      if (this.falseResult) {
        if (this.getRunCaseResult.metadata.count == 0) {
          this.$notify.info({
            title: this.lang.dialog.title.prompt,
            message: this.lang.dialog.title.no_error_testcase
          });
        }
      }
    },
    getRunResultProjectTestCaseRuns: function () {
      this.caseRunData = [];
      this.caseRunData = this.getRunResultProjectTestCaseRuns.data || [];
      this.total = this.getRunResultProjectTestCaseRuns.metadata.count || 0;
    }
  },
  computed: {
    ...mapGetters(['getRunResultProjectTestCaseRuns', 'getRunCaseResult'])
  },
  components: { runTemplate },
  methods: {
    ...mapActions(['readRunCaseResults', 'readRunResultProjectTestCaseRuns']),
    getMessageDetails() {
      const obj = {};
      obj.data = {
        location: true
        };
      for (var i in this.queryObj) {
        if (this.queryObj[i] != '') {
          if (i == 'ids') {
            obj.data.runIds = '%' + this.queryObj[i] + '%';
          } else if (i == 'name') {
            obj.data.runName = '%' + this.queryObj[i] + '%';
          } else {
            obj.data[i] = this.queryObj[i];
          }
        }
      }
      obj.data.orderBy = this.orderBy;
      obj.data.runType = 'PRODUCTION';
      if (this.falseResult) {
        obj.data.statusNotIn = 'PASS';
      }
      if (this.runType == 'runList') {
        obj.runSetId = this.reportDetails.id;
        this.readRunCaseResults(obj);
      }
      if (this.runType == 'testCaseRun') {
        obj.testCaseId = this.reportDetails.testCaseId;
        this.readRunResultProjectTestCaseRuns(obj);
      }
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
    getSearchPaginationModel(val) {
      this.queryObj = val;
      this.getMessageDetails();
    },
    closeDialog() {
      this.listReportDetailsDialog = false;
      this.$emit('closeDialog');
    },
    resetSearch() {
      localStorage.removeItem('runListCaseFalseResult');
      this.falseResult = false;
      this.getMessageDetails();
    },
    readTestCaseResultFailSearch() {
      localStorage.setItem('runListCaseFalseResult', true);
      this.falseResult = true;
      this.getMessageDetails();
    },
  },
  created: function () {
    this.falseResult = localStorage.getItem('runListCaseFalseResult') || false;
  },
}
</script>