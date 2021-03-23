<template>
  <div class="component_button">
    <el-button class="button_text_table el_button_creat"  @click="showBulkAddToRunListDialog">{{lang.operator.add_to_run}}</el-button>

    <el-dialog  :title="lang.dialog.title.select_or_create_run" :close-on-click-modal="false" :visible.sync="bulkAddToRunListDialog" :show-close="false">
      <el-form :model="runSelectContainer" ref="runSelectContainer" :rules="paramValidationSelectContainer" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="runList">
          <el-row :gutter="10">
            <el-col :span="20">
              <el-select v-model="runSelectContainer.runList" required value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_run_plan">
                <el-option
                  v-for="item in getSelectRunContainer"
                  :key="item.label"
                  :label="item.label"
                  :value="item.value">
                  </el-option>
              </el-select>
            </el-col>
            <template v-if="permissionRule.add_run_sets">
              <el-col :span="4">
                <el-button class="el_button_open" size="mini" round @click="newRunContainerDialog = true">{{ lang.operator.new }}</el-button>
              </el-col>
            </template>
          </el-row>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('runSelectContainer')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitBulkAddToRunList('runSelectContainer')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.dialog.title.add_run_list" :close-on-click-modal="false" :visible.sync="newRunContainerDialog" @open="initAddRunContainerDialog" :show-close="false">
      <el-form :model="runContainer" :rules="paramValidationRunContainer" ref="runContainer" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input  :placeholder="lang.dialog.placeholder.enter_name" size="small" v-model.trim="runContainer.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="runContainer.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('runContainer')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newRunContainer('runContainer')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.operator.open" :close-on-click-modal="false" :visible.sync="jumpPageDialog" :show-close="false">
      <el-form label-width="0px" label-position="right" label-suffix=":">
        <el-form-item>
          <div style="display: flex;">
            <div style="flex: 1; text-align: center;">
              <el-button class="el_button_open" size="medium" round @click="navigatorToRunList">{{ lang.operator.go_to_run }}</el-button>
            </div>
            <div style="flex: 1; text-align: center;">
              <el-button type="primary" size="medium" round @click="jumpPageDialog = false">{{ lang.operator.stay_test_case }}</el-button>
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
      permissionRule: {
        default: {}
      }
    },
    data() {
      var validatorRunContainerName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateRunContainerName(obj).then((res) => {
            if (parseInt(res.metadata.count) === 0) {
              return callback();
            } else {
              return callback(new Error(this.lang.validator.name.exist));
            }
          }, (err) => {
            console.log(err)
          });
        } else {
          return callback(new Error(this.lang.validator.name.consists));
        }
      };
      var validatorParams = (rule, value, callback) => {
        if (rule.required && !value) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        bulkAddToRunListDialog: false,
        runSelectContainer: {
          runList: {}
        },
        paramValidationSelectContainer: {
          runList: [{required: true, type: 'object', validator: validatorParams }]
        },
        jumpPageDialog: false,
        newRunListForBulkDialog: false,
        newRunList: {},
        newRunListId: null,
        newRunContainerDialog: false,
        runContainer: {
          name: '',
          comment: ''
        },
        paramValidationRunContainer: {
          name: [{required: true, validator: validatorRunContainerName, trigger: 'blur'}]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectRunContainer'])
    },
    methods: {
      ...mapActions(['readRunContainer', 'addTestCaseContainer', 'validateRunContainerName', 'addRunContainer']),
      cancel(formname) {
        this.$refs[formname].resetFields();
        this.bulkAddToRunListDialog = false;
        this.newRunContainerDialog = false;
      },
      showBulkAddToRunListDialog() {
        const len = this.selections.length;
        if (len) {
          this.runSelectContainer.runList = '';
          this.bulkAddToRunListDialog = true;
          let obj = {
            pageNumber: 1,
            pageSize: 'all',
            orderBy: 'id desc',
            location: true
          };
          this.readRunContainer(obj);
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.testcase_error_message
          });
        }
      },
      addTestCaseToRunList(val) {
        const obj = {
          runSetId: val,
        };
        this.newRunListId = null;
        this.newRunListId = obj.runSetId;
        obj.data = this.selections.map((item) => { return {runSetId: obj.runSetId, testCaseId: item.id} });
        this.addTestCaseContainer(obj.data).then((res) => {
          this.$emit('clearSelect');
          this.jumpPageDialog = true;
        }, (err) => {
          console.log(err);
        })
        this.bulkAddToRunListDialog = false;
      },
      submitBulkAddToRunList(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const id = this.runSelectContainer.runList.id;
            this.addTestCaseToRunList(id);
            this.cancel(formname);
          } else {
            return false;
          }
        });
      },
      navigatorToRunList() {
        window.location.href = '/atm/TestSetting/RunList/' + this.newRunListId + '/TestCase';
      },
      initAddRunContainerDialog() {
        this.runContainer.name = '';
        this.runContainer.comment = '';
        this.bulkAddToRunListDialog = false;
      },
      newRunContainer(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.runContainer.name,
              comment: this.runContainer.comment
            };
            this.addRunContainer([obj]).then((res) => {
              const id = res.data[0].id;
              this.addTestCaseToRunList(id);
            }, (err) => {
              console.log(err);
            });
            this.cancel(formname);
            this.newRunContainerDialog = false;
          } else {
            return false;
          }
        });
      },
    },
  };
</script>
