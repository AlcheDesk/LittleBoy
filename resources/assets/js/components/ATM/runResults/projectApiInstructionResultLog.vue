<template>
  <div style="background-color: #eee;">
    <project-tool-bar :messageInfo="projectTestCaseResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/RunResult/Project/?page=1+25'>{{ lang.breadcrumb.project_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a style="font-weight: 500;" :href="'/atm/RunResult/Project/' + projectId + '/TestCase/?page=1+25'">{{ lang.breadcrumb.result_detail }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a style="font-weight: 500;" :href="'/atm/RunResult/Project/' + projectId + '/TestCase/' + testCaseId + '/Runs/?page=1+25'">{{ lang.breadcrumb.case_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a style="font-weight: 500;" :href="'/atm/RunResult/Project/' + projectId + '/TestCase/' + testCaseId + '/Runs/' + runId + '/Instruction/?page=1+25'">{{ lang.breadcrumb.step_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.api_detail }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
    </project-tool-bar>

    <el-row :gutter="20" class="api_name_row">
      <el-col :span="2" style="padding: 5px 0px;">
        <span>{{ lang.dialog.title.api_name }}:</span>
      </el-col>
      <el-col :span="22" style="text-align: left;">
        <span>{{ apiInstructionResult.name }}</span>
        <el-button class="el_button_open" @click="NavigatorToInstruction" size="mini" style="margin-left: 30px;">{{ lang.dialog.title.view_api }}</el-button>
      </el-col>
    </el-row>
    <el-row :gutter="20" class="api_name_row">
      <el-col :span="2">
        <span>{{ apiInstructionResult.method }}:</span>
      </el-col>
      <el-col :span="22" style="text-align: left;">
        <span>{{ apiInstructionResult.url }}</span>
      </el-col>
    </el-row>

    <div class="api_param_block">
      <el-row :gutter="20" class="json_path_row">
        <el-col :span="2">
          <span>JsonPath:</span>
        </el-col>
        <el-col :span="10" style="text-align: left;">
          <span>{{ apiInstructionResult.jsonPath || '' }}</span>
        </el-col>
        <el-col :span="2">
          <span>ExpectedValue:</span>
        </el-col>
        <el-col :span="10" style="text-align: left;">
          <span>{{ apiInstructionResult.expectedValue || '' }}</span>
        </el-col>
      </el-row>
      <el-row :gutter="20" class="query_row">
        <el-col :span="12" class="border_right">
          <el-row class="api_text">
            <span>Query parameter</span>
          </el-row>
          <template v-for="(item, index) in apiInstructionResult.query">
            <el-row :gutter="20" class="query_content">
              <el-col :span="12">
                <el-input v-model="item.key" disabled placeholder="" size="small"></el-input>
              </el-col>
              <el-col :span="12">
                <el-input v-model="item.value" disabled placeholder="" size="small"></el-input>
              </el-col>
            </el-row>
          </template>
          <el-row class="api_text">
            <span>Headers</span>
          </el-row>
          <template v-for="(item, index) in apiInstructionResult.headers">
            <el-row :gutter="20" class="query_content">
              <el-col :span="12">
                <el-input v-model="item.key" disabled placeholder="" size="small"></el-input>
              </el-col>
              <el-col :span="12">
                <el-input v-model="item.value" disabled placeholder="" size="small"></el-input>
              </el-col>
            </el-row>
          </template>
        </el-col>
        <el-col :span="12">
          <el-row class="api_text">
            <span>Body</span>
          </el-row>
          <el-row class="query_content api_text">
            <el-col :span="24">
              <el-input type="textarea" v-model="apiInstructionResult.body" disabled :autosize="{ minRows: 5}"></el-input>
            </el-col>
          </el-row>
        </el-col>
      </el-row>
    </div>

    <el-row class="result_block">
      <el-col :span="3" class="border_right">{{ lang.dialog.title.run_result }}</el-col>
      <el-col :span="21">{{ responseCode }}</el-col>
    </el-row>
    <el-row class="json_path_row">
      <el-col :span="10">
        <el-radio-group v-model="headerOrJsonPath" size="small">
          <el-radio-button label="HEADERS"></el-radio-button>
          <el-radio-button label="JsonPath"></el-radio-button>
        </el-radio-group>
      </el-col>
      <el-col :span="14">
        <h4>BODY</h4>
      </el-col>
    </el-row>


    <el-row class="result_return">
      <el-col :span="10" class="result_col border_right">
        <template v-if="headerOrJsonPath == 'HEADERS'">
          <div class="response_block" v-for="key in resquestHeader">
            <div :title="key.split(':')[0]" class="response_key">
              {{key.split(':')[0]}}:
            </div>
            <div :title="key.split(':')[1]" class="response_value">
              {{key.split(':')[1]}}
            </div>
          </div>
        </template>
        <template v-if="headerOrJsonPath == 'JsonPath'">
          <div class="response_block">
            <p>{{JsonPathContent}}</p>
          </div>
        </template>
      </el-col>
      <el-col :span="14" class="result_col">
        <div class="response_block">
          <p>{{responseBody}}</p>
        </div>
      </el-col>
    </el-row>
    <div class="api_footer"></div>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    props: ['message'],
    data() {
      return {
        projectId: null,
        testCaseId: null,
        runId: null,
        permissionRule: {},
        lang: {},
        projectTestCaseResultMessage: {},
        apiInstructionResult: {
          id: null,
          name: '',
          url: '',
          method: '',
          query: [{
            key: '',
            value: ''
          }],
          headers: [{
            key: '',
            value: ''
          }],
          body: '',
          jsonPath: '',
        },
        JsonPathContent: '',
        responseBody: '',
        resquestHeader: '',
        responseCode: null,
        headerOrJsonPath: 'HEADERS',
        instructionId: null
      }
    },
    methods: {
      ...mapActions(['readTestCaseResultForMessage']),
      NavigatorToInstruction() {
        const row = JSON.parse(localStorage.getItem('instructionResultData'));
        localStorage.setItem('apiInstructionData', JSON.stringify(row.instruction));
        localStorage.setItem('apiInstructionType', 'edit');
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/ApiTest';
        // localStorage.removeItem('instructionResultData')
      },
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
      const param = {
        id: this.testCaseId
      };
      this.readTestCaseResultForMessage(param).then((res) => {
        this.projectTestCaseResultMessage = res.data[0];
      }, (err) => {
        console.log(err);
      });
      const row = JSON.parse(localStorage.getItem('instructionResultData'));
      this.apiInstructionResult.name = row.instruction.data.apiName;
      this.apiInstructionResult.id = row.instruction.id;
      this.apiInstructionResult.method = row.instruction.data.method || '';
      this.apiInstructionResult.body = row.instruction.data.body || '';
      this.apiInstructionResult.url = row.instruction.data.url || '';
      this.apiInstructionResult.jsonPath = row.instruction.data.jsonPathPackage.jsonPath || null;
      this.apiInstructionResult.expectedValue = row.instruction.data.jsonPathPackage.expectedValue || null;
      this.apiInstructionResult.query = [];
      this.apiInstructionResult.headers = [];
      for (let [key, value] of Object.entries(row.instruction.data.queryParameters)) {
        const query = {};
        query.key = key;
        query.value = value;
        this.apiInstructionResult.query.push(query);
      }
      for (let [key, value] of Object.entries(row.instruction.data.requestHeaders)) {
        const headers = {};
        headers.key = key;
        headers.value = value;
        this.apiInstructionResult.headers.push(headers);
      }
      this.apiInstructionResult.query.push({
        key: '',
        value: ''
      });
      this.apiInstructionResult.headers.push({
        key: '',
        value: ''
      });
      this.responseBody = row.outputData;
      this.JsonPathContent = row.outputParameter.jsonPathResult || '';
      this.responseCode = row.outputParameter.code;
      this.resquestHeader = row.outputParameter.responseHeaders;
      this.instructionId = row.instruction.id;
    }
  };
</script>

