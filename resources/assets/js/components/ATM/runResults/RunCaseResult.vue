<template>
  <div>
    <project-tool-bar :messageInfo="projectResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/RunResult/RunList/?page=1+25'>{{ lang.breadcrumb.list_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.result_detail }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="operation">
        <el-button class="button_text_table el_button_summary_result" @click="resetSearch">{{ lang.operator.summary_result }}</el-button>
        <template v-if="rollBackStatus">
          <el-button class="button_text_table el_button_project_overview" @click="rollBackRunSetFailTestCases">{{ lang.operator.error_testcase_callback }}</el-button>
        </template>
        <template v-else>
          <el-button class="button_text_table el_button_error_testcase" @click="readTestCaseResultFailSearch">{{ lang.operator.error_testcase }}</el-button>
        </template>
      </div>
    </project-tool-bar>

    <run-template
      layout="id, name, startDate, endDate, operation, driver, overwrite"
      pagination="total, sizes, prev, pager, next, jumper"
      runType="runList"
      :total="total"
      :lang="lang"
      :tableData="getRunCaseResult.data"
      @navigator="NavigationToCaseInstructionsResults"
      @changeSortParam="sortChange"
      @searchChange="getSearchPaginationModel">
    </run-template>

  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import runTemplate from './runResultsTemplate/runTemplate.vue'

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
    components: { runTemplate },
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
        window.location.href = '/atm/RunResult/Project/' + row.runProjectId + '/TestCase/' + row.testCaseId + '/Runs/' + row.runId + '/Instruction?page=1+25';
      },
      getMessageDetails() {
        const obj = {
          runSetId: this.runId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            if (i == 'ids') {
              obj.data.runIds = this.queryObj[i];
            } else if (i == 'name') {
              obj.data.runName = '%' + this.queryObj[i] + '%';
            } else if (i == 'testCaseOverwriteName') {
              obj.data.testCaseOverwriteName = '%' + this.queryObj[i] + '%';
            } else if (i == 'driverPackName') {
              obj.data.driverPackName = '%' + this.queryObj[i] + '%';
            } else if (i == 'startDate') {
              obj.data.runStartDate = this.queryObj[i];
            } else if (i == 'endDate') {
              obj.data.runEndDate = this.queryObj[i];
            } else {
              obj.data[i] = this.queryObj[i];
            }
          }
        }
        obj.data.orderBy = this.orderBy;
        obj.data.runType = 'PRODUCTION';
        if (this.falseResult) {
          obj.data.statusNotIn = 'PASS';
          obj.data.location = true;
        }
        this.readRunCaseResults(obj);
      },
      resetSearch() {
        localStorage.removeItem('runListCaseFalseResult');
        this.falseResult = false;
        this.rollBackStatus = false;
        this.getMessageDetails();
      },
      readTestCaseResultFailSearch() {
        localStorage.setItem('runListCaseFalseResult', true);
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
      getSearchPaginationModel(val) {
        this.queryObj = val;
        this.getMessageDetails();
      }
    },
    created: function () {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
      this.falseResult = localStorage.getItem('runListCaseFalseResult') || false;
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

