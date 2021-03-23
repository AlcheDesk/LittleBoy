<template>
  <div class="component_button">
    <template v-if="permissionRule.run_set_test_case_driver_package_set">
      <el-button class="button_text_table" @click="showTestCaseDriverPackDialog">{{lang.operator.set_drive}}</el-button>
    </template>
    <template v-if="permissionRule.run_set_test_case_overwrite_set">
      <el-button class="button_text_table" @click="showTestCaseOverwriteDialog">{{lang.operator.set_overwrite}}</el-button>
    </template>

    
    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.set_testcase_overwrite"  :visible.sync="setTestCaseOverwriteDialog" :show-close="false" :append-to-body="true">
      <el-form :model="testCaseOverwrite" :rules="paramValidationOverwriter" ref="testCaseOverwrite" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.testcase_name" prop="name">
          <el-select v-model.trim="testCaseOverwrite.name" clearable required filterable value-key="name" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option 
              v-for="obj in getSelectTestCaseOverwrites"
              :key="obj.label"
              :label="obj.label"
              :value="obj.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('testCaseOverwrite')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="commitTestCaseSetOverwrite('testCaseOverwrite')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.set_testcase_driver"  :visible.sync="setTestCaseDriverPackDialog" :show-close="false" :append-to-body="true">
      <el-form :rules="paramValidationDriverPack" :model="testCaseDriverPack" ref="testCaseDriverPack" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.driver_name" prop="name">
          <el-select v-model="testCaseDriverPack.name" value-key="name" clearable size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="(item, index) in getSelectTestCaseDriverPacks"
              :key="item.label + index"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('testCaseDriverPack')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="commitTestCaseSetDriverPack('testCaseDriverPack')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: {
      permissionRule: {
        default: {},
      },
      lang: {
        default: {},
      },
      row: {
        default: {},
      }
    },
    data() {
      var validateOverwrite = (rule, value, callback) => {
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (!this.testCaseOverwrite.name.id || !this.testCaseDriverPackId) {
          callback();
        }
        const obj = {
          runSetId: this.runListId,
          testCaseId: this.testCaseId,
          testCaseOverwriteId: this.testCaseOverwrite.name.id || null,
          driverPackId: this.testCaseDriverPackId,
        };
        this.countTestCaseContainerOverwriteOrDriverPack(obj).then((res) => {
          if (!res.metadata.count) {
            callback();
          } else {
            callback(new Error(this.lang.validator.name.exist))
          }
        })
      }
      var validateDriverPack = (rule, value, callback) => {
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (!this.testCaseDriverPack.name.id || !this.testCaseOverwriteId) {
          callback();
        }
        const obj = {
          runSetId: this.runListId,
          testCaseId: this.testCaseId,
          driverPackId: this.testCaseDriverPack.name.id || null,
          testCaseOverwriteId: this.testCaseOverwriteId,
        };
        this.countTestCaseContainerOverwriteOrDriverPack(obj).then((res) => {
          if (!res.metadata.count) {
            callback();
          } else {
            callback(new Error(this.lang.validator.name.exist))
          }
        })
      };
      return {
        runListId: null,
        setTestCaseOverwriteDialog: false,
        testCaseOverwrite: {
          name: ''
        },
        testCaseId: null,
        testCaseDriverPack: {
          name: ''
        },
        paramValidationOverwriter: {
          name: [{required: true, validator: validateOverwrite, trigger: 'blur'}]
        },
        paramValidationDriverPack: {
          name: [{required: true, validator: validateDriverPack, trigger: 'blur'}]
        },
        setTestCaseDriverPackDialog: false,
        linkId: null,
        testCaseOverwriteId: null,
        testCaseDriverPackId: null,
      };
    },
    computed: {
      ...mapGetters(['getSelectTestCaseOverwrites', 'getSelectTestCaseDriverPacks'])
    },
    methods: {
      ...mapActions(['readTestCaseOverWrites', 'readTestCaseDriverPacks', 'addTestCaseContainer', 'countTestCaseContainerOverwriteOrDriverPack']),
      cancel(formname) {
        this.setTestCaseOverwriteDialog = false;
        this.setTestCaseDriverPackDialog = false;
        this.$refs[formname].resetFields();
      },
      showTestCaseOverwriteDialog() {
        const obj = {
          testCaseId: this.row.testCase.id,
          data: {
            pageNumber: 1,
            pageSize: 'all',
            orderBy: 'id desc'
          }
        };
        this.testCaseId = this.row.testCase.id;
        this.linkId = this.row.id;
        this.testCaseDriverPackId = this.row.driverPackId;
        this.readTestCaseOverWrites(obj);
        this.testCaseOverwrite.name = '';
        this.setTestCaseOverwriteDialog = true;
      },
      commitTestCaseSetOverwrite(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.linkId,
              runSetId: this.runListId,
              testCaseId: this.testCaseId,
              testCaseOverwriteId: this.testCaseOverwrite.name.id || null,
              driverPackId: this.testCaseDriverPackId
            };
            this.addTestCaseContainer([obj]).then((res) => {
              this.$emit('setParamDone');
            }, (err) => {
              console.log(err)
            });
            this.setTestCaseOverwriteDialog = false;
          }
        })
      },
      showTestCaseDriverPackDialog() {
        this.testCaseId = this.row.testCase.id;
        this.linkId = this.row.id;
        this.testCaseOverwriteId = this.row.testCaseOverwriteId;
        const obj = {
          testCaseId: this.row.testCase.id,
          data: {
            pageNumber: 1,
            pageSize: 'all',
            orderBy: 'id desc'
          }
        };
        this.testCaseDriverPack.name = '';
        this.readTestCaseDriverPacks(obj);
        this.setTestCaseDriverPackDialog = true;
      },
      commitTestCaseSetDriverPack(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.linkId,
              runSetId: this.runListId,
              testCaseId: this.testCaseId,
              driverPackId: this.testCaseDriverPack.name.id || null,
              testCaseOverwriteId: this.testCaseOverwriteId
            };
            this.addTestCaseContainer([obj]).then((res) => {
              this.$emit('setParamDone');
            }, (err) => {
              console.log(err)
            });
            this.setTestCaseDriverPackDialog = false;
          }
        })
      },
    },
    mounted() {
      this.runListId = window.location.pathname.split('/')[4];
    }
  };
</script>