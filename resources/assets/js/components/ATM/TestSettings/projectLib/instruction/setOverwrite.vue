<template>
  <div class="component_button">
    <el-button class="button_text el_button_open" @click="showParameterConfigurationDialog">{{ lang.operator.set_overwrite }}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.operator.overwrite" :visible.sync="addParameterConfigurationDialog" :show-close="false" :append-to-body="true">
      <el-form :model="addParameterConfiguration" :rules="paramValidationParameter" ref="addParameterConfiguration" label-width="100px" label-position="right" label-suffix=":">
        <template v-if="permissionRule.add_test_case_overwrites">
          <el-form-item :label="lang.table.name" prop="name">
            <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="addParameterConfiguration.name"></el-input>
          </el-form-item>
        </template>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('addParameterConfiguration')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="commitParameterConfiguration('addParameterConfiguration')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog class="dialog" :close-on-click-modal="false" :visible.sync="parameterConfigurationDialog" :append-to-body="true" :show-close="false">
      <div slot="title">
        <span style="padding: 5px 20px;">{{ lang.operator.set_overwrite }}</span>
        <span style="padding: 5px 20px; border-left: 1px solid #eee;">
          {{ lang.table.testcase_name }}:  
          <i style="color: teal;">{{ testcaseName }}</i>
        </span>
        <span style="padding: 5px 20px; border-left: 1px solid #eee;">{{ lang.dialog.title.overwrite_name }}:  
          <i style="color: secondary;">{{ testCaseOverwrite.name }}</i>
        </span>
        <template v-if="permissionRule.add_test_case_overwrites">
          <span style="float: right; padding: 5px 20px;">
            <el-button class="button_text el_button_open" style="transform: translate(2px, 2px);" @click="showAddParameterConfigurationDialog">{{ lang.operator.overwrite }}</el-button>
          </span>
        </template>
      </div>
      <div style="display: flex;">
        <div style="flex: 3;">
          <search-pagination
            :total="total"
            :lang="lang"
            :changePageToUrl="false"
            @search="getSearchPaginationModel"
            pagination="total, prev, next, jumper"
            layout="name">
            <template v-slot:table>
              <el-table
                ref="overwriteTable"
                :data="getSelectTestCaseOverwrites"
                :show-header="false"
                style="width: 100%"
                highlight-current-row
                @cell-click="parameterConfigurationClick"
                class="row_css">
                <el-table-column
                  align="left"
                  show-overflow-tooltip
                  prop="label">
                </el-table-column>
                <template v-if="permissionRule.copy_test_case_overwrites || permissionRule.delete_test_case_overwrites">
                  <el-table-column
                    show-overflow-tooltip
                    align="left">
                    <template slot-scope="scope">
                      <template v-if="permissionRule.copy_test_case_overwrites">
                        <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);" @click="initCopyTestCaseOverWrite(scope)">{{ lang.operator.copy }}</el-button>
                      </template>
                      <template v-if="permissionRule.delete_test_case_overwrites">
                        <el-button class="button_text" style="transform: translate(0px, 0px);" @click="removeTestCaseOverwrite(scope)">{{ lang.operator.delete }}</el-button>
                      </template>
                    </template>
                  </el-table-column>
                </template>
              </el-table>
            </template>
          </search-pagination>
        </div>
        <div style="flex: 8; border-left: 1px solid #eee; overflow: auto;">
          <template v-if="getTestCaseOverWriteInstructions.data">
            <search-pagination
              :total="instructionTotal"
              :lang="lang"
              :changePageToUrl="false"
              @search="getInstructionSearchPaginationModel">
              <template v-slot:table>
                <el-table
                  :data="getTestCaseOverWriteInstructions.data"
                  border
                  :row-class-name="setOverWriteTableRowClassName"
                  :span-method="setOverWriteTableSpan"
                  class="table_overflow"
                  highlight-current-row
                  height="400">
                  <el-table-column
                    :label="lang.table.id"
                    align="left"
                    :resizable="true"
                    width="80"
                    show-overflow-tooltip>
                      <template slot-scope="scope">
                        <template v-if="scope.row.type !== 'Comment'">
                          {{scope.row.instruction.orderIndex}}
                        </template>
                        <template v-else>
                          <el-button class="button_text"  style="background-color: #515153; color: white; transform: translate(0px, 0px);">{{ lang.table.comment }}</el-button>
                          {{scope.row.instruction.comment}}
                        </template>
                      </template>
                  </el-table-column>
                  <el-table-column
                    :label="lang.table.target"
                    :resizable="true"
                    align="left"
                    show-overflow-tooltip>
                    <template slot-scope="scope">
                      <template v-if="scope.row.type == 'WebFunction'">
                        <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);">{{ lang.operator.web_function }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-if="scope.row.type == 'VirtualWebFunction'">
                        <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);">{{ lang.operator.virtual_web_function }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-else-if="scope.row.type == 'Reference'">
                        <i class="el-icon-edit" style="float: right; padding-top: 5px;"></i>
                        <el-button class="button_text" style="background-color: #5780a9; color: white; transform: translate(0px, 0px);">{{ lang.operator.reference }}</el-button>
                        <span style="color: #129a92;">{{ lang.operator.reference_message }}</span> <span style="color: #5780a9; font-size: 20px; font-weight: 600;">{{scope.row.instruction.target}}</span>
                      </template>
                      <template v-else-if="scope.row.type == 'REST_API'">
                        <el-button class="button_text" style="background-color: #828c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.rest_api }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-else-if="scope.row.type == 'WebBrowser'">
                        <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.web_browser }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-else-if="scope.row.type == 'VirtualWebBrowser'">
                        <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.virtual_web_browser }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-else-if="scope.row.type == 'SQL'">
                        <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.sql }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-else-if="scope.row.type == 'JavaScript'">
                        <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.javascript }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-else-if="scope.row.type == 'Manual'">
                        <el-button class="button_text" style="background-color: #129a92; color: white;">{{ lang.operator.manual }}</el-button>
                        {{scope.row.instruction.target}}
                      </template>
                      <template v-else-if="scope.row.type == 'StringDataProcessor'">
                        <el-button class="button_text" style="background-color: #628c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.processor }}</el-button>
                        {{ lang.table.string_check }}
                      </template>
                      <template v-else-if="scope.row.type == 'MathExpressionProcessor'">
                        <el-button class="button_text" style="background-color: #628c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.processor }}</el-button>
                        {{ lang.table.math_check }}
                      </template>
                      <template v-else-if="scope.row.type == 'Redis'">
                        <el-button class="button_text" style="background-color: #041f28; color: white; transform: translate(0px, 0px);">{{ lang.operator.redis }}</el-button>
                        {{ scope.row.instruction.target }}
                      </template>
                    </template>
                  </el-table-column>
                  <el-table-column
                    :label="lang.table.action"
                    width="100"
                    align="left"
                    show-overflow-tooltip>
                    <template slot-scope="scope">
                      <template v-if="scope.row.instruction.action">
                        {{scope.row.instruction.action}}
                      </template>
                      <template v-if="scope.row.type == 'Manual'">
                        {{ lang.operator.manual }}
                      </template>
                    </template>
                  </el-table-column>
                  <el-table-column
                    :label="lang.table.input"
                    :resizable="true"
                    align="left"
                    show-overflow-tooltip>
                    <template slot-scope="scope">
                      <template v-for="item in scope.row.data">
                        <template v-if="item.name === 'input'">
                          <i class="el-icon-edit" style="float: right; padding-top: 5px;"></i>
                          {{ item.hasOwnProperty('value') ? item.value : scope.row.instruction.input}}
                        </template>
                      </template>
                      <template v-if="scope.row.type == 'Redis'">
                        {{Object.values(scope.row.instruction.data).join(',')}}
                      </template>
                    </template>
                  </el-table-column>
                  <el-table-column
                    :label="lang.dialog.title.position_attribute"
                    :resizable="true"
                    align="left"
                    show-overflow-tooltip>
                    <template slot-scope="scope">
                      <template v-for="item in scope.row.data">
                        <template v-if="item.name === 'locatorType'">
                          <i class="el-icon-edit" style="float: right; padding-top: 5px;"></i>
                          {{ item.hasOwnProperty('value') ? item.value : scope.row.element.locatorType}}
                          <!-- {{ item.value || ''}} -->
                        </template>
                      </template>
                    </template>
                  </el-table-column>
                  <el-table-column
                    :label="lang.dialog.title.attribute_value"
                    :resizable="true"
                    align="left"
                    show-overflow-tooltip>
                    <template slot-scope="scope">
                      <template v-for="item in scope.row.data">
                        <template v-if="item.name === 'locatorValue'">
                          <i class="el-icon-edit" style="float: right; padding-top: 5px;"></i>
                          {{ item.hasOwnProperty('value') ? item.value : scope.row.element.locatorValue}}
                        </template>
                      </template>
                    </template>
                  </el-table-column>
                  <el-table-column
                    :label="lang.table.operating"
                    show-overflow-tooltip
                    align="left">
                    <template slot-scope="scope">
                      <template v-if="permissionRule.delete_instructions_overwrites || permissionRule.edit_instructions_overwrites">
                        <template v-for="item in scope.row.data">
                          <template v-if="item.name === 'input'">
                            <template v-if="permissionRule.edit_instructions_overwrites">
                              <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);" @click="showPutInstructionOverwriteDialog(scope.row)">{{lang.operator.edit}}</el-button>
                            </template>
                            <template v-if="scope.row.id">
                              <template v-if="permissionRule.delete_instructions_overwrites">
                                <el-button class="button_text" style="transform: translate(0px, 0px);" @click="showDeleteInstructionOverwriteDetail(scope.row)">{{lang.operator.delete}}</el-button>
                              </template>
                            </template>
                          </template>
                        </template>
                        <template v-if="scope.row.type === 'Reference'">
                          <template v-if="permissionRule.edit_instructions_overwrites">
                            <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);" @click="showPutInstructionOverwriteDialog(scope.row)">{{lang.operator.edit}}</el-button>
                          </template>
                          <template v-if="scope.row.id">
                            <template v-if="permissionRule.delete_instructions_overwrites">
                              <el-button class="button_text" style="transform: translate(0px, 0px);" @click="showDeleteInstructionOverwriteDetail(scope.row)">{{lang.operator.delete}}</el-button>
                            </template>
                          </template>
                        </template>
                      </template>
                    </template>
                  </el-table-column>
                </el-table>
              </template>
            </search-pagination>
          </template>
        </div>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="parameterConfigurationDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

    
    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.edit" :visible.sync="editOverWriteDialog" :append-to-body="true" :show-close="false">
      <el-form :model="instructionOverWrite" ref="instructionOverWrite" label-width="150px" label-position="right" label-suffix=":">
        <template v-for="item in Object.keys(instructionOverWrite)">
          <template v-if="item === 'locatorType'">
            <el-form-item :label="item === 'locatorType' ? lang.dialog.title.position_attribute : item">
              <el-select v-model.trim="instructionOverWrite[item]" @change="changeOverWriteSetValue(item, instructionOverWrite[item])" clearable required filterable value-key="name" size="small" :placeholder="lang.dialog.placeholder.select">
                <el-option 
                  v-for="obj in getSelectElementLocatorTypes"
                  :key="obj.label"
                  :label="obj.label"
                  :value="obj.value">
                </el-option>
              </el-select>
            </el-form-item>
          </template>
          <template v-else>
            <el-form-item :label="item === 'input' ? lang.table.input : lang.dialog.title.attribute_value">
              <el-input :placeholder="lang.dialog.placeholder.enter" @change.native="changeOverWriteSetValue(item, instructionOverWrite[item])" size="small" v-model.trim="instructionOverWrite[item]"></el-input>
            </el-form-item>
          </template>
        </template>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('instructionOverWrite')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="commitInstructionOverWrite('instructionOverWrite')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.copy_testcase_overwrite" :visible.sync="copyOverWriteDialog" :append-to-body="true" :show-close="false">
      <el-form :model="testCaseOverWriteCopy" :rules="paramValidationParameter" ref="testCaseOverWriteCopy" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="testCaseOverWriteCopy.name"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('testCaseOverWriteCopy')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="copyTestCaseOverWrite('testCaseOverWriteCopy')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.reference_testcase_overwrite" :visible.sync="referenceTestCaseOverwriteParamConfigDialog" :append-to-body="true" :show-close="false">
      <el-form :rules="paramValidationReferenceTestCaseOverwrite" :model="referenceTestCaseOverwriteParamConfig" ref="referenceTestCaseOverwriteParamConfig" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-select v-model.trim="referenceTestCaseOverwriteParamConfig.name" clearable required filterable value-key="name" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option 
              v-for="obj in getSelectRefrenceTestCaseOverwrites"
              :key="obj.label"
              :label="obj.label"
              :value="obj.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('referenceTestCaseOverwriteParamConfig')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="commitRefrenceTestCaseOverWrite('referenceTestCaseOverwriteParamConfig')">{{ lang.operator.confirm }}</el-button>
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
    permissionRule: {
      default: {}
    },
    testcaseName: ''
  },
  data() {
    var validatorTestCaseOverWrite = (rule, value, callback) => {
      if (typeof value !== 'string') {
        return callback();
      }
      const obj = {
        name: value,
        testCaseId: this.testCaseId
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        this.validateTestCaseOverWrite(obj).then((res) => {
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
      testCaseId: null,
      parameterConfigurationDialog: false,
      getParameterConfiguration: [],
      addParameterConfigurationDialog: false,
      addParameterConfiguration: {
        name: ''
      },
      paramValidationParameter: {
        name: [{required: true, validator: validatorTestCaseOverWrite, trigger: 'blur'}],
      },
      testCaseOverwrite: {},
      instructionOverWrite: {},
      instructionOverWritePut: {},
      editOverWriteDialog: false,
      testCaseOverWriteCopy: {
        name: ''
      },
      copyOverWriteDialog: false,
      copyTestCaseOverwriteId: null,
      referenceTestCaseOverwriteParamConfigDialog: false,
      referenceTestCaseOverwriteParamConfig: {
        name: ''
      },
      paramValidationReferenceTestCaseOverwrite: {
        name: [{ required: true, type: 'object', validator: validatorParams }]
      },
      refTestCaseOverwriteId: null,
      changeOverWrite: {},
      model: true,
      total: 0,
      queryObj: {
        name: '',
        pageNumber: 1,
        pageSize: 25
      },
      query: {
        pageNumber: 1,
        pageSize: 25
      },
      instructionTotal: 0
    };
  },
  computed: {
    ...mapGetters(['getTestCaseOverWriteInstructions', 'getSelectTestCaseOverwrites', 'getSelectElementLocatorTypes', 'getSelectRefrenceTestCaseOverwrites']),
  },
    watch: {
      getSelectTestCaseOverwrites: function() {
        this.total = this.getSelectTestCaseOverwrites.length;
        var flag = false;
        for (let i = 0; i < this.total; i++) {
          if (this.getSelectTestCaseOverwrites[i].value.id == this.testCaseOverwrite.id) {
            this.$nextTick(() => {
              this.$refs.overwriteTable.setCurrentRow(this.getSelectTestCaseOverwrites[i]);
            })
            flag = true;
          }
        }
        if (!flag) {
          this.testCaseOverwrite = {};
          this.getTestCaseOverWriteInstructions.data = [];
        }
      },
      getTestCaseOverWriteInstructions: function() {
        this.instructionTotal = this.getTestCaseOverWriteInstructions.data.length || 0;
      },
      getSelectRefrenceTestCaseOverwrites: function() {
        if (this.refTestCaseOverwriteId) {
          this.getSelectRefrenceTestCaseOverwrites.forEach((item) => {
            if (item.value.id === this.refTestCaseOverwriteId) {
              this.referenceTestCaseOverwriteParamConfig.name = item.value.name;
            }
          })
        } else {
          this.referenceTestCaseOverwriteParamConfig.name = '';
        }
      }
    },
  methods: {
    ...mapActions(['readTestCaseOverWriteInstructions', 'putInstructionOverWrite', 'deleteInstructionOverwrite', 'readTestCaseOverWrites', 'addTestCaseOverWrite', 'validateTestCaseOverWrite', 'deleteTestCaseOverwrite', 'copyTestCaseOverwrite', 'readRefrenceTestCaseOverwrites', 'readElementLocatorTypes']),
    getMessageDetails() {
      const obj = {};
      obj.testCaseId = this.testCaseId;
      obj.data = {
        location: true
      };
      for (var i in this.queryObj) {
        if (this.queryObj[i] !== '') {
          obj.data[i] = this.queryObj[i];
        }
      }
      this.readTestCaseOverWrites(obj);
    },
    getSearchPaginationModel(val) {
      this.queryObj = val;
      this.getMessageDetails();
    },
    getInstructionOverwriteDetails() {
      const obj = {};
      obj.id = this.testCaseOverwrite.id;
      obj.data = {
        location: true
      };
      for (var i in this.query) {
        if (this.query[i] !== '') {
          obj.data[i] = this.query[i];
        }
      }
      this.readTestCaseOverWriteInstructions(obj);
    },
    getInstructionSearchPaginationModel(val) {
      this.query = val;
      this.getInstructionOverwriteDetails();
    },
    cancel(formname) {
      this.$refs[formname].resetFields();
      switch (formname) {
        case 'addParameterConfiguration':
          this.addParameterConfigurationDialog = false;
          break;
        case 'instructionOverWrite':
          this.editOverWriteDialog = false;
          break;
        case 'testCaseOverWriteCopy':
          this.copyOverWriteDialog = false;
          break;
        case 'referenceTestCaseOverwriteParamConfig':
          this.referenceTestCaseOverwriteParamConfigDialog = false;
          break;
      }
    },
    showParameterConfigurationDialog() {
      const obj = {
        testCaseId: this.testCaseId,
        data: {
          pageNumber: 1,
          pageSize: 'all',
        }
      };
      this.readTestCaseOverWrites(obj);
      this.parameterConfigurationDialog = true;
    },
    showAddParameterConfigurationDialog() {
      this.addParameterConfiguration.name = '';
      this.addParameterConfigurationDialog = true;
    },
    commitParameterConfiguration(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            testCaseId: this.testCaseId
          };
          obj.data = [{
            name: this.addParameterConfiguration.name
          }];
          this.addTestCaseOverWrite(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          })
          this.addParameterConfigurationDialog = false;
        } else {
          return false;
        }
      })
    },
    setOverWriteTableSpan({row, column, rowIndex, columnIndex}) {
      if (row.type === "Reference") {
        if (columnIndex === 1) {
          return {
            rowspan: 1,
            colspan: 5
          };
        } else if (columnIndex === 0 || columnIndex === 6) {
          return {
            rowspan: 1,
            colspan: 1
          }
        } else {
          return {
            rowspan: 0,
            colspan: 0
          };
        }
      }
      if (row.type === "WebFunction" || row.type === "VirtualWebFunction") {
        return {
          rowspan: 1,
          colspan: 1
        };
      }
      if (row.type === "Comment") {
        if (columnIndex === 0) {
          return {
            rowspan: 1,
            colspan: 7
          }
        } else {
          return {
            rowspan: 0,
            colspan: 0
          };
        }
      }
      if (row.type === "SQL" || row.type === "JavaScript" || row.type === "Manual" || row.type === "Redis") {
        if (columnIndex === 3) {
          return {
            rowspan: 1,
            colspan: 4
          }
        } else if (columnIndex === 0 || columnIndex === 1 || columnIndex === 2) {
          return {
            rowspan: 1,
            colspan: 1
          };
        } else {
          return {
            rowspan: 0,
            colspan: 0
          };
        }
      }
      if (row.type === "WebBrowser" || row.type === "REST_API" || row.type === "VirtualWebBrowser") {
        if (columnIndex === 3) {
          return {
            rowspan: 1,
            colspan: 3
          }
        } else if (columnIndex === 0 || columnIndex === 1 || columnIndex === 2  || columnIndex === 6) {
          return {
            rowspan: 1,
            colspan: 1
          };
        } else {
          return {
            rowspan: 0,
            colspan: 0
          };
        }
      }
      if (row.type === "StringDataProcessor" || row.type === "MathExpressionProcessor") {
        if (columnIndex === 1) {
          return {
            rowspan: 1,
            colspan: 2
          };
        } else if (columnIndex === 0) {
          return {
            rowspan: 1,
            colspan: 1
          };
        } else if (columnIndex === 5) {
          return {
            rowspan: 1,
            colspan: 4
          };
        } else {
          return {
            rowspan: 0,
            colspan: 0
          };
        }
      }
    },
    setOverWriteTableRowClassName({row, rowIndex}) {
      if (row.type === 'Reference') {
        return 'row_css overwrite_reference'
      }
      if (row.type === 'JavaScript' || row.type === "SQL" || row.type === "Manual"|| row.type === "Redis") {
        return 'row_css'
      }
      if (row.type === 'REST_API' || row.type === "WebBrowser") {
        return 'row_css overwrite_api'
      }
      if (row.type === 'Comment') {
        return 'row_css overwrite_comment'
      }
      if (row.type == 'StringDataProcessor' || row.type == 'MathExpressionProcessor') {
        return 'row_css overwrite_validate'
      }
      return 'row_css'
    },
    showPutInstructionOverwriteDialog(row) {
      this.changeOverWrite = {};
      if (row.type === 'Reference') {
        this.instructionOverWritePut = row;
        const obj = {
          testCaseId: row.instruction.refTestCaseId,
          data: {
            orderBy: "id desc",
            pageNumber: 1,
            pageSize: 'all'
          }
        };
        this.readRefrenceTestCaseOverwrites(obj);
        this.refTestCaseOverwriteId = row.refTestCaseOverwriteId;
        this.referenceTestCaseOverwriteParamConfigDialog = true;
      } else {
        this.refTestCaseOverwriteId = null;
        this.instructionOverWrite = {};
        this.instructionOverWritePut = row;
        row.data.forEach((item) => {
          if (item.name === 'locatorType') {
            const obj = {
              id: row.element.typeId
            };
            this.readElementLocatorTypes(obj);
          }
          if (item.name === 'input') {
            this.$set(this.instructionOverWrite, item.name, item.value || row.instruction[item.name]);
            this.changeOverWrite[item.name] = item.value || row.instruction[item.name];
          } else {
            this.$set(this.instructionOverWrite, item.name, item.value || row.element[item.name]);
            this.changeOverWrite[item.name] = item.value || row.element[item.name];
          }
        })
        if (Object.keys(this.instructionOverWrite).length) {
          this.editOverWriteDialog = true;
        }
      }
    },
    showDeleteInstructionOverwriteDetail(row) {
      this.$confirm(this.lang.dialog.title.delete_info_1, this.lang.dialog.title.delete_instruction_overwrite, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning'
      }).then(() => {
        const obj = {
          id: row.id
        };
        this.deleteInstructionOverwrite(obj).then((res) => {
          this.getInstructionOverwriteDetails();
        }, (err) => {
          this.getInstructionOverwriteDetails();
        })
      }).catch((err) => {
        console.log(err);
        this.$message({
          type:'info',
          message: this.lang.operator.undelete
        });
      });
    },
    changeOverWriteSetValue(item, value) {
      this.changeOverWrite[item] = '';
      this.changeOverWrite[item] = value;
    },
    commitInstructionOverWrite(formname) {
      const obj = JSON.parse(JSON.stringify(this.instructionOverWritePut));
      for (let i = 0; i < obj.data.length; i++) {
        obj.data[i].value = this.changeOverWrite[obj.data[i].name];
      }
      obj.testCaseOverwriteId = this.testCaseOverwrite.id;
      this.putInstructionOverWrite([obj]).then((res) => {
        this.getInstructionOverwriteDetails();
      }, (err) => {
        this.getInstructionOverwriteDetails();
      })
      this.editOverWriteDialog = false;
    },
    parameterConfigurationClick(row, column, cell, event) {
      this.testCaseOverwrite = row.value;
      if (column.property === 'label') {
        this.getInstructionOverwriteDetails();
      } else {
        return false;
      }
    },
    removeTestCaseOverwrite(scope) {
      this.$confirm(this.lang.dialog.title.delete_info_2, this.lang.dialog.title.delete_testcase_overwrite, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning'
      }).then(() => {
        const obj = {
          id: scope.row.value.id
        };
        this.deleteTestCaseOverwrite(obj).then((res) => {
          this.getMessageDetails();
        }, (err) => {
          this.getMessageDetails();
        })
      }).catch((err) => {
        console.log(err);
        this.$message({
          type:'info',
          message: this.lang.operator.undelete
        });
      });
    },
    initCopyTestCaseOverWrite(scope) {
      this.testCaseOverWriteCopy.name = '';
      this.copyTestCaseOverwriteId = scope.row.value.id;
      this.copyOverWriteDialog = true;
    },
    copyTestCaseOverWrite(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.copyTestCaseOverwriteId,
            name: this.testCaseOverWriteCopy.name
          }
          this.copyTestCaseOverwrite([obj]).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            this.getMessageDetails();
          })
          this.copyOverWriteDialog = false;
        } else {
          return false;
        }
      })
    },
    commitRefrenceTestCaseOverWrite(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = JSON.parse(JSON.stringify(this.instructionOverWritePut));
          this.referenceTestCaseOverwriteParamConfig.name.id ? obj.refTestCaseOverwriteId = this.referenceTestCaseOverwriteParamConfig.name.id : null;
          obj.testCaseOverwriteId = this.testCaseOverwrite.id;
          this.putInstructionOverWrite([obj]).then((res) => {
            const param = {
              id: this.testCaseOverwrite.id
            };
            this.readTestCaseOverWriteInstructions(param);
          }, (err) => {
            const param = {
              id: this.testCaseOverwrite.id
            };
            this.readTestCaseOverWriteInstructions(param);
          })
          this.referenceTestCaseOverwriteParamConfigDialog = false;
        } else {
          return false;
        }
      })
    },
  },
  mounted() {
    this.testCaseId = window.location.pathname.split('/')[6];
  }
};
</script>