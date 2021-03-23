<template>
  <div class="component_button">
    <el-button class="button_text_table"  @click="showBulkAddToTestCaseDialog">{{lang.operator.add_to_testcase}}</el-button>

    <el-dialog :title="lang.operator.add_to_testcase" :close-on-click-modal="false" :visible.sync="bulkAddToTestCaseDialog" :show-close="false" :append-to-body="true">
      <el-form :model="runSelectContainer" :rules="paramValidation" ref="runSelectContainer" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.project_lib" prop="project">
          <el-select v-model="runSelectContainer.project" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectProject">
            <el-option
              v-for="item in getSelectProject"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.test_case" prop="testCase">
          <el-select v-model="runSelectContainer.testCase" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectProjectTestCase">
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
        <el-button @click="cancel('runSelectContainer')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitBulkAddToRunList('runSelectContainer')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.operator.open" :close-on-click-modal="false" :visible.sync="jumpPageDialog" :show-close="false">
      <el-form label-width="0px" label-position="right" label-suffix=":">
        <el-form-item>
          <div style="display: flex;">
            <div style="flex: 1; text-align: center;">
              <el-button class="el_button_open" size="medium" round @click="navigatorToTestCase">{{ lang.operator.go_to_testcase }}</el-button>
            </div>
            <div style="flex: 1; text-align: center;">
              <el-button type="primary" size="medium" round @click="jumpPageDialog = false">{{ lang.operator.stay_folder_testcase }}</el-button>
            </div>
          </div>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="jumpPageDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    props: {
      lang: {
        default: {},
      },
      selections: {
        default: [],
      },
    },
    data() {
      var validatorParams = (rule, value, callback) => {
        if (rule.required && !value) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        bulkAddToTestCaseDialog: false,
        runSelectContainer: {
          project: '',
          testCase: '',
        },
        paramValidation: {
          project: [{required: true, type: 'object', validator: validatorParams }],
          testCase: [{required: true, type: 'object', validator: validatorParams }]
        },
        jumpPageDialog: false,
        folderId: null,
      };
    },
    computed: {
      ...mapGetters(['getSelectProject', 'getSelectProjectTestCase', 'getTestCaseInstructions'])
    },
    methods: {
      ...mapActions([ 'readProjectTestCases', 'readProjects', 'addTestCaseInstruction', 'readTestCaseInstructions']),
      cancel(formname) {
        this.$refs[formname].resetFields();
        this.bulkAddToTestCaseDialog = false;
      },
      showBulkAddToTestCaseDialog() {
        const len = this.selections.length;
        if (len) {
          this.runSelectContainer = {
            project: '',
            testCase: '',
          };
          this.bulkAddToTestCaseDialog = true;
          let obj = {
            pageNumber: 1,
            pageSize: 'all',
            orderBy: 'id desc'
          };
          this.readProjects(obj);
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.testcase_error_message
          });
        }
      },
      changeSelectProject(val) {
        this.projectId = val.id;
        const obj = {
          projectId: val.id
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all',
          orderBy: 'id desc'
        };
        this.readProjectTestCases(obj);
        this.runSelectContainer.testCase = '';
      },
      changeSelectProjectTestCase(val) {
        this.testCaseId = val.id;
        const obj = {
          testCaseId: val.id
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all',
          orderBy: 'id desc'
        };
        this.readTestCaseInstructions(obj);
      },
      submitBulkAddToRunList(val) {
        const obj = {
          testCaseId: this.testCaseId
        };
        obj.data = this.selections.map((item) => {
          return {
            type: 'Reference',
            testCaseShareFolderId: this.folderId,
            orderIndex: this.getTestCaseInstructions.metadata.count++,
            refTestCaseId: item.testCase.id,
            refTestCaseOverwriteId: null,
          };
        });
        this.addTestCaseInstruction(obj).then((res) => {
          this.$emit('clearSelect');
          this.jumpPageDialog = true;
        }, (err) => {
          console.log(err);
        })
        this.bulkAddToTestCaseDialog = false;
      },
      navigatorToTestCase() {
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/Instruction/?page=1+25';
      },
    },
    mounted() {
      this.folderId = window.location.pathname.split('/')[4];
    }
  };
</script>
