<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newTestCaseContainerDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="newTestCaseContainerDialog" @open="initAddTestCaseContainerDialog" :show-close="false" :append-to-body="true">
      <el-form :model="testCaseContainer" :rules="paramValidation" ref="testCaseContainer" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.project_lib" prop="project">
          <el-select v-model="testCaseContainer.project" value-key="name" size="small" @change="changeSelectionProjects" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectProject"
              :key="item.label + item.value.id"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.test_case" prop="testCase">
          <el-select v-model="testCaseContainer.testCase" value-key="name" size="small" multiple filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectTestCase"
              :key="item.label + item.value.id"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('testCaseContainer')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newTestCaseContainer('testCaseContainer')">{{ lang.operator.confirm }}</el-button>
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
        if (rule.required && !value) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        runListId: null,
        testCaseContainer: {
          project: {},
          testCase: []
        },
        newTestCaseContainerDialog: false,
        paramValidation: {
          project: [{required: true, type: 'object', validator: validatorParams }],
          testCase: [{required: true, type: 'object', validator: validatorParams }]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectProject', 'getSelectTestCase'])
    },
    methods: {
      ...mapActions(['addTestCaseContainer', 'readProjects', 'readRefProjectTestCases']),
      cancel(formname) {
        this.newTestCaseContainerDialog = false;
        this.$refs[formname].resetFields();
      },
      changeSelectionProjects() {
        this.testCaseContainer.testCase = [];
        const obj = {
          projectId: this.testCaseContainer.project.id
        }
        obj.data = {
          pageSize: 'all',
          pageNumber: 1,
        }
        this.readRefProjectTestCases(obj);
      },
      initAddTestCaseContainerDialog() {
        this.testCaseContainer.project = {};
        this.testCaseContainer.testCase = [];
        const obj = {
          pageSize: 'all',
          pageNumber: 1,
        }
        this.readProjects(obj);
      },
      newTestCaseContainer(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = this.testCaseContainer.testCase.map((item) => { return { runSetId: this.runListId, testCaseId: item.id } });
            this.addTestCaseContainer(obj).then((res) => {
              this.$emit('testCaseAddDone');
            }, (err) => {
              console.log(err);
            })
            this.newTestCaseContainerDialog = false;
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      this.runListId = window.location.pathname.split('/')[4];
    }
  };
</script>
