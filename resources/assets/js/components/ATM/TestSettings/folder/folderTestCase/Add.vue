<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newFolderTestCaseDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog  :title="lang.dialog.title.add" :visible.sync="newFolderTestCaseDialog" @open="initAddFolderTestCaseDialog">
      <el-form :model="refTestCase" :rules="paramValidation" ref="refTestCase" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.project_lib" prop="project">
          <el-select v-model="refTestCase.project" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectProject">
            <el-option
              v-for="item in getSelectProject"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.test_case" prop="testcase">
          <el-select v-model="refTestCase.testcase" value-key="name" multiple size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectProjectTestCase"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('refTestCase')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newFolderTestCase('refTestCase')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: {
      lang: {
        default: {},
      },
    },
    data() {
      var validatorParams = (rule, value, callback) => {
        if (rule.required && rule.type == 'object' && !value) {
          return callback(new Error(this.lang.validator.name.required));
        } else if (rule.required && rule.type == 'array' && !value.length) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        folderId: null,
        refTestCase: {
          project: '',
          testcase: []
        },
        newFolderTestCaseDialog: false,
        paramValidation: {
          project: [{required: true, type: 'object', validator: validatorParams }],
          testcase: [{required: true, type: 'array', validator: validatorParams }]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectProject', 'getSelectProjectTestCase'])
    },
    methods: {
      ...mapActions(['addFolderTestCase', 'readProjectTestCases', 'readProjects']),
      cancel(formname) {
        this.newFolderTestCaseDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddFolderTestCaseDialog() {
        this.refTestCase.project = '';
        this.refTestCase.testcase = [];
        const obj = {
          pageSize: 'all',
          pageNumber: 1
        };
        this.readProjects(obj);
      },
      changeSelectProject(res) {
        const obj = {
          projectId: res.id,
          data: {
            pageSize: 'all',
            pageNumber: 1,
            testCaseShareFolderId: this.folderId
          }
        }
        this.readProjectTestCases(obj);
      },
      newFolderTestCase(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = this.refTestCase.testcase.map((item) => { return { testCaseShareFolderId: this.folderId, testCaseId: item.id } });
            this.addFolderTestCase(obj).then((res) => {
              this.$emit('folderTestCaseAddDone');
            }, (err) => {
              console.log(err);
            });
            this.newFolderTestCaseDialog = false;
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      this.folderId = window.location.pathname.split('/')[4];
    }
  };
</script>
