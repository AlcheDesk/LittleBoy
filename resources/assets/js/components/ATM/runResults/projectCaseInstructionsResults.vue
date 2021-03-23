<template>
  <div>
    <el-row :gutter="20" style="height: 100px;">
      <el-col :span="8" class="test_setting instruction_result_toorbar_item text_ellipsis">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a href='/atm/RunResult/Project/?page=1+25'>{{ lang.breadcrumb.project_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a :href="'/atm/RunResult/Project/' + projectId + '/TestCase/?page=1+25'">{{ lang.breadcrumb.result_detail }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a :href="'/atm/RunResult/Project/' + projectId + '/TestCase/' + testCaseId + '/Runs/?page=1+25'">{{ lang.breadcrumb.case_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.step_result }}</el-breadcrumb-item>
        </el-breadcrumb>
      </el-col>
      <el-col :span="4" class="name instruction_result_toorbar_item">
        <el-popover
          ref="name"
          placement="top"
          trigger="click">
          <div>NO.{{projectTestCaseResultMessage.testCaseId}} <br/> {{projectTestCaseResultMessage.testCaseName}}<!-- /{{projectTestCaseRunResultMessage.testCaseOverwriteName }} --></div>
        </el-popover>
        <div class="text_ellipsis" v-popover:name>NO.{{projectTestCaseResultMessage.testCaseId}} <br/> {{projectTestCaseResultMessage.testCaseName}}<!-- /{{projectTestCaseRunResultMessage.testCaseOverwriteName}} --></div>
      </el-col>
      <el-col :span="4" class="instruction_result_toorbar_item">
        <el-popover
          ref="createdAt"
          placement="top"
          trigger="click">
          <div>{{ lang.table.create_at }}: {{projectTestCaseResultMessage.latestRunCreatedAt}}</div>
        </el-popover>
        <div class="text_ellipsis" v-popover:createdAt>{{ lang.table.create_at }}: {{projectTestCaseResultMessage.latestRunCreatedAt}}</div>
      </el-col>
      <el-col :span="4" class="instruction_result_toorbar_item">
        <el-popover
          ref="runAt"
          placement="top"
          trigger="click">
          <div>{{ lang.table.run_date }}: {{projectTestCaseRunResultMessage.runCreatedAt}}</div>
        </el-popover>
        <div class="text_ellipsis" v-popover:runAt>{{ lang.table.run_date }}: {{projectTestCaseRunResultMessage.runCreatedAt}}</div>
      </el-col>
      <el-col :span="4" class="percentage test_setting">
        <el-progress type="circle" :percentage="percentage" :width="65"></el-progress>
        <div>{{ lang.table.pass_rate }}</div>
      </el-col>
    </el-row>

    <search-pagination :total="total" layout="id, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getRunResultProjectTestCaseRunInstructions.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @row-dblclick="viewInstaructionResults"
          @sort-change="sortChange"
          :cell-class-name="cellStyle">
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.id"
            prop="logicalOrderIndex"
            width="150"
            show-overflow-tooltip
            sortable="custom">
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.target"
            align="left"
            prop="target"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="scope.row.instruction.type == 'WebFunction'">
                <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);">{{ lang.operator.web_function }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-if="scope.row.instruction.type == 'VirtualWebFunction'">
                <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);">{{ lang.operator.virtual_web_function }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.instruction.type == 'Performance'">
                <el-button class="button_text" style="background-color: #5780a9; color: white; transform: translate(0px, 0px);">{{ lang.operator.performance }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.instruction.type == 'Manual'">
                <el-button class="button_text" style="background-color: #129a92; color: white; transform: translate(0px, 0px);">{{ lang.operator.manual }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.instruction.type == 'Reference'">
                <el-button class="button_text" style="background-color: #5780a9; color: white; transform: translate(0px, 0px);">{{ lang.operator.reference }}</el-button>
                <span style="color: #129a92;">{{ lang.operator.reference_message }}</span> <span style="color: #5780a9; font-size: 20px; font-weight: 600;">{{scope.row.target}}</span>
              </template>
              <template v-else-if="scope.row.instruction.type == 'REST_API'">
                <el-button class="button_text" style="background-color: #828c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.rest_api }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.instruction.type == 'WebBrowser'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.web_browser }}</el-button>
                {{ lang.operator.web_browser + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'VirtualWebBrowser'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.virtual_web_browser }}</el-button>
                {{ lang.operator.virtual_web_browser + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'SQL'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.sql }}</el-button>
                {{ lang.operator.sql + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'JavaScript'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.javascript }}</el-button>
                {{ lang.operator.javascript + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'StringDataProcessor'">
                <el-button class="button_text" style="background-color: #628c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.processor }}</el-button>
                {{ lang.table.string_check }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'MathExpressionProcessor'">
                <el-button class="button_text" style="background-color: #628c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.processor }}</el-button>
                {{ lang.table.math_check }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'Redis'">
                <el-button class="button_text" style="background-color: #041f28; color: white; transform: translate(0px, 0px);">{{ lang.operator.redis }}</el-button>
                {{ scope.row.target }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'CheckEmail'">
                <el-button class="button_text email_button text_white" style="transform: translate(0px, 0px);">{{ lang.operator.email }}</el-button>
                {{ lang.operator.email + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.instruction.type == 'RPC_Dubbo'">
                <el-button class="button_text" style="background-color: #dc78e9; color: white; transform: translate(0px, 0px);">{{ lang.operator.rpc_dubbo }}</el-button>
                {{ lang.operator.rpc_dubbo + lang.table.operating }}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.action"
            width="150"
            prop="action">
            <template slot-scope="scope">
              <template v-if="scope.row.instruction.type == 'Redis'">
                {{ scope.row.instruction.action }}
              </template>
              <template v-else>
                {{ scope.row.instruction.action }}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.status"
            width="150"
            prop="status">
          </el-table-column>
        <!--   <el-table-column
            :resizable="true"
            label="TestCaseOverwrite"
            align="left">
            <template slot-scope="scope">
              {{projectTestCaseRunResultMessage.testCaseOverwrite ? projectTestCaseRunResultMessage.testCaseOverwrite.name : 'Null'}}
            </template>
          </el-table-column> -->
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.create_at"
            sortable="custom"
            prop="createdAt"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.comment"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{scope.row.instruction.comment ? scope.row.instruction.comment : ''}}
            </template>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>

    <el-dialog  :title="lang.dialog.title.run_log"  :visible.sync="viewStepLogsDialog">
      <el-table
        :data="getRunResultProjectTestCaseRunInstructionlog.data">
        <el-table-column
          align="center"
          :resizable="true"
          :label="lang.table.run_date"
          width="200"
          prop="createdAt"
          show-overflow-tooltip>
        </el-table-column>
        <el-table-column
          :resizable="true"
          align="center"
          :label="lang.dialog.title.log_info"
          prop="message">
        </el-table-column>
      </el-table>
      <div slot="footer" class="dialog-footer">
        <template v-if="instructionType === 'REST_API'">
          <el-button type="button_text_table el_button_open" @click="viewApiInstaructionResultInfo">{{ lang.dialog.title.detail }}</el-button>
        </template>
        <template v-else>
          <template v-if="instructionType === 'WebFunction' || instructionType === 'VirtualWebFunction' || instructionType === 'WebBrowser' || instructionType === 'VirtualWebBrowser'">
            <el-button type="button_text_table el_button_open" @click="viewInstaructionResultsImg">{{ lang.dialog.title.view_screenshot }}</el-button>
          </template>
        </template>
        <el-button type="primary" @click="viewStepLogsDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

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
        runId: null,
        permissionRule: {},
        lang: {},
        projectTestCaseRunResultMessage: {},
        projectTestCaseResultMessage: {},
        percentage: 0,
        viewStepLogsDialog: false,
        queryObj: {
          ids: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        orderBy: 'createdAt desc',
        logicalOrderIndex: null,
        instructionType: '',
        instructionId: null
      }
    },
    computed: {
      ...mapGetters(['getRunResultProjectTestCaseRunInstructions', 'getRunResultProjectTestCaseRunInstructionlog', 'getRunResultProjectTestCaseRunInstructionlog'])
    },
    watch: {
      getRunResultProjectTestCaseRunInstructions: function() {
        this.total = this.getRunResultProjectTestCaseRunInstructions.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readRunResultProjectTestCaseInstructions', 'readRunResultProjectTestCaseInstructionLogs', 'readTestCaseResultForMessage', 'readRunResultForMessage']),
      changeRowStyle(row, index) {
        if (!row.hasOwnProperty('target')) {
          return {
            background: '#7d95ae'
          }
        }
        return {};
      },
      getMessageDetails() {
        const obj = {
          runId: this.runId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = this.orderBy;
        obj.data.mode = 'PRODUCTION';
        this.readRunResultProjectTestCaseInstructions(obj);
      },
      viewInstaructionResults(row) {
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
      viewApiInstaructionResultInfo() {
        window.location.href = '/atm/RunResult/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/Runs/' + this.runId + '/Instruction/' + this.instructionId + '/ApiLog';
      },
      viewInstaructionResultsImg() {
        this.viewStepLogsDialog = false;
        var url = '/result/' + this.runId + '/' + this.logicalOrderIndex + '/';
        window.open(url);
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
      this.runId = window.location.pathname.split('/')[8];
      this.getMessageDetails();
      const param = {
        id: this.runId
      };
      this.readRunResultForMessage(param).then((res) => {
        this.projectTestCaseRunResultMessage = res.data[0];
        this.percentage = parseInt(this.projectTestCaseRunResultMessage.success / this.projectTestCaseRunResultMessage.total * 100) || 0;
      }, (err) => {
        console.log(err);
      })
      const param1 = {
        id: this.testCaseId
      };
      this.readTestCaseResultForMessage(param1).then((res) => {
        this.projectTestCaseResultMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>

