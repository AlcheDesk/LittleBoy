<template>
  <div style="background-color: #eee;">
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a href="/atm/TestSetting/Project/?page=1+25">
              {{ lang.breadcrumb.project_lib }}
            </a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a :href="'/atm/TestSetting/Project/' + projectId + '/TestCase/?page=1+25'">
              {{ lang.breadcrumb.test_case }}
            </a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a :href="'/atm/TestSetting/Project/' + projectId + '/TestCase/' + testCaseId + '/Instruction' + hrefStr">
              {{ lang.breadcrumb.instruction }}
            </a>
          </el-breadcrumb-item>
          <template v-if="type == 'add'">
            <el-breadcrumb-item>
              {{ lang.dialog.title.add }}
            </el-breadcrumb-item>
          </template>
          <template v-else>
            <el-breadcrumb-item>
              {{ lang.dialog.title.edit }}
            </el-breadcrumb-item>
          </template>
        </el-breadcrumb>
      </div>
    </project-tool-bar>

    <el-form
      :model="jsonApiTest"
      :rules="apiTestValidation"
      ref="jsonApiTest"
      label-width="100px"
      label-position="right"
      label-suffix=":">
      <el-row class="api_name_row">
        <el-col :span="12">
          <el-form-item :label="lang.dialog.title.api_name">
            <el-select
              v-model="jsonApiTest.name"
              @change="selectApiElement"
              required
              :placeholder="lang.dialog.placeholder.enter"
              clearable
              filterable
              value-key="name"
              size="small">
              <el-option
                v-for="(item, index) in getSelectProjectApiElements"
                :key="item.label + index"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-form-item>
            <el-button
              @click="saveAsApiElementChange('jsonApiTest')"
              class="el_button_open"
              style="margin-left: -120px;"
              size="mini">
              {{ lang.dialog.title.api_save_as }}
            </el-button>
          </el-form-item>
        </el-col>
        <el-col :span="8">
          <el-form-item>
            <el-button
              size="mini"
              @click="cancelApiInstructionEdit"
              class="el_button_open"
              style="margin-left: -120px; background-color: #aaa">
              {{ lang.operator.cancel }}
            </el-button>
            <template v-if="type == 'add'">
              <el-button
                class="el_button_open"
                style="margin-left: 10px;"
                size="mini"
                @click="addApiInstruction('jsonApiTest')">
                {{ lang.operator.confirm }}
              </el-button>
            </template>
            <template v-else>
              <el-button
                class="el_button_open"
                style="margin-left: 10px;"
                @click="editApiInstruction('jsonApiTest')"
                size="mini">
                {{ lang.operator.confirm }}
              </el-button>
            </template>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row class="api_name_row">
        <el-col :span="20">
          <el-form-item prop="url">
            <el-input
              :placeholder="lang.dialog.placeholder.enter"
              clearable
              size="small"
              v-model="jsonApiTest.url"
              class="input-with-select">
              <el-select
                v-model="jsonApiTest.method"
                @change="changeSelectMethod"
                style="width: 100px;"
                size="small"
                slot="prepend"
                :placeholder="lang.dialog.placeholder.select">
                <el-option label="GET" value="GET"></el-option>
                <el-option label="POST" value="POST"></el-option>
                <el-option label="PUT" value="PUT"></el-option>
                <el-option label="PATCH" value="PATCH"></el-option>
                <el-option label="DELETE" value="DELETE"></el-option>
              </el-select>
            </el-input>
          </el-form-item>
        </el-col>
        <el-col :span="4">
          <el-form-item>
            <el-button
              @click="preOperation('jsonApiTest')"
              class="el_button_open"
              style="margin-left: -150px;"
              size="mini">
              {{ lang.dialog.title.pre_run }}
            </el-button>
          </el-form-item>
        </el-col>
      </el-row>
      <div class="api_param_block">
        <el-row :gutter="10" class="json_path_row">
          <el-col :span="8">
            <el-form-item label="JsonPath">
              <el-input
                :placeholder="lang.dialog.placeholder.enter"
                clearable
                size="small"
                v-model="jsonApiTest.jsonPath">
              </el-input>
            </el-form-item>
          </el-col>
          <el-col :span="16">
            <el-form-item :label="lang.dialog.title.expected">
              <div class="json_path_expected_block">
                <div class="block_item">
                  <el-input
                    :placeholder="lang.dialog.placeholder.enter"
                    clearable
                    size="small"
                    v-model="jsonApiTest.expectedValue">
                  </el-input>
                </div>
                <div class="block_item">
                  <el-checkbox v-model="jsonApiTest.optionFlag">
                    {{ lang.dialog.title.save_not }}
                  </el-checkbox>
                </div>
                <div class="block_item">
                  <el-input
                    :disabled="!jsonApiTest.optionFlag"
                    :placeholder="lang.dialog.placeholder.enter"
                    clearable
                    size="small"
                    v-model="jsonApiTest.optionKey">
                  </el-input>
                </div>
              </div>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row class="query_row">
          <el-row class="api_text">
            <span>Query parameters</span>
          </el-row>
          <template v-for="(item, index) in jsonApiTest.query">
            <el-row :gutter="20" class="query_content">
              <el-col :span="1" class="query_content">
                <el-checkbox v-model="item.checked"></el-checkbox>
              </el-col>
              <el-col :span="8">
                <el-input
                  v-model="item.key"
                  clearable
                  :placeholder="lang.dialog.placeholder.enter"
                  size="small">
                </el-input>
              </el-col>
              <el-col :span="8">
                <el-input
                  v-model="item.value"
                  clearable
                  :placeholder="lang.dialog.placeholder.enter"
                  size="small">
                </el-input>
              </el-col>
              <el-col :span="1" v-if="index" class="query_content">
                <i class="el-icon-error" @click="removeQuery(index)"></i>
              </el-col>
              <el-col :span="1" class="query_content">
                <i class="el-icon-circle-plus-outline" @click="addQuery" v-if="jsonApiTest.query.length && index === jsonApiTest.query.length - 1"></i>
              </el-col>
            </el-row>
          </template>
        </el-row>
        <el-row class="header_row">
          <el-col :span="12" class="header_block">
            <el-row class="api_text">
              <span>Headers</span>
            </el-row>
            <el-row :gutter="10">
              <template v-for="(item, index) in jsonApiTest.headers">
                <el-row :gutter="20" class="query_content">
                  <el-col :span="1" class="query_content">
                    <el-checkbox v-model="item.checked"></el-checkbox>
                  </el-col>
                  <el-col :span="10">
                    <el-select
                      v-model="item.key"
                      @change="changeSelectHeader(item)"
                      required
                      :placeholder="lang.dialog.placeholder.select"
                      clearable
                      filterable
                      allow-create
                      value-key="name"
                      size="small">
                      <el-option
                        v-for="(item, index) in requestSelectHeaders"
                        :key="item.label + index"
                        :label="item.label"
                        :value="item.value">
                      </el-option>
                    </el-select>
                  </el-col>
                  <el-col :span="10">
                    <el-select
                      v-model="item.value"
                      multiple
                      required
                      :placeholder="lang.dialog.placeholder.select"
                      clearable
                      filterable
                      allow-create
                      value-key="name"
                      size="small">
                      <el-option
                        v-for="(item, index) in requestSelectHeaderValue"
                        :key="item.label + index"
                        :label="item.label"
                        :value="item.value">
                      </el-option>
                    </el-select>
                  </el-col>
                  <el-col :span="1" v-if="index" class="query_content">
                    <i class="el-icon-error" @click="removeHeader(index)"></i>
                  </el-col>
                  <el-col :span="1" class="query_content">
                    <i
                      class="el-icon-circle-plus-outline"
                      @click="addHeader"
                      v-if="jsonApiTest.headers.length && index === jsonApiTest.headers.length - 1">
                    </i>
                  </el-col>
                </el-row>
              </template>
            </el-row>
          </el-col>
          <el-col :span="12" style="padding: 10px;">
            <el-row class="api_text">
              <span>Body</span>
            </el-row>
            <template v-if="bodyText">
              <el-row :gutter="20" class="query_content">
                <el-col :span="20">
                  <el-input
                    type="textarea"
                    :autosize="{ minRows: 3 }"
                    v-model="jsonApiTest.body">
                  </el-input>
                </el-col>
              </el-row>
            </template>
          </el-col>
        </el-row>
        <el-row class="status_code_row">
          <el-col :span="12" class="status_code_row">
            <el-form-item :label="lang.dialog.title.status_code">
              <el-select
                v-model="jsonApiTest.responseCode"
                required
                :placeholder="lang.dialog.placeholder.select"
                clearable
                filterable
                value-key="name"
                size="small">
                <el-option
                  v-for="(item, index) in responseSelectCode"
                  :key="item.label"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="lang.table.comment">
              <el-input
                type="textarea"
                :autosize="{ minRows: 3 }"
                v-model="jsonApiTest.comment">
              </el-input>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
    </el-form>

    <el-row class="result_block">
      <el-col :span="3" class="border_right">
        {{ this.lang.dialog.title.debug_result }}
      </el-col>
      <el-col :span="21">
        {{ responseReturn.responseCode }}
      </el-col>
    </el-row>
    <el-row class="json_path_row">
      <el-col :span="10">
        <el-radio-group v-model="headerOrJsonPath" size="small">
          <el-radio-button label="ResponseHeader"></el-radio-button>
          <el-radio-button label="JsonPath"></el-radio-button>
        </el-radio-group>
      </el-col>
      <el-col :span="14">
          <el-row :gutter="10">
            <el-col :span="12" style="padding-top: 10px;">
              <h4>BODY</h4>
            </el-col>
            <template v-if="returnBodyHtmlFlag">
              <el-col :span="12">
                <el-switch
                  @change="changeReturnBodyHtmlShowStyle"
                  style="margin: 12px 5px 0px;"
                  v-model="showHtmlFlag"
                  active-text="preview"
                  inactive-text="pretty"
                  active-value="preview"
                  inactive-value="pretty">
                </el-switch>
              </el-col>
            </template>
          </el-row>
      </el-col>
    </el-row>

    <el-row class="result_return">
      <el-col :span="10" class="result_col border_right">
        <template v-if="headerOrJsonPath == 'ResponseHeader'">
          <div class="response_block" v-for="[key, value] of Object.entries(responseHeader)">
            <div :title="key" class="response_key">
              {{ key }}:
            </div>
            <div :title="value" class="response_value">
              {{ value }}
            </div>
          </div>
        </template>
        <template v-if="headerOrJsonPath == 'JsonPath'">
          <div class="response_block">
            <p>{{ JsonPathContent }}</p>
          </div>
        </template>
      </el-col>
      <el-col :span="14" class="result_col">
        <div class="response_block_json_edit">
          <div style="height: 100%; width: 100%;" id="JsonEditor"></div>
        </div>
      </el-col>
    </el-row>
    <div class="api_footer"></div>

    <el-dialog :title="lang.dialog.title.api_save_as" :visible.sync="apiInstructionSaveAsDialog">
      <el-form
        :model="apiInstructionSaveAs"
        :rules="apiTestValidationSaveAs"
        ref="apiInstructionSaveAs"
        label-width="100px"
        label-position="right"
        label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input
            size="small"
            @keyup.enter.native="apiInstructionToSaveAs('apiInstructionSaveAs')"
            v-model.trim="apiInstructionSaveAs.name"
            :placeholder="lang.dialog.placeholder.enter_name">
          </el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="apiInstructionSaveAsDialog = false">
          {{ lang.operator.cancel }}
        </el-button>
        <el-button type="primary" @click="apiInstructionToSaveAs('apiInstructionSaveAs')">
          {{ lang.operator.confirm }}
        </el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
require('jsoneditor')
window.JEditor = require('../../../../static/jsoneditor/jsoneditor.min.js')

export default {
  props: ["message"],
  data() {
    var validatorApiElementNameSaveAs = (rule, value, callback) => {
      const obj = {
        name: value,
        projectId: this.projectId
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (
        /^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(
          value.replace(/(^\s+)|(\s+$)/g, "")
        )
      ) {
        this.validateApiElementName(obj).then(
          res => {
            if (parseInt(res.metadata.count) === 0) {
              return callback();
            } else {
              return callback(new Error(this.lang.validator.name.exist));
            }
          },
          err => {
            console.log(err);
          }
        );
      } else {
        return callback(new Error(this.lang.validator.name.consists));
      }
    };
    var validatorParams = (rule, value, callback) => {
      var url = new RegExp(
        "^(?!mailto:)(?:(?:http|https|ftp)://|//)(?:\\S+(?::\\S*)?@)?(?:(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[0-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))|localhost)(?::\\d{2,5})?(?:(/|\\?|#)[^\\s]*)?$",
        "i"
      );
      if (rule.field == "url") {
        if (rule.required && !value) {
          return callback(new Error(this.lang.validator.url));
        }

        if (typeof value === "string" && !!value.match(url)) {
          return callback();
        } else {
          return callback(new Error(this.lang.validator.url));
        }
      }
    };
    return {
      projectId: null,
      testCaseId: null,
      permissionRule: {},
      lang: {},
      jsonApiTest: {
        name: "",
        protocol: "http://",
        url: "",
        method: "GET",
        query: [
          {
            checked: false,
            key: "",
            value: ""
          }
        ],
        headers: [
          {
            checked: false,
            key: "",
            value: []
          }
        ],
        responseCode: null,
        body: "",
        schema: "",
        jsonPath: "",
        elementId: null,
        id: null,
        optionFlag: false,
        optionKey: "",
        expectedValue: "",
        comment: ""
      },
      apiTestValidation: {
        responseCode: [
          {
            required: true,
            type: "integer",
            message: "请输入预期状态码， 默认返回200-300的返回码作为成功",
            trigger: "blur"
          }
        ],
        url: [{ type: "url", required: true, validator: validatorParams }],
        method: [{ required: true, message: "请输选择方法", trigger: "blur" }],
        body: [{ required: true, message: "请输入内容", trigger: "blur" }],
        schema: [
          { required: true, message: "请选输入名称" },
          {
            type: "regexp",
            pattern: "/^[a-zA-Z0-9]+/",
            message: "只能是数字或字母",
            trigger: "blur"
          }
        ]
      },
      jsonEditor: null,
      schemaEditor: null,
      editor: null,
      json: "",
      schema: "",
      type: "",
      bodyText: false,
      requestSelectHeaderValue: [],
      requestHeaders: [
        {
          label: "Accept",
          value: [
            "application/javascript",
            "application/json",
            "application/x-www-form-urlencoded",
            "application/xml",
            "application/zip",
            "application/pdf",
            "application/sql",
            "application/graphql",
            "application/ld+json",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-powerpoint",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "application/vnd.oasis.opendocument.text",
            "audio/mpeg",
            "audio/vorbis",
            "multipart/form-data",
            "text/css",
            "text/html",
            "text/csv",
            "text/plain",
            "image/png",
            "image/jpeg",
            "image/gif"
          ]
        },
        {
          label: "Content-Type",
          value: [
            "application/javascript",
            "application/json",
            "application/x-www-form-urlencoded",
            "application/xml",
            "application/zip",
            "application/pdf",
            "application/sql",
            "application/graphql",
            "application/ld+json",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-powerpoint",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "application/vnd.oasis.opendocument.text",
            "audio/mpeg",
            "audio/vorbis",
            "multipart/form-data",
            "text/css",
            "text/html",
            "text/csv",
            "text/plain",
            "image/png",
            "image/jpeg",
            "image/gif"
          ]
        },
        { label: "Accept-Charset", value: [] },
        { label: "Accept-Encoding", value: [] },
        { label: "Accept-Language", value: [] },
        { label: "Accept-Ranges", value: [] },
        { label: "Authorization", value: [] },
        { label: "Cache-Control", value: [] },
        { label: "Connection", value: [] },
        { label: "Cookie", value: [] },
        { label: "Content-Length", value: [] },
        { label: "Date", value: [] },
        { label: "Expect", value: [] },
        { label: "From", value: [] },
        { label: "Host", value: [] },
        { label: "If-Match", value: [] },
        { label: "If-Modified-Since", value: [] },
        { label: "If-None-Match", value: [] },
        { label: "If-Range", value: [] },
        { label: "If-Unmodified-Since", value: [] },
        { label: "Max-Forwards", value: [] },
        { label: "Pragma", value: [] },
        { label: "Proxy-Authorization", value: [] },
        { label: "Range", value: [] },
        { label: "Referer", value: [] },
        { label: "TE", value: [] },
        { label: "Upgrade", value: [] },
        { label: "User-Agent", value: [] },
        { label: "Via", value: [] },
        { label: "Warning", value: [] }
      ],
      responseReturn: {},
      responseHeader: {},
      responseBody: [],
      responseCodeArray: [
        "100 Continue",
        "101 Switching Protocols",
        "102 Processing (WebDAV; RFC 2518)",
        "103 Early Hints (RFC 8297)",
        "200 OK",
        "201 Created",
        "202 Accepted",
        "203 Non-Authoritative Information (since HTTP/1.1)",
        "204 No Content",
        "205 Reset Content",
        "206 Partial Content (RFC 7233)",
        "207 Multi-Status (WebDAV; RFC 4918)",
        "208 Already Reported (WebDAV; RFC 5842)",
        "226 IM Used (RFC 3229)",
        "300 Multiple Choices",
        "301 Moved Permanently",
        "302 Found",
        "303 See Other (since HTTP/1.1)",
        "304 Not Modified (RFC 7232)",
        "305 Use Proxy (since HTTP/1.1)",
        "306 Switch Proxy",
        "307 Temporary Redirect (since HTTP/1.1)",
        "308 Permanent Redirect (RFC 7538)",
        "404 error on Wikipedia",
        "400 Bad Request",
        "401 Unauthorized (RFC 7235)",
        "402 Payment Required",
        "403 Forbidden",
        "404 Not Found",
        "405 Method Not Allowed",
        "406 Not Acceptable",
        "407 Proxy Authentication Required (RFC 7235)",
        "408 Request Timeout",
        "409 Conflict",
        "410 Gone",
        "411 Length Required",
        "412 Precondition Failed (RFC 7232)",
        "413 Payload Too Large (RFC 7231)",
        "414 URI Too Long (RFC 7231)",
        "415 Unsupported Media Type",
        "416 Range Not Satisfiable (RFC 7233)",
        "417 Expectation Failed",
        "418 I'm a teapot (RFC 2324, RFC 7168)",
        "421 Misdirected Request (RFC 7540)",
        "422 Unprocessable Entity (WebDAV; RFC 4918)",
        "423 Locked (WebDAV; RFC 4918)",
        "424 Failed Dependency (WebDAV; RFC 4918)",
        "426 Upgrade Required",
        "428 Precondition Required (RFC 6585)",
        "429 Too Many Requests (RFC 6585)",
        "431 Request Header Fields Too Large (RFC 6585)",
        "451 Unavailable For Legal Reasons (RFC 7725)",
        "500 Internal Server Error",
        "501 Not Implemented",
        "502 Bad Gateway",
        "503 Service Unavailable",
        "504 Gateway Timeout",
        "505 HTTP Version Not Supported",
        "506 Variant Also Negotiates (RFC 2295)",
        "507 Insufficient Storage (WebDAV; RFC 4918)",
        "508 Loop Detected (WebDAV; RFC 5842)",
        "510 Not Extended (RFC 2774)",
        "511 Network Authentication Required (RFC 6585)"
      ],
      apiInstructionSaveAsDialog: false,
      apiInstructionSaveAs: {
        name: ""
      },
      apiTestValidationSaveAs: {
        name: [
          {
            required: true,
            validator: validatorApiElementNameSaveAs,
            trigger: "blur"
          }
        ]
      },
      apiElement: {},
      headerOrJsonPath: "ResponseHeader",
      JsonPathContent: [],
      jsonJeditor: null,
      showHtmlFlag: "pretty",
      returnBodyHtmlFlag: false,
      returnHtmlBody: "",
      hrefStr: ""
    };
  },
  created: function() {
    var message = JSON.parse(this.message);
    this.permissionRule = message.permissions;
    this.lang = message.lang;
    var str = window.location.href.split("?")[1];
    var currentPage = parseInt(str.split('&')[0].split('=')[1].split('+')[0]);
    var currentSize = parseInt(str.split('&')[0].split('=')[1].split('+')[1]);
    this.hrefStr = "?page=" + currentPage + '+' + currentSize;
  },
  mounted() {
    this.projectId = window.location.pathname.split("/")[4];
    this.testCaseId = window.location.pathname.split("/")[6];
    const type = localStorage.getItem("apiInstructionType");
    const instruction = JSON.parse(localStorage.getItem("apiInstructionData"));
    if (type === "add") {
      this.type = "add";
      this.jsonApiTest.name = instruction.name;
      this.jsonApiTest.elementId = instruction.id;
      this.jsonApiTest.method = instruction.parameter.method || "GET";
      if (
        instruction.parameter.method === "POST" ||
        instruction.parameter.method === "PATCH" ||
        instruction.parameter.method === "PUT"
      ) {
        this.bodyText = true;
        this.jsonApiTest.body = instruction.parameter.body || '';
      }
      this.jsonApiTest.url = instruction.parameter.url || null;
      this.jsonApiTest.jsonPath = "";
      this.jsonApiTest.comment = "";
      this.jsonApiTest.expectedValue = "";
      this.jsonApiTest.optionKey = "";
      this.jsonApiTest.optionFlag = false;
      this.jsonApiTest.query = [];
      this.jsonApiTest.headers = [];
      for (let [key, value] of Object.entries(
        instruction.parameter.queryParameters
      )) {
        const query = {};
        query.checked = true;
        query.key = key;
        query.value = value;
        this.jsonApiTest.query.push(query);
      }
      for (let [key, value] of Object.entries(
        instruction.parameter.requestHeaders
      )) {
        const headers = {};
        headers.checked = true;
        headers.key = key;
        headers.value = value.split(",");
        this.jsonApiTest.headers.push(headers);
      }
      this.jsonApiTest.query.push({
        checked: false,
        key: "",
        value: ""
      });
      this.jsonApiTest.headers.push({
        checked: false,
        key: "",
        value: ""
      });
    } else {
      this.type = "edit";
      if (
        instruction.data.method === "POST" ||
        instruction.data.method === "PATCH" ||
        instruction.data.method === "PUT"
      ) {
        this.bodyText = true;
        this.jsonApiTest.body = instruction.data.body;
      }
      this.jsonApiTest.id = instruction.id;
      this.jsonApiTest.name = instruction.data.apiName;
      // this.jsonApiTest.jsonPath = instruction.data.jsonPath;
      this.jsonApiTest.elementId = instruction.elementId;
      this.jsonApiTest.url = instruction.data.url;
      this.jsonApiTest.comment = instruction.comment;
      this.jsonApiTest.jsonPath = instruction.data.jsonPathPackage.jsonPath;
      this.jsonApiTest.expectedValue =
        instruction.data.jsonPathPackage.expectedValue;
      instruction.instructionOptions && instruction.instructionOptions[0]
        ? (this.jsonApiTest.optionKey = instruction.instructionOptions[0].value)
        : (this.jsonApiTest.optionKey = "");
      instruction.instructionOptions && instruction.instructionOptions[0]
        ? (this.jsonApiTest.optionFlag = true)
        : (this.jsonApiTest.optionFlag = false);
      instruction.instructionOptions && instruction.instructionOptions[0]
        ? (this.jsonApiTest.optionId = instruction.instructionOptions[0].id)
        : (this.jsonApiTest.optionId = "");
      this.jsonApiTest.responseCode = instruction.data.responseCode;
      this.jsonApiTest.query = [];
      this.jsonApiTest.headers = [];
      for (let [key, value] of Object.entries(
        instruction.data.queryParameters
      )) {
        const query = {};
        query.checked = true;
        query.key = key;
        query.value = value;
        this.jsonApiTest.query.push(query);
      }
      for (let [key, value] of Object.entries(
        instruction.data.requestHeaders
      )) {
        const headers = {};
        headers.checked = true;
        headers.key = key;
        headers.value = value.split(",");
        this.jsonApiTest.headers.push(headers);
      }
      this.jsonApiTest.query.push({
        checked: false,
        key: "",
        value: ""
      });
      this.jsonApiTest.headers.push({
        checked: false,
        key: "",
        value: ""
      });
      this.jsonApiTest.method = instruction.data.method;
    }
    const obj = {
      id: this.projectId
    };
    obj.data = {
      pageNumber: 1,
      pageSize: "all",
      type: 'REST_API'
    };
    this.readProjectApiElements(obj);
  },
  computed: {
    ...mapGetters(["getSelectProjectApiElements", "getSchemas"]),
    requestSelectHeaders: function() {
      return this.requestHeaders.map(item => {
        return { label: item.label, value: item.label };
      });
    },
    responseSelectCode: function() {
      return this.responseCodeArray.map(item => {
        return { label: item, value: item.split(" ")[0] };
      });
    }
  },
  methods: {
    ...mapActions([
      "addTestCaseInstruction",
      "updateTestCaseInstruction",
      "readProjectApiElements",
      "readSchemas",
      "putSchema",
      "httpPreExecution",
      "validateApiElementName",
      "addProjectApiElement",
      "updateProjectApiElement",
      "readTestCaseInstructions"
    ]),
    selectApiElement(obj) {
      if (typeof obj !== "string") {
        this.jsonApiTest.elementId = obj.id;
        this.jsonApiTest.method = obj.parameter.method || "GET";
        if (
          this.jsonApiTest.method === "POST" ||
          this.jsonApiTest.method === "PATCH" ||
          this.jsonApiTest.method === "PUT"
        ) {
          this.jsonApiTest.body = obj.parameter.body;
          this.bodyText = true;
        } else {
          this.bodyText = false;
          this.jsonApiTest.body = "";
        }
        this.jsonApiTest.url = obj.parameter.url;
        this.jsonApiTest.query = [];
        this.jsonApiTest.headers = [];
        for (let [key, value] of Object.entries(
          obj.parameter.queryParameters
        )) {
          const query = {};
          query.checked = true;
          query.key = key;
          query.value = value;
          this.jsonApiTest.query.push(query);
        }
        for (let [key, value] of Object.entries(obj.parameter.requestHeaders)) {
          const headers = {};
          headers.checked = true;
          headers.key = key;
          headers.value = value.split(",");
          this.jsonApiTest.headers.push(headers);
        }
      }
    },
    changeSelectHeader(obj) {
      obj.value = [];
      var value = [];
      this.requestHeaders.forEach(item => {
        if (item.label === obj.key) {
          value = item.value;
        }
      });
      this.requestSelectHeaderValue = [];
      value.forEach(element => {
        this.requestSelectHeaderValue.push({
          label: element,
          value: element
        });
      });
    },
    addQuery() {
      const query = {
        checked: false,
        key: "",
        value: ""
      };
      this.jsonApiTest.query.push(query);
    },
    removeQuery(index) {
      if (index !== -1) {
        this.jsonApiTest.query.splice(index, 1);
      }
    },
    addHeader() {
      const headers = {
        checked: false,
        key: "",
        value: ""
      };
      this.jsonApiTest.headers.push(headers);
    },
    removeHeader(index) {
      if (index !== -1) {
        this.jsonApiTest.headers.splice(index, 1);
      }
    },
    changeSelectSchema(obj) {
      if (typeof obj !== "string") {
        this.schemaEditor.set(obj.value.jsonSchema);
      } else {
        this.schemaEditor.set("");
        this.jsonEditor.set("");
      }
    },
    changeSelectMethod(obj) {
      if (obj === "POST" || obj === "PATCH" || obj === "PUT") {
        // this.readSchemas();
        this.bodyText = true;
      } else {
        this.bodyText = false;
      }
    },
    addApiInstruction(formname) {
      this.$refs[formname].validate(valid => {
        if (valid) {
          const obj = {};
          obj.type = "REST_API";
          obj.input = this.jsonApiTest.url;
          obj.comment = this.jsonApiTest.comment;
          obj.action = this.jsonApiTest.method || "GET";
          obj.data = {};
          obj.data.apiName =
            this.jsonApiTest.name.name || this.jsonApiTest.name;
          obj.data.method = this.jsonApiTest.method;
          // obj.data.protocol = this.jsonApiTest.protocol;
          obj.data.responseCode = this.jsonApiTest.responseCode || null;
          obj.data.url = this.jsonApiTest.url;
          obj.data.jsonPathPackage = {
            jsonPath: this.jsonApiTest.jsonPath,
            expectedValue: this.jsonApiTest.expectedValue
          };
          if (this.jsonApiTest.optionFlag) {
            obj.instructionOptions = [
              {
                name: "DTA_SAVE_JSONPATH",
                value: this.jsonApiTest.optionKey,
                valueRequired: true
              }
            ];
          } else {
            obj.instructionOptions = [];
          }
          obj.data.requestHeaders = {};
          obj.data.queryParameters = {};
          let querys = [];
          this.jsonApiTest.query.forEach((item, index) => {
            querys.push(item);
          });
          let headers = [];
          this.jsonApiTest.headers.forEach((item, index) => {
            headers.push(item);
          });
          if (querys.length) {
            querys.forEach((item, index) => {
              item.key
                ? (obj.data.queryParameters[item.key] = item.value)
                : null;
            });
          }
          if (headers.length) {
            headers.forEach((item, index) => {
              item.key
                ? (obj.data.requestHeaders[item.key] = item.value.join(","))
                : null;
            });
          }
          if (
            obj.data.method === "POST" ||
            obj.data.method === "PUT" ||
            obj.data.method === "PATCH"
          ) {
            obj.data.body = this.jsonApiTest.body || null;
          }
          obj.orderIndex = localStorage.getItem("apiOrderIndex");
          obj.elementId = this.jsonApiTest.elementId;
          const instruction = {
            testCaseId: this.testCaseId,
            data: [obj]
          };
          this.$confirm(
            this.lang.dialog.title.save_or_not_change_message,
            this.lang.dialog.title.save_or_not_change,
            {
              confirmButtonText: this.lang.operator.confirm,
              cancelButtonText: this.lang.operator.cancel,
              type: "warning",
              dangerouslyUseHTMLString: true
            }
          )
            .then(() => {
              this.saveApiElementChange("jsonApiTest");
              this.addTestCaseInstruction(instruction).then(
                res => {
                  this.readDoneInstruction();
                },
                err => {
                  this.readDoneInstruction();
                }
              );
              var str = window.location.href.split("?")[1];
              var currentPage = parseInt(str.split('&')[0].split('=')[1].split('+')[0]);
              var currentSize = parseInt(str.split('&')[0].split('=')[1].split('+')[1]);
              window.location.href =
                "/atm/TestSetting/Project/" +
                this.projectId +
                "/TestCase/" +
                this.testCaseId +
                "/Instruction?page=" +
                currentPage + '+' + currentSize;
              localStorage.removeItem("apiOrderIndex");
              localStorage.removeItem("apiInstructionData");
              localStorage.removeItem("apiInstructionType");
            })
            .catch(() => {
              this.$message({
                type: "info",
                message: this.lang.dialog.title.unchange
              });
            });
        } else {
          return false;
        }
      });
    },
    saveSchema() {
      const schema = {};
      schema.type = "JSON";
      schema.name = this.jsonApiTest.schema.label || this.jsonApiTest.schema;
      schema.jsonSchema = this.schemaEditor.get();
      this.jsonApiTest.schema.value
        ? (schema.id = this.jsonApiTest.schema.value.id)
        : null;
      this.putSchema([schema]);
    },
    readDoneInstruction() {
      const obj = {};
      obj.testCaseId = this.testCaseId;
      obj.data = {
        pageNumber: 1,
        pageSize: 25
      };
      this.readTestCaseInstructions(obj);
    },
    editApiInstruction(formname) {
      this.$refs[formname].validate(valid => {
        if (valid) {
          const obj = {};
          obj.type = "REST_API";
          this.jsonApiTest.id ? (obj.id = this.jsonApiTest.id) : null;
          obj.input = this.jsonApiTest.url;
          obj.comment = this.jsonApiTest.comment;
          obj.action = this.jsonApiTest.method || "GET";
          obj.data = {};
          obj.data.apiName =
            this.jsonApiTest.name.name || this.jsonApiTest.name;
          obj.data.method = this.jsonApiTest.method;
          obj.data.responseCode = this.jsonApiTest.responseCode || null;
          obj.data.url = this.jsonApiTest.url;
          obj.data.jsonPathPackage = {
            jsonPath: this.jsonApiTest.jsonPath,
            expectedValue: this.jsonApiTest.expectedValue
          };
          if (this.jsonApiTest.optionFlag) {
            obj.instructionOptions = [
              {
                name: "DTA_SAVE_JSONPATH",
                value: this.jsonApiTest.optionKey,
                valueRequired: true
              }
            ];
            this.jsonApiTest.optionId
              ? (obj.instructionOptions[0].id = this.jsonApiTest.optionId)
              : null;
          } else {
            obj.instructionOptions = [];
          }
          obj.data.requestHeaders = {};
          obj.data.queryParameters = {};
          let querys = [];
          this.jsonApiTest.query.forEach((item, index) => {
            querys.push(item);
          });
          let headers = [];
          this.jsonApiTest.headers.forEach((item, index) => {
            headers.push(item);
          });
          if (querys.length) {
            querys.forEach((item, index) => {
              item.key
                ? (obj.data.queryParameters[item.key] = item.value)
                : null;
            });
          }
          if (headers.length) {
            headers.forEach((item, index) => {
              item.key
                ? (obj.data.requestHeaders[item.key] = item.value.join(","))
                : null;
            });
          }
          if (
            obj.data.method === "POST" ||
            obj.data.method === "PUT" ||
            obj.data.method === "PATCH"
          ) {
            obj.data.body = this.jsonApiTest.body || null;
          }
          obj.orderIndex = localStorage.getItem("apiOrderIndex");
          obj.elementId = this.jsonApiTest.elementId;

          this.$confirm(
            this.lang.dialog.title.save_or_not_change_message,
            this.lang.dialog.title.save_or_not_change,
            {
              confirmButtonText: this.lang.operator.confirm,
              cancelButtonText: this.lang.operator.cancel,
              type: "warning",
              dangerouslyUseHTMLString: true
            }
          )
            .then(() => {
              this.saveApiElementChange("jsonApiTest");
              this.updateTestCaseInstruction([obj]).then(
                res => {
                  this.readDoneInstruction();
                },
                err => {
                  this.readDoneInstruction();
                }
              );
              var str = window.location.href.split("?")[1];
              var currentPage = parseInt(str.split('&')[0].split('=')[1].split('+')[0]);
              var currentSize = parseInt(str.split('&')[0].split('=')[1].split('+')[1]);
              window.location.href =
                "/atm/TestSetting/Project/" +
                this.projectId +
                "/TestCase/" +
                this.testCaseId +
                "/Instruction?page=" +
                currentPage + '+' + currentSize;
              localStorage.removeItem("apiOrderIndex");
              localStorage.removeItem("apiInstructionData");
              localStorage.removeItem("apiInstructionType");
            })
            .catch(() => {
              this.$message({
                type: "info",
                message: this.lang.dialog.title.unchange
              });
            });
        } else {
          return false;
        }
      });
    },
    cancelApiInstructionEdit() {
      this.$confirm(
        this.lang.dialog.title.cancel_change_message,
        this.lang.dialog.title.cancel_change,
        {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: "warning",
          dangerouslyUseHTMLString: true
        }
      )
        .then(() => {
          var str = window.location.href.split("?")[1];
          var currentPage = parseInt(str.split('&')[0].split('=')[1].split('+')[0]);
          var currentSize = parseInt(str.split('&')[0].split('=')[1].split('+')[1]);
          window.location.href =
            "/atm/TestSetting/Project/" +
            this.projectId +
            "/TestCase/" +
            this.testCaseId +
            "/Instruction?page=" +
            currentPage + '+' + currentSize;
          localStorage.removeItem("apiOrderIndex");
          localStorage.removeItem("apiInstructionData");
          localStorage.removeItem("apiInstructionType");
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: this.lang.dialog.title.unchange
          });
        });
    },
    saveApiElementChange(formname) {
      this.$refs[formname].validate(valid => {
        if (valid) {
          const element = {};
          element.parameter = {};
          element.parameter.requestHeaders = {};
          element.parameter.queryParameters = {};
          let querys = [];
          this.jsonApiTest.query.forEach((item, index) => {
            querys.push(item);
          });
          let headers = [];
          this.jsonApiTest.headers.forEach((item, index) => {
            headers.push(item);
          });
          if (querys.length) {
            querys.forEach((item, index) => {
              item.key
                ? (element.parameter.queryParameters[item.key] = item.value)
                : null;
            });
          }
          if (headers.length) {
            headers.forEach((item, index) => {
              item.key
                ? (element.parameter.requestHeaders[item.key] = item.value.join(
                    ","
                  ))
                : null;
            });
          }
          element.id = this.jsonApiTest.elementId;
          element.type = "REST_API";
          element.name = this.jsonApiTest.name.name || this.jsonApiTest.name;
          element.locatorType = "URL";
          element.locatorValue = "";
          element.driverType = "API";
          element.parameter.url = this.jsonApiTest.url;
          element.parameter.method = this.jsonApiTest.method;
          this.jsonApiTest.body
            ? (element.parameter.body = this.jsonApiTest.body)
            : null;
          this.updateProjectApiElement([element]).then(
            res => {
              const obj = {
                id: this.projectId
              };
              obj.data = {
                pageNumber: 1,
                pageSize: "all",
                type: 'REST_API'
              };
              this.readProjectApiElements(obj);
            },
            err => {
              this.$message({
                type: "error",
                message: "保存发生错误！"
              });
            }
          );
        } else {
          return false;
        }
      });
    },
    saveAsApiElementChange(formname) {
      this.$refs[formname].validate(valid => {
        if (valid) {
          const element = {};
          element.parameter = {};
          element.parameter.requestHeaders = {};
          element.parameter.queryParameters = {};
          let querys = [];
          this.jsonApiTest.query.forEach((item, index) => {
            querys.push(item);
          });
          let headers = [];
          this.jsonApiTest.headers.forEach((item, index) => {
            headers.push(item);
          });
          if (querys.length) {
            querys.forEach((item, index) => {
              item.key
                ? (element.parameter.queryParameters[item.key] = item.value)
                : null;
            });
          }
          if (headers.length) {
            headers.forEach((item, index) => {
              item.key
                ? (element.parameter.requestHeaders[item.key] = item.value.join(
                    ","
                  ))
                : null;
            });
          }
          element.type = "REST_API";
          element.locatorType = "URL";
          element.locatorValue = "";
          element.driverType = "API";
          element.parameter.url = this.jsonApiTest.url;
          element.parameter.method = this.jsonApiTest.method;
          this.jsonApiTest.body
            ? (element.parameter.body = this.jsonApiTest.body)
            : null;
          this.apiElement = element;
          this.apiInstructionSaveAsDialog = true;
        } else {
          return false;
        }
      });
    },
    apiInstructionToSaveAs(formname) {
      this.$refs[formname].validate(valid => {
        if (valid) {
          const param = {
            id: this.projectId
          };
          const element = this.apiElement;
          element.name = this.apiInstructionSaveAs.name;
          param.data = [element];
          this.addProjectApiElement(param).then(
            res => {
              const obj = {
                id: this.projectId
              };
              obj.data = {
                pageNumber: 1,
                pageSize: "all",
                type: 'REST_API'
              };
              this.readProjectApiElements(obj);
            },
            err => {
              this.$message({
                type: "error",
                message: "接口另存为发生错误！"
              });
            }
          );
          this.apiInstructionSaveAsDialog = false;
        } else {
          return false;
        }
      });
    },
    preOperation(formname) {
      this.$refs[formname].validate(valid => {
        if (valid) {
          const obj = {};
          obj.type = 'REST_API';
          obj.method = this.jsonApiTest.method;
          obj.url = this.jsonApiTest.url;
          obj.requestHeaders = {};
          obj.queryParameters = {};
          obj.jsonPathPackage = {
            jsonPath: this.jsonApiTest.jsonPath
          };
          obj.jsonPath = this.jsonApiTest.jsonPath;
          var querys = [];
          this.jsonApiTest.query.forEach((item, index) => {
            if (item.checked) {
              querys.push(item);
            }
          });
          var headers = [];
          this.jsonApiTest.headers.forEach((item, index) => {
            if (item.checked) {
              headers.push(item);
            }
          });
          if (querys.length) {
            querys.forEach((item, index) => {
              item.key ? (obj.queryParameters[item.key] = item.value) : null;
            });
          }
          if (headers.length) {
            headers.forEach((item, index) => {
              item.key
                ? (obj.requestHeaders[item.key] = item.value.join(","))
                : null;
            });
          }
          this.jsonApiTest.body
            ? (obj.requestBody = this.jsonApiTest.body)
            : null;
          this.responseReturn = {};
          this.responseHeader = {};
          this.JsonPathContent = [];
          this.httpPreExecution(obj).then(
            res => {
              this.jsonJeditor
                ? this.jsonJeditor.destroy()
                : (this.jsonJeditor = null);
              var doc = document.getElementById("JsonEditor");
              this.responseReturn = res.data[0];
              this.responseHeader = res.data[0].responseHeaders || {};
              this.JsonPathContent = res.data[0].jsonPathMatchedObjectsString || [];
              doc.innerText = "";
              if ( res.data[0].responseHeaders["Content-Type"].includes("html") ) {
                this.returnHtmlBody =
                  res.data[0].responseBody.data ||
                  res.data[0].responseBody ||
                  [];
                doc.innerText =
                  res.data[0].responseBody.data ||
                  res.data[0].responseBody ||
                  [];
                this.returnBodyHtmlFlag = true;
                this.showHtmlFlag = "pretty";
              } else if ( res.data[0].responseHeaders["Content-Type"].includes("json") ) {
                var $json = document.getElementById("JsonEditor");
                var jsonBody = null;
                if (!!res.data[0].jsonPathError) {
                  jsonBody = res.data[0].jsonPathError
                } else {
                  jsonBody = JSON.parse(
                    res.data[0].responseBody ||
                    res.data[0].responseBody.data ||
                    "[]"
                    );
                }
                this.jsonJeditor = new window.JEditor($json, {
                  mode: "code",
                  indentation: 2
                });
                this.jsonJeditor.set(jsonBody);
                this.returnBodyHtmlFlag = false;
              } else {
                this.returnBodyHtmlFlag = false;
                doc.innerText =
                  res.data[0].responseBody ||
                  res.data[0].body.data ||
                  res.data[0].body ||
                  [];
              }
            },
            err => {
              console.log(err, "err");
            }
          );
        } else {
          return false;
        }
      });
    },
    changeReturnBodyHtmlShowStyle() {
      var doc = document.getElementById("JsonEditor");
      doc.innerHTML = "";
      if (this.showHtmlFlag === "preview") {
        var iframe = null;
        iframe = document.createElement("iframe");
        iframe.setAttribute("id", "returnHtml");
        iframe.setAttribute("width", "100%");
        iframe.setAttribute("height", "100%");
        doc.appendChild(iframe);
        var innerIframe = document.getElementById("returnHtml");
        var ed = document.all
          ? innerIframe.contentWindow.document
          : innerIframe.contentDocument;
        ed.open();
        ed.write(this.returnHtmlBody);
        ed.close();
        ed.contentEditable = true;
        ed.designMode = "on";
      } else {
        doc.innerText = this.returnHtmlBody;
      }
    }
  }
};
</script>

  <style scoped>
@import "../../../../static/jsoneditor/jsoneditor.min.css";
.el-form-item {
  margin: 5px 30px !important;
}
.el-radio-group {
  margin-top: 5px !important;
}
.el-row {
  margin: 0px !important;
}
.response_block_json_edit {
  height: 100%;
  }
</style>
