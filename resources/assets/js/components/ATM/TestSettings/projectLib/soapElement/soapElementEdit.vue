<template>
  <div style="background-color: #eee;">
    <project-tool-bar>
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/TestSetting/Project'>{{ lang.breadcrumb.project_lib }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>
            <a style="font-weight: 500;" :href="'/atm/TestSetting/Project/' + projectId + '/ApiElement'">{{ lang.breadcrumb.api_element }}</a>
          </el-breadcrumb-item>
          <template v-if="nameInputStatus">
            <el-breadcrumb-item>{{ lang.dialog.title.add }}</el-breadcrumb-item>
          </template>
          <template v-else>
            <el-breadcrumb-item>{{ lang.dialog.title.edit }}</el-breadcrumb-item>
          </template>
        </el-breadcrumb>
      </div>
      <div slot="name" class="text_ellipsis">
        {{ projectMessage.name }}
      </div>
      <div slot="creator" class="text_ellipsis">
        {{ projectMessage.createdAt }}
      </div>
    </project-tool-bar>
      <el-form :model="apiElement" :rules="apiElementValidation" ref="apiElement" label-width="120px" label-position="right" label-suffix=":">
        <el-row class="api_name_row">
          <el-col :span="12">
            <el-form-item :label="lang.dialog.title.api_name" prop="name">
              <el-input size="small" v-model="apiElement.name" class="input-with-select"></el-input>
            </el-form-item>
          </el-col>
        <el-col :span="8">
          <el-form-item>
            <el-button size="small" style="margin-right: 20px;" @click="cancelChange" round>{{ lang.operator.cancel }}</el-button>
            <template v-if="nameInputStatus">
              <el-button type="primary" @click="addApiInstruction('apiElement')" size="small" round>{{ lang.operator.confirm }}</el-button>
            </template>
            <template v-else>
              <el-button type="primary" @click="editApiInstruction('apiElement')" size="small" round>{{ lang.operator.confirm }}</el-button>
            </template>
          </el-form-item>
        </el-col>
        </el-row>
        <el-row class="api_name_row">
          <el-col :span="20">
            <el-form-item label="" prop="url">
              <el-input :placeholder="lang.dialog.placeholder.enter" clearable size="small" v-model="apiElement.url" class="input-with-select">
                <el-select v-model="apiElement.method" style="width:100px;" @change="changeSelectMethod" size="small" slot="prepend" :placeholder="lang.dialog.placeholder.select">
                  <el-option label="GET" value="GET"></el-option>
                  <el-option label="POST" value="POST"></el-option>
                  <el-option label="PUT" value="PUT"></el-option>
                  <el-option label="PATCH" value="PATCH"></el-option>
                  <el-option label="DELETE" value="DELETE"></el-option>
                </el-select>
              </el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <div class="api_param_block">
          <el-row class="query_row">
            <el-row class="api_text">
              <span>Query parameter</span>
            </el-row>
            <template v-for="(item, index) in apiElement.query">
              <el-row :gutter="20" class="query_content">
                <el-col :span="1" class="query_content">
                  <el-checkbox v-model="item.checked"></el-checkbox>
                </el-col>
                <el-col :span="8">
                  <el-input v-model="item.key" clearable :placeholder="lang.dialog.placeholder.enter" size="small"></el-input>
                </el-col>
                <el-col :span="8">
                  <el-input v-model="item.value" clearable :placeholder="lang.dialog.placeholder.enter" size="small"></el-input>
                </el-col>
                <el-col :span="1" v-if="index" class="query_content">
                  <i class="el-icon-error" @click="removeQuery(index)"></i>
                </el-col>
                <el-col :span="1" class="query_content">
                  <i class="el-icon-circle-plus-outline" @click="addQuery" v-if="apiElement.query.length && index === apiElement.query.length -1"></i>
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
                <template v-for="(item, index) in apiElement.headers">
                  <el-row :gutter="20" class="query_content">
                    <el-col :span="1" class="query_content">
                      <el-checkbox v-model="item.checked"></el-checkbox>
                    </el-col>
                    <el-col :span="10">
                      <el-select v-model="item.key" @change="changeSelectHeader(item)" required :placeholder="lang.dialog.placeholder.select" clearable filterable allow-create value-key="name" size="small">
                        <el-option
                          v-for="(item, index) in requestSelectHeaders"
                          :key="item.label + index"
                          :label="item.label"
                          :value="item.value">
                        </el-option>
                      </el-select>
                    </el-col>
                    <el-col :span="10">
                      <el-select v-model="item.value" multiple required :placeholder="lang.dialog.placeholder.select" clearable filterable allow-create value-key="name" size="small">
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
                      <i class="el-icon-circle-plus-outline" @click="addHeader" v-if="apiElement.headers.length && index === apiElement.headers.length -1"></i>
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
                    <el-input type="textarea" :autosize="{ minRows: 3}" v-model="apiElement.body"></el-input>
                  </el-col>
                </el-row>
              </template>
            </el-col>
          </el-row>
        </div>
      </el-form>
 <!--      <div class="api_footer">
        <el-button size="small" style="margin-right: 20px;" @click="cancelChange" round>{{ lang.operator.cancel }}</el-button>
        <template v-if="nameInputStatus">
          <el-button type="primary" @click="addApiInstruction('apiElement')" size="small" round>{{ lang.operator.confirm }}</el-button>
        </template>
        <template v-else>
          <el-button type="primary" @click="editApiInstruction('apiElement')" size="small" round>{{ lang.operator.confirm }}</el-button>
        </template>
      </div> -->
    </div>
</template>

<script>
import {mapActions} from 'vuex'

export default {
  props: ['message'],
  data() {
    var validatorApiElementName = (rule, value, callback) => {
      const type = localStorage.getItem('apiElementType');
      const obj = {
        name: value,
        projectId: this.projectId
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        if (type === 'add') {
          this.validateApiElementName(obj).then((res) => {
            if (parseInt(res.metadata.count) === 0) {
              return callback();
            } else {
              return callback(new Error(this.lang.validator.name.exist));
            }
          }, (err) => {
            console.log(err)
          });
        }
        if (type === 'edit') {
          if (this.updatePrevName && value != this.updatePrevName) {
            this.validateApiElementName(obj).then((res) => {
              if (parseInt(res.metadata.count) === 0) {
                return callback();
              } else {
                return callback(new Error(this.lang.validator.name.exist));
              }
            }, (err) => {
              console.log(err);
            });
          } else {
            return callback();
          }
        }
      } else {
        return callback(new Error(this.lang.validator.name.consists));
      }
    };
    var validatorUrlParams = (rule, value, callback) => {
      var url = new RegExp('^(?!mailto:)(?:(?:http|https|ftp)://|//)(?:\\S+(?::\\S*)?@)?(?:(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[0-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))|localhost)(?::\\d{2,5})?(?:(/|\\?|#)[^\\s]*)?$', 'i');
      if (rule.required && !value) {
        return callback(new Error(this.lang.validator.url));
      }

      if (typeof (value) === 'string' && !!value.match(url)) {
        return callback();
      } else {
        return callback(new Error(this.lang.validator.url));
      }
    };
    return {
      permissionRule: {},
      lang: {},
      projectId: null,
      apiElement: {
        name: '',
        method: '',
        protocol: 'http://',
        url: '',
        query: [{
          checked: false,
          key: '',
          value: ''
        }],
        headers: [{
          checked: false,
          key: '',
          value: []
        }],
        body: ''
      },
      apiElementValidation: {
        name: [{required: true, validator: validatorApiElementName, trigger: 'blur'}],
        url: [{type: 'url', required: true, validator: validatorUrlParams}]
      },
      nameInputStatus: true,
      updatePreName: '',
      requestSelectHeaderValue: [],
      requestHeaders: [{ label: 'Accept', value: [ "application/javascript", "application/json", "application/x-www-form-urlencoded", "application/xml", "application/zip", "application/pdf", "application/sql", "application/graphql", "application/ld+json", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/vnd.oasis.opendocument.text", "audio/mpeg", "audio/vorbis", "multipart/form-data", "text/css", "text/html", "text/csv", "text/plain", "image/png", "image/jpeg", "image/gif" ] },
      { label: 'Content-Type', value: [ "application/javascript", "application/json", "application/x-www-form-urlencoded", "application/xml", "application/zip", "application/pdf", "application/sql", "application/graphql", "application/ld+json", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/vnd.oasis.opendocument.text", "audio/mpeg", "audio/vorbis", "multipart/form-data", "text/css", "text/html", "text/csv", "text/plain", "image/png", "image/jpeg", "image/gif" ] },
      { label: 'Accept-Charset', value: [] },
      { label: 'Accept-Encoding', value: [] },
      { label: 'Accept-Language', value: [] },
      { label: 'Accept-Ranges', value: [] },
      { label: 'Authorization', value: [] },
      { label: 'Cache-Control', value: [] },
      { label: 'Connection', value: [] },
      { label: 'Cookie', value: [] },
      { label: 'Content-Length', value: [] },
      { label: 'Date', value: [] },
      { label: 'Expect', value: [] },
      { label: 'From', value: [] },
      { label: 'Host', value: [] },
      { label: 'If-Match', value: [] },
      { label: 'If-Modified-Since', value: [] },
      { label: 'If-None-Match', value: [] },
      { label: 'If-Range', value: [] },
      { label: 'If-Unmodified-Since', value: [] },
      { label: 'Max-Forwards', value: [] },
      { label: 'Pragma', value: [] },
      { label: 'Proxy-Authorization', value: [] },
      { label: 'Range', value: [] },
      { label: 'Referer', value: [] },
      { label: 'TE', value: [] },
      { label: 'Upgrade', value: [] },
      { label: 'User-Agent', value: [] },
      { label: 'Via', value: [] },
      { label: 'Warning', value: [] }],
      bodyText: false,
      projectMessage: {},
      updatePrevName: ''
    }
  },
  computed: {
    requestSelectHeaders: function() {
      return this.requestHeaders.map((item) => { return {label: item.label, value: item.label} });
    }
  },
  created: function () {
    var message =  JSON.parse(this.message);
    this.permissionRule = message.permissions;
    this.lang = message.lang;
  },
  mounted() {
    this.permissionRule = JSON.parse(this.message);
    this.projectId = window.location.pathname.split('/')[4];
    this.apiElement.method = 'GET';
    const type = localStorage.getItem('apiElementType');
    if (type == 'add') {
      this.apiElement.name = localStorage.getItem('apiElementName');
      this.nameInputStatus = true;
    } else {
      const obj = JSON.parse(localStorage.getItem('apiElementEditData'));
      if (obj.parameter.method === 'POST' || obj.parameter.method === 'PATCH' || obj.parameter.method === 'PUT') {
        this.bodyText = true;
        this.apiElement.body = obj.parameter.body;
      }
      this.updatePrevName = obj.name;
      this.nameInputStatus = false;
      this.apiElement.id = obj.id;
      this.apiElement.name = obj.name;
      this.updatePreName = obj.name;
      this.apiElement.method = obj.parameter.method;
      // this.apiElement.protocol = obj.parameter.protocol;
      this.apiElement.url = obj.parameter.url;
      this.apiElement.query = [];
      this.apiElement.headers = [];
      for (let [key, value] of Object.entries(obj.parameter.queryParameters)) {
        const query = {};
        query.checked = true;
        query.key = key;
        query.value = value;
        this.apiElement.query.push(query);
      }
      for (let [key, value] of Object.entries(obj.parameter.requestHeaders)) {
        const headers = {};
        headers.checked = true;
        headers.key = key;
        headers.value = value.split(',');
        this.apiElement.headers.push(headers);
      }
      this.apiElement.query.push({
        checked: false,
        key: '',
        value: ''
      })
      this.apiElement.headers.push({
        checked: false,
        key: '',
        value: ''
      })
    }
    const project = {
      id: this.projectId
    };
    this.readProjectFormessage(project).then((res) => {
      this.projectMessage = res.data[0];
    }, (err) => {
      console.log(err);
    })
  },
  methods: {
    ...mapActions(['addProjectApiElement', 'validateSectionElementName', 'updateProjectApiElement', 'readProjectFormessage', 'deleteProjectApiElement', 'validateApiElementName', 'readProjectApiElements']),
    changeSelectMethod(obj) {
      if (obj === 'POST' || obj === 'PATCH' || obj === 'PUT') {
        this.bodyText = true;
      } else {
        this.bodyText = false;
      }
    },
    changeSelectHeader(obj) {
      obj.value = [];
      var value = [];
      this.requestHeaders.forEach((item) => {
        if (item.label === obj.key) {
          value = item.value;
        }
      });
      this.requestSelectHeaderValue = [];
      value.forEach((element) => {
        this.requestSelectHeaderValue.push({
          label: element,
          value: element
        })
      });
    },
    addQuery() {
      const query = {
        checked: false,
        key: '',
        value: ''
      };
      this.apiElement.query.push(query);
    },
    removeQuery(index) {
      if (index !== -1) {
        this.apiElement.query.splice(index, 1)
      }
    },
    addHeader() {
      const headers = {
        checked: false,
        key: '',
        value: ''
      };
      this.apiElement.headers.push(headers);
    },
    removeHeader(index) {
      if (index !== -1) {
        this.apiElement.headers.splice(index, 1)
      }
    },
    readDoneApiElements() {
      let element = {
        id: this.projectId
      };
      element.data = {
        pageNumber: 1,
        pageSize: 15,
        orderBy: 'createdAt desc',
        type: 'SOAP_API'
      };
      this.readProjectApiElements(element);
    },
    addApiInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {};
          obj.type = 'REST_API';
          obj.name = this.apiElement.name;
          obj.locatorType = 'URL';
          obj.locatorValue = '';
          obj.driverType = "API";
          obj.parameter = {};
          obj.parameter.url = this.apiElement.url;
          obj.parameter.method = this.apiElement.method;
          obj.parameter.requestHeaders = {};
          obj.parameter.queryParameters = {};
          let querys = [];
          this.apiElement.query.forEach((item, index) => {
            querys.push(item);
          });
          let headers = [];
          this.apiElement.headers.forEach((item, index) => {
            headers.push(item);
          });
          if (querys.length) {
            querys.forEach((element, index) => {
              element.key ? obj.parameter.queryParameters[element.key] = element.value : null
            });
          }
          if (headers.length) {
            headers.forEach((element, index) => {
              element.key ? obj.parameter.requestHeaders[element.key] = element.value.join(',') : null
            });
          }
          this.apiElement.body ? obj.parameter.body = this.apiElement.body : null;
          const element = {
            id: this.projectId,
            data: [obj]
          }
          this.addProjectApiElement(element).then((res) => {
            this.readDoneApiElements();
          }, (err) => {
            this.readDoneApiElements()
          });
          window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/ApiElement';
          localStorage.removeItem('apiElementType');
        } else {
          return false;
        }
      })
    },
    editApiInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {};
          obj.type = 'REST_API';
          obj.id = this.apiElement.id;
          obj.name = this.apiElement.name;
          obj.locatorType = 'URL';
          obj.locatorValue = '';
          obj.parameter = {};
          obj.parameter.url = this.apiElement.url;
          obj.parameter.method = this.apiElement.method;
          obj.parameter.requestHeaders = {};
          obj.parameter.queryParameters = {};
          let querys = [];
          this.apiElement.query.forEach((item, index) => {
            querys.push(item);
          });
          let headers = [];
          this.apiElement.headers.forEach((item, index) => {
            headers.push(item);
          });
          if (querys.length) {
            querys.forEach((element, index) => {
              element.key ? obj.parameter.queryParameters[element.key] = element.value : null
            });
          }
          if (headers.length) {
            headers.forEach((element, index) => {
              element.key ? obj.parameter.requestHeaders[element.key] = element.value.join(',') : null
            });
          }
          this.apiElement.body ? obj.parameter.body = this.apiElement.body : null;

        this.$confirm(this.lang.dialog.title.save_or_not_change_message, this.lang.dialog.title.save_or_not_change, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
            this.updateProjectApiElement([obj]).then((res) => {
              this.readDoneApiElements();
            }, (err) => {
              this.readDoneApiElements()
            });
            window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/ApiElement';
            localStorage.removeItem('apiElementType');
          }).catch(() => {
            this.$message({
              type:'info',
              message: this.lang.dialog.title.unchange
            });
          });
        } else {
          return false;
        }
      })
    },
    cancelChange() {
      localStorage.removeItem('apiElementEditData');
      localStorage.removeItem('apiElementName');
      localStorage.removeItem('apiElementType');
      window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/ApiElement';
    }
  }
};
</script>

