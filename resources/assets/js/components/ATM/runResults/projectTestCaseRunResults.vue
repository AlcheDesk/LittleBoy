<template>
  <div>
    <project-tool-bar :messageInfo="projectTestCaseResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/RunResult/Project/?page=1+25'>{{ lang.breadcrumb.project_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a style="font-weight: 500;" :href="'/atm/RunResult/Project/' + projectId + '/TestCase/?page=1+25'">{{ lang.breadcrumb.result_detail }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.case_result }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
    </project-tool-bar>

    
    <run-template
      layout="id, startDate, endDate, operation, driver, overwrite"
      pagination="total, sizes, prev, pager, next, jumper"
      runType="testCaseRun"
      :total="total"
      :lang="lang"
      :tableData="getRunResultProjectTestCaseRuns.data"
      :changePageToUrl="true"
      @navigator="NavigationToCaseInstructionsResults"
      @changeSortParam="sortChange"
      @searchChange="getSearchPaginationModel"
      @terminate="terminateTestCaseRunById"
      @navigatorTask="ViewTask">
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
    components: { runTemplate },
    watch: {
      getRunResultProjectTestCaseRuns: function() {
        this.total = this.getRunResultProjectTestCaseRuns.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readRunResultProjectTestCaseRuns', 'readTestCaseResultForMessage', 'terminateTestCaseRun', 'ViewTaskByRunId']),
      NavigationToCaseInstructionsResults(row) {
        window.location.href = '/atm/RunResult/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/Runs/' + row.runId + '/Instruction?page=1+25';
      },
      getMessageDetails() {
        const obj = {
          testCaseId: this.testCaseId
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

