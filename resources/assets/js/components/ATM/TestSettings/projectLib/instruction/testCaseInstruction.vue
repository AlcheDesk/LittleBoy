<template>
  <div>
    <div class="instruction_bar">
      <el-row class="bar_row">
        <template v-if="permissionRule.edit_instructions">
          <el-col :span="4">
            <el-dropdown size="mini" trigger="click" @command="setColor">
              <el-button class="drop_button">
                {{ lang.operator.color_label }}<i class="el-icon-arrow-down el-icon--right"></i>
              </el-button>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item class="blue" command="BLUE">Blue
                </el-dropdown-item>
                <el-dropdown-item class="green" command="GREEN">Green
                </el-dropdown-item>
                <el-dropdown-item class="orange" command="ORANGE">Orange
                </el-dropdown-item>
                <el-dropdown-item class="red" command="RED">Red
                </el-dropdown-item>
                <el-dropdown-item class="grey" command="GREY">Grey
                </el-dropdown-item>
                <el-dropdown-item class="white" command="WHITE">White
                </el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </el-col>
        </template>
        <el-col :span="20" class="text_right">
          <div class="operator_label">{{ lang.table.operating }}：</div>
          <div class="operator_content">
            <template v-if="permissionRule.delete_instructions">
              <el-button class="button_text" @click="removeProjectCaseInstruction">{{ lang.operator.delete }}</el-button>
            </template>
            <template v-if="permissionRule.copy_instructions">
              <el-button class="button_text" @click="copyInstruction">{{ lang.operator.copy }}</el-button>
            </template>
            <template v-if="permissionRule.view_test_case_overwrites">
              <set-overwrite
                :lang="lang"
                :testcaseName="testCaseName"
                :permissionRule="permissionRule">
              </set-overwrite>
            </template>
          </div>
        </el-col>
      </el-row>
      <add
        :selections="instructionSelectData"
        :lang="lang"
        :permissionRule="permissionRule"
        :hiddenInstructions="hiddenInstructions"
        :orderIndex="orderIndex"
        @instructionAddDone="getMessageDetails">
      </add>
    </div>

    <search-pagination
      :total="total"
      :lang="lang"
      layout="orderIndex, comment, operation"
      @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getTestCaseInstructions.data"
          border
          :row-style="setRowColor"
          :row-class-name="setRowClassName"
          :span-method="arraySpanMethod"
          :row-key="setRowKey"
          @selection-change="instructionsHandleSelectionChange"
          @row-dblclick="showUpdateInstructionDialog"
          style="width: auto">
          <el-table-column
            type="selection"
            align="left"
            width="50">
          </el-table-column>
          <el-table-column
            :label="lang.table.id"
            align="left"
            :resizable="true"
            width="80"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="scope.row.type !== 'Comment'">
                {{scope.row.orderIndex}}
              </template>
              <template v-else>
                <el-button class="button_text"  style="background-color: #515153; color: white; transform: translate(0px, 0px);">{{ lang.table.comment }}</el-button>
                 {{scope.row.comment}}
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
                {{scope.row.target}}
              </template>
              <template v-if="scope.row.type == 'VirtualWebFunction'">
                <el-button class="button_text" style="background-color: #4e5c6c; color: white; transform: translate(0px, 0px);">{{ lang.operator.virtual_web_function }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.type == 'Performance'">
                <el-button class="button_text" style="background-color: #5780a9; color: white; transform: translate(0px, 0px);">{{ lang.operator.performance }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.type == 'Manual'">
                <el-button class="button_text" style="background-color: #129a92; color: white; transform: translate(0px, 0px);">{{ lang.operator.manual }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.type == 'Reference'">
                <el-button class="button_text" style="background-color: #5780a9; color: white; transform: translate(0px, 0px);">{{ lang.operator.reference }}</el-button>
                <span style="color: #129a92;">{{ lang.operator.reference_message }}</span> <span style="color: #5780a9; font-size: 20px; font-weight: 600;">{{scope.row.target.split('.')[1] + '.' + scope.row.target.split('.')[0]}} ({{ scope.row.refTestCaseId }})</span>
              </template>
              <template v-else-if="scope.row.type == 'CheckEmail'">
                <el-button class="button_text email_button" style="color: white; transform: translate(0px, 0px);">{{ lang.operator.email }}</el-button>
                  {{ lang.operator.email + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.type == 'REST_API'">
                <el-button class="button_text" style="background-color: #828c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.rest_api }}</el-button>
                {{scope.row.target}}
              </template>
              <template v-else-if="scope.row.type == 'WebBrowser'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.web_browser }}</el-button>
                {{ lang.operator.web_browser + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.type == 'VirtualWebBrowser'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.virtual_web_browser }}</el-button>
                {{ lang.operator.virtual_web_browser + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.type == 'SQL'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.sql }}</el-button>
                {{ lang.operator.sql + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.type == 'JavaScript'">
                <el-button class="button_text" style="transform: translate(0px, 0px);">{{ lang.operator.javascript }}</el-button>
                {{ lang.operator.javascript + lang.table.operating }}
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
                {{ scope.row.target }}
              </template>
              <template v-else-if="scope.row.type == 'RPC_Dubbo'">
                <el-button class="button_text" style="background-color: #dc78e9; color: white; transform: translate(0px, 0px);">{{ lang.operator.rpc_dubbo }}</el-button>
                {{ lang.operator.rpc_dubbo + lang.table.operating }}
              </template>
              <template v-else-if="scope.row.type == 'StringUtil'">
                <el-button class="button_text" style="background-color: #628c9a; color: white; transform: translate(0px, 0px);">{{ lang.operator.string_util }}</el-button>
                {{ lang.table.string_util }}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            width="1"
            align="left"
            type="expand">
            <template slot-scope="scope">
              <template v-if="scope.row.type == 'Manual'">
                <el-form label-position="left" label-suffix="：">
                  <el-form-item :label="lang.dialog.title.step" class="manual_expand_text emanual_expand_style">
                    <span>{{ scope.row.stepDescription }}</span>
                  </el-form-item>
                  <el-form-item :label="lang.dialog.title.expected" class="manual_expand_text emanual_expand_style">
                    <span>{{ scope.row.expectedDescription }}</span>
                  </el-form-item>
                </el-form>
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.action"
            width="100"
            align="left"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="scope.row.action">
                {{scope.row.action}}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.input"
            :resizable="true"
            align="left"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="scope.row.type == 'Manual'">
                {{scope.row.comment}}
              </template>
              <template v-else-if="['WebFunction','VirtualWebFunction','REST_API','WebBrowser','VirtualWebBrowser','SQL','JavaScript','StringDataProcessor','MathExpressionProcessor'].includes(scope.row.type)">
                {{scope.row.input}}
              </template>
              <template v-else-if="scope.row.type == 'Reference'">
                {{scope.row.refTestCaseOverwriteName}}
              </template>
              <template v-else-if="scope.row.type == 'Redis'">
                {{ scope.row.action.slice(6) + ' ' +  scope.row.data.key + ' ' + (scope.row.data.value || '') + ' ' + (scope.row.data.field || '') }}
              </template>
              <template v-else-if="scope.row.type == 'RPC_Dubbo'">
                  {{scope.row.input}}
              </template>
              <template v-else-if="scope.row.type == 'StringUtil'">
                {{scope.row.input}}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.option"
            :resizable="true"
            align="left"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="['WebFunction','VirtualWebFunction','JavaScript','SQL','REST_API','Redis','StringUtil'].includes(scope.row.type)">
                {{ stepOptionsTable(scope) }}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.comment"
            :resizable="true"
            align="left"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="scope.row.type !== 'Comment' && scope.row.type !== 'Manual'">
                {{scope.row.comment}}
              </template>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>

    <edit
      :updateInstruction="instructionRow"
      :lang="lang"
      :permissionRule="permissionRule"
      @instructionCancelEdit="cancelEdit"
      @instructionEditDone="getMessageDetails">
    </edit>

  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import Sortable from 'sortablejs'
  import Add from './Add'
  import SetOverwrite from './setOverwrite'
  import Edit from './Edit'

  export default {
    props: ['message', 'testCaseName'],
    data() {
      return {
        projectId: null,
        testCaseId: null,
        permissionRule: {},
        hiddenInstructions: [],
        lang: {},
        color: '#fff',
        total: 0,
        orderIndex: 0,
        sortable: null,
        list: [],
        instructionRow: {},
        queryObj: {
          orderIndex: '',
          comment: '',
          pageNumber: 1,
          pageSize: 25
        },
        instructionSelectData: 0,
        colorObject: {
          WHITE: '#f5f7fa',
          BLUE: '#5780a9',
          GREEN: '#61b491',
          GREY: '#828c9a',
          ORANGE: '#eba270',
          RED: '#db4a49'
        },
      }
    },
    computed: {
      ...mapGetters(['getTestCaseInstructions']),
    },
    watch: {
      getTestCaseInstructions: function() {
        this.total = this.getTestCaseInstructions.metadata.count || 0;
        this.orderIndex = this.getTestCaseInstructions.metadata.count || 0;
        this.list = this.getTestCaseInstructions.data.slice(0);
        if (this.permissionRule.edit_instructions) {
          this.$nextTick(() => {
            this.setSort()
          })
        }
      },
    },
    components: { Add, SetOverwrite, Edit },
    methods: {
      ...mapActions(['readTestCaseInstructions', 'deleteTestCaseInstruction', 'copyTestCaseInstruction', 'updateTestCaseInstruction']),
      objectIsEmpty(obj) {
        for (var key in obj) {
          return false;
        }
        return true;
      },
      instructionsHandleSelectionChange(val) {
        this.instructionSelectData = val;
      },
      stepOptionsTable: function(scope) {
        var arr = [];
        var str = '';
        if (scope.row.instructionOptions) {
          for (let i = 0; i < scope.row.instructionOptions.length; i++) {
            if (scope.row.instructionOptions[i].valueRequired) {
              arr.push(scope.row.instructionOptions[i].name + ':' + scope.row.instructionOptions[i].value);
            } else {
              arr.push(scope.row.instructionOptions[i].name);
            }
          }
        }
        str = arr.join(',');
        return str;
      },
      getMessageDetails() {
        const obj = {};
        obj.testCaseId = this.testCaseId;
        obj.data = {
          pageNumber: this.queryObj.pageNumber,
          pageSize: this.queryObj.pageSize,
          orderBy: 'orderIndex asc'
        };
        for (var i in this.queryObj) {
          if (this.queryObj[i] && this.queryObj[i] != '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.readTestCaseInstructions(obj);
      },
      cancelEdit() {
        this.instructionRow = {};
      },
      showUpdateInstructionDialog(row) {
        this.instructionRow = row;
      },
      removeProjectCaseInstruction() {
        if (this.instructionSelectData.length) {
          this.$confirm(this.lang.dialog.title.delete + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
            confirmButtonText: this.lang.operator.confirm,
            cancelButtonText: this.lang.operator.cancel,
            type: 'warning'
          }).then(() => {
            const param = this.instructionSelectData;
            var arr = [];
            param.forEach(function(element, index) {
              arr.push(element.id);
            });
            const str = arr.join(',');
            this.deleteTestCaseInstruction(str).then((res) => {
              this.getMessageDetails();
            }, (err) => {
              console.log(err);
            });
          }).catch((err) => {
            console.log(err);
            this.$message({
              type:'info',
              message: this.lang.operator.undelete
            });
          });
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.null_error_message
          });
        }
      },
      copyInstruction() {
        if (this.instructionSelectData.length == 1) {
          this.$confirm(this.lang.dialog.title.copy + this.lang.dialog.title.delete_continue, this.lang.dialog.title.copy, {
            confirmButtonText: this.lang.operator.confirm,
            cancelButtonText: this.lang.operator.cancel,
            type: 'warning'
          }).then(() => {
            let param = {
              id: this.instructionSelectData[0].id,
              orderIndex: this.instructionSelectData[0].orderIndex + 1
            }
            const param1 = {
              testCaseId: this.testCaseId,
              data: [param]
            }
            this.copyTestCaseInstruction(param1).then((res) => {
              this.getMessageDetails();
            }, (err) => {
              console.log(err);
            });
          }).catch((err) => {
            console.log(err);
            this.$message({
              type:'info',
              message: this.lang.dialog.title.uncopy
            });
          });
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.only_error_message
          });
        }
      },
      setRowColor({row, rowIndex}) {
        if (row.type == 'Comment') {
          return {}
        } else {
          return {
            background: this.colorObject[row.color]
          }
        }
      },
      setRowClassName({row, rowIndex}) {
        if (row.type === 'Comment') {
          return 'row_css type_comment'
        }
        if (row.type == 'Manual') {
          return 'row_css type_manual'
        }
        if (row.type == 'Reference') {
          return 'row_css type_reference'
        }
        if (row.type == 'REST_API') {
          return 'row_css type_api'
        }
        if (row.type == 'StringDataProcessor' || row.type == 'MathExpressionProcessor') {
          return 'row_css validate'
        }
        return 'row_css'
      },
      arraySpanMethod({row, column, rowIndex, columnIndex}) {
        if (row.type === "Comment") {
          if (columnIndex === 1) {
            return {
              rowspan: 1,
              colspan: 7
            };
          } else if (columnIndex === 0) {
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
        if (row.type === "Reference") {
          if (columnIndex === 2) {
            return {
              rowspan: 1,
              colspan: 3
            };
          } else if (columnIndex === 0 || columnIndex === 7 || columnIndex === 1) {
            return {
              rowspan: 1,
              colspan: 1
            };
          } else if (columnIndex === 5) {
            return {
              rowspan: 1,
              colspan: 2
            };
          } else {
            return {
              rowspan: 0,
              colspan: 0
            };
          }
        }
        if (row.type === "REST_API") {
          if (columnIndex === 3) {
            return {
              rowspan: 1,
              colspan: 0
            };
          } else if (columnIndex === 4) {
            return {
              rowspan: 1,
              colspan: 2
            };
          } else if (columnIndex === 2 || columnIndex === 1 || columnIndex === 0 || columnIndex === 7 || columnIndex === 6 || columnIndex === 5) {
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
        if (['WebFunction','VirtualWebFunction','WebBrowser','VirtualWebBrowser','SQL','JavaScript','Redis','RPC_Dubbo','CheckEmail'].includes(row.type)) {
          if (columnIndex === 3) {
            return {
              rowspan: 1,
              colspan: 0
            };
          } else if (columnIndex === 4) {
            return {
              rowspan: 1,
              colspan: 2
            };
          } else {
            return {
              rowspan: 1,
              colspan: 1
            };
          }
        }
        if (row.type === 'Manual') {
          if (columnIndex === 3) {
            return {
              rowspan: 1,
              colspan: 2
            };
          } else if (columnIndex === 4) {
            return {
              rowspan: 0,
              colspan: 0
            };
          } else if (columnIndex === 5) {
            return {
              rowspan: 1,
              colspan: 3
            };
          } else if (columnIndex === 6) {
            return {
              rowspan: 1,
              colspan: 0
            };
          } else if (columnIndex === 7) {
            return {
              rowspan: 1,
              colspan: 0
            };
          }
        }
        if (row.type === "StringDataProcessor" || row.type === "MathExpressionProcessor") {
          if (columnIndex === 2) {
            return {
              rowspan: 1,
              colspan: 3
            };
          } else if (columnIndex === 5) {
            return {
              rowspan: 1,
              colspan: 2
            };
          } else if (columnIndex === 0 || columnIndex === 1 || columnIndex === 7) {
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
      },
      setColor(val) {
        if (this.instructionSelectData.length) {
          var data = [];
          data = this.instructionSelectData.map(item => {
            return { id: item.id, color: val };
          });
          this.updateTestCaseInstruction(data).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.null_error_message
          });
        }
      },
      setSort() {
        const el = document.querySelectorAll('.el-table__body-wrapper > table > tbody')[1];
        this.sortable = Sortable.create(el, {
          ghostClass: 'sortable-ghost',
          dataIdAttr: 'orderIndex',
          setData: function(dataTransfer) {
            dataTransfer.setData('Text', '')
          },
          onEnd: evt => {
            const targetRow = this.list.splice(evt.oldIndex, 1)[0];
            const obj = {
              id: targetRow.id,
              // orderIndex: targetRow.orderIndex + (evt.newIndex - evt.oldIndex)
              orderIndex: targetRow.orderIndex + ((evt.newIndex - evt.oldIndex) > 0 ? (evt.newIndex - evt.oldIndex) + 1 : (evt.newIndex - evt.oldIndex))
            };
            this.list.splice(evt.newIndex, 0, targetRow);
            this.updateTestCaseInstruction([obj]).then((res) => {
              this.getMessageDetails();
            }, (err) => {
              console.log(err);
            });
          }
        })
      },
      setRowKey(row) {
        return row.type + row.id;
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
      this.hiddenInstructions = message.hiddenInstructions || [];
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
      this.testCaseId = window.location.pathname.split('/')[6];
      this.getMessageDetails();
      if (this.permissionRule.edit_instructions) {
        this.setSort();
      }
    }
  };
</script>

