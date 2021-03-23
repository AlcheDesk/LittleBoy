<template>
  <div class="component_button">
    <el-button class="button_text_table el_button_open" @click="showInsertInstructionBundleDialog">{{ lang.operator.instruction_bundle_insert }}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.insert_bundle"  :visible.sync="insertInstructionBundleDialog" :show-close="false">
      <el-form :model="instructionBundle" :rules="paramValidationBundle" ref="instructionBundle" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.instruction_bundle" prop="bundle">
            <el-select v-model="instructionBundle.bundle" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectInstructionBundle"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="insertInstructionBundleDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitInsertInstructionDialog('instructionBundle')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


    <el-dialog class="dialog" :title="lang.dialog.title.insert_bundle_set" :close-on-click-modal="false" :visible.sync="instructionBundleEntryDialog" :show-close="false">
      <div style="flex: 8; border-right: 1px solid #eee; padding: 5px;">
        <el-table
          :data="getInstructionBundleEntry.data"
          style="width: 100%"
          :row-key="setRowKey"
          row-class-name="row_css">
          <el-table-column
            :label="lang.table.id"
            prop="orderIndex"
            align="left"
            :resizable="true"
            width="80">
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.instruction_type"
            align="left"
            prop="instructionType"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.element_type"
            align="left"
            prop="elementType"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.instruction_action"
            align="left"
            prop="instructionAction"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.comment"
            prop="comment"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.table.operating"
            :resizable="true"
            align="left"
            width="80">
            <template slot-scope="scope">
              <template v-if="!scope.row.flag">
                <el-button class="button_text_table" @click="showChangeInstructionBundleEntryToInstructionDialog(scope.row)">{{ lang.operator.edit }}</el-button>
              </template>
              <template v-else>
                <span style="color: green;">{{ lang.operator.edit_done }}</span>
              </template>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="instructionBundleEntryDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitInstructionBundleEntriesToInstruction">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="addFunctionInstructionDialog" :show-close="false">
      <el-form :model="functionInstruction" :rules="paramValidation" ref="functionInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.application" prop="application">
          <el-select v-model="functionInstruction.application" clearable size="small" value-key="name" @change="changeSelectionApplication" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectApplications"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.section" prop="section">
          <el-select v-model="functionInstruction.section" clearable size="small" value-key="name" @change="changeSelectionSection" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectSections"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.element" prop="element">
          <el-select v-model="functionInstruction.element" clearable size="small" value-key="name" @change="changeSelectionElement" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectElements"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.action" prop="action">
          <el-select v-model="functionInstruction.action" clearable @change="changeSelectionAction" size="small" value-key="name" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getInstructionActions"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.input" prop="input" >
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model="functionInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.option">
          <el-select v-model="functionInstruction.options" clearable @change="changeSelectionOption" value-key="name" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectInstructionOptionTypes"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              <span style="float: left">{{ item.label }}</span>
              <i class="el-icon-edit" style="float: right;" v-if="item.value.valueRequired"></i>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item
          v-if="instructionOptions.valueRequired"
          :label="instructionOptions.name"
          :key="instructionOptions.name">
          <el-input v-model='instructionOptions.value' clearable style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="functionInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addFunctionInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newFunctionInstruction('functionInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="addManualInstructionDialog" :show-close="false">
      <el-form :model="manualInstruction" :rules="paramValidation" ref="manualInstruction" label-width="140px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.application" prop="application">
          <el-select v-model="manualInstruction.application" size="small" value-key="name" @change="changeSelectionApplication" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectApplications"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.section" prop="section">
          <el-select v-model="manualInstruction.section" size="small" value-key="name" @change="changeSelectionSection" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectSections"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.summary_comment" prop="comment">
          <el-input size="small" :placeholder="lang.dialog.placeholder.enter_comment" v-model="manualInstruction.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.step" prop="stepDescription" >
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model.trim="manualInstruction.stepDescription"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.expected" prop="expectedDescription" >
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model.trim="manualInstruction.expectedDescription"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addManualInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newManualInstruction('manualInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_sql_statement"  :visible.sync="addSqlInstructionDialog" :show-close="false">
      <el-form :model="sqlInstruction" ref="sqlInstruction" label-width="140px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.sql_statement">
          <el-input type="textarea" :rows="4" :placeholder="lang.dialog.placeholder.enter" v-model="sqlInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.option">
          <el-select v-model="sqlInstruction.option" @change="changeSqlInstructionOption" value-key="name" size="small" filterable  clearable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectInstructionOptionTypes"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              <span style="float: left">{{ item.label }}</span>
              <i class="el-icon-edit" style="float: right;" v-if="item.value.valueRequired"></i>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item
          v-if="sqlInstructionOption.valueRequired"
          :label="sqlInstructionOption.name"
          :key="sqlInstructionOption.name">
          <el-input v-model="sqlInstructionOption.value" style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="sqlInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addSqlInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addSqlInstruction('sqlInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_js_script"  :visible.sync="addJsInstructionDialog" :show-close="false">
      <el-form :model="jsInstruction" :rules="paramValidationJsOption" ref="jsInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.js_script">
          <el-input type="textarea" :rows="6" :placeholder="lang.dialog.placeholder.enter" v-model="jsInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.option">
          <el-select v-model="jsInstruction.option" @change="changeJsInstructionOption" value-key="name" size="small" filterable clearable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectInstructionOptionTypes"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              <span style="float: left">{{ item.label }}</span>
              <i class="el-icon-edit" style="float: right;" v-if="item.value.valueRequired"></i>
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item
          v-if="jsInstructionOption.valueRequired"
          :label="jsInstructionOption.name"
          :key="jsInstructionOption.name">
          <el-input v-model='jsInstructionOption.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="jsInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addJsInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addJsInstruction('jsInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_comment_instruction" :visible.sync="addCommentInstructionDialog" :show-close="false">
      <el-form :model="commentInstruction" :rules="paramValidation" ref="commentInstruction" label-width=" 100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="commentInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addCommentInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newCommentInstruction('commentInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_webbrowser_action" :visible.sync="addBrowserInstructionDialog" :show-close="false">
      <el-form :model="browserInstruction" ref="browserInstruction" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.webrowser_action">
          <el-select v-model="browserInstruction.action" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getWebBroswerInstructionActions"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.input">
          <el-input :placeholder="lang.dialog.placeholder.entry" size="small" v-model="browserInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="browserInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addBrowserInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addBrowserInstruction('browserInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_stringUtil_instruction" :visible.sync="addStringUtilInstructionDialog" :show-close="false">
      <el-form :model="stringUtilInstruction" ref="stringUtilInstruction" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.stringUtil_instruction">
          <el-select v-model="stringUtilInstruction.action" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getStringUtilInstructionActions"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.input">
          <el-input :placeholder="lang.dialog.placeholder.entry" size="small" v-model="stringUtilInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="stringUtilInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addStringUtilInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addStringUtilInstruction('stringUtilInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.reference_testcase" :visible.sync="referenceTestCaseDialog" :show-close="false">
      <el-form :model="referenceTestCase" :rules="paramValidationReference" ref="referenceTestCase" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.folder" prop="folder">
          <el-select v-model="referenceTestCase.folder" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectFolder">
            <el-option
              v-for="item in getSelectFolder"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.target_testcase" prop="testCase">
          <el-select v-model="referenceTestCase.testCase" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectFolderTestCase">
            <el-option
              v-for="item in getSelectFolderTestCases"
                :key="item.label"
                :label="item.label"
                :value="item.value.testCase">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.testcase_overwrite" prop="testCaseOverwrite">
          <el-select v-model="referenceTestCase.testCaseOverwrite" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectTestCaseOverwrites"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="referenceTestCase.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="referenceTestCaseDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addReferenceTestCasesInstruction('referenceTestCase')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_validator_instruction"  :visible.sync="addValidateInstructionDialog" :show-close="false">
      <el-form :model="validateInstruction" label-width="100px" label-position="right" label-suffix=":">
        <!-- <el-form-item>
          <el-switch
            v-model="validateInstruction.type"
            active-text="数学表达式校验"
            inactive-text="字符串校验">
          </el-switch>
        </el-form-item> -->
        <el-form-item :label="lang.dialog.title.expression">
          <el-input :placeholder="lang.dialog.placeholder.entry" size="small" v-model.trim="validateInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="validateInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addValidateInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addValidateInInstruction">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_stringUtil_instruction" :visible.sync="addStringUtilInstructionDialog" :show-close="false">
      <el-form :model="stringUtilInstruction" ref="stringUtilInstruction" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.stringUtil_instruction">
          <el-select v-model="stringUtilInstruction.action" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getWebBroswerInstructionActions"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.input">
          <el-input :placeholder="lang.dialog.placeholder.entry" size="small" v-model="stringUtilInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="stringUtilInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addStringUtilInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addStringUtilInstruction('stringUtilInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_api_instruction" :visible.sync="addApiInstructionDialog" :show-close="false">
      <el-form :model="addApiInstruction" :rules="paramValidationApi" ref="addApiInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name">
          <el-select v-model="addApiInstruction.name" clearable value-key="name" size="small" filterable placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectProjectApiElements"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="addApiInstructionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addApiElementInInstruction('addApiInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { mapGetters, mapActions, mapMutations } from 'vuex'

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
        projectId: null,
        testCaseId: null,
        instructionBundleEntries: [],
        insertInstructionBundleDialog: false,
        instructionBundle: {
          bundle: '',
        },
        paramValidationBundle: {
          bundle: [{required: true, type: 'object', validator: validatorParams }]
        },
        instructionBundleEntryDialog: false,
        instructions: [],
        instructionBundleEntry: {},
        //webFunc
        addFunctionInstructionDialog: false,
        functionInstruction: {
          application: {},
          section: {},
          element: {},
          action: {},
          options: {},
          input: '',
          comment: ''
        },
        paramValidation: {
          application: [{required: true, type: 'object', validator: validatorParams }],
          section: [{required: true, type: 'object', validator: validatorParams }],
          element: [{required: true, type: 'object', validator: validatorParams }],
          action: [{required: true, type: 'object', validator: validatorParams }],
          options: [{required: true, type: 'object', validator: validatorParams }],
          input: [{ validator: validatorParams }],
          comment: [{ validator: validatorParams }],
          stepDescription: [{ validator: validatorParams }],
          expectedDescription: [{ validator: validatorParams }]
        },
        instructionOptions: {},
        //manual
        addManualInstructionDialog: false,
        manualInstruction: {
          application: {},
          section: {},
          comment: '',
          stepDescription: '',
          expectedDescription: ''
        },
        //SQL
        addSqlInstructionDialog: false,
        sqlInstruction: {
          id: null,
          input: '',
          comment: '',
          option: ''
        },
        sqlInstructionOption: {},
        //JavaScript
        addJsInstructionDialog: false,
        jsInstruction: {
          id: null,
          input: '',
          comment: '',
          option: '',
          dtaSaveText: ''
        },
        paramValidationJsOption: {
          dtaSaveText: [{ validator: validatorParams }]
        },
        jsInstructionOption: {},
        //Comment
        addCommentInstructionDialog: false,
        commentInstruction: {
          comment: ''
        },
        //webBrowser
        addBrowserInstructionDialog: false,
        browserInstruction: {
          id: null,
          action: '',
          input: '',
          comment: ''
        },
        //Reference
        referenceTestCaseDialog: false,
        referenceTestCase: {
          folder: '',
          testCase: '',
          testCaseOverwrite: '',
          comment: ''
        },
        paramValidationReference: {
          folder: [{required: true, type: 'object', validator: validatorParams }],
          testCase: [{required: true, type: 'object', validator: validatorParams }],
          testCaseOverwrite: [{type: 'object', validator: validatorParams }],
          comment: [{validator: validatorParams }]
        },
        //validate
        addValidateInstructionDialog: false,
        validateInstruction: {
          type: false,
          input: '',
          comment: ''
        },
        //stringUtil
        addStringUtilInstructionDialog: false,
        stringUtilInstruction: {
            id: null,
            action: '',
            input: '',
            comment: ''
        },
        //REST_API
        addApiInstructionDialog: false,
        addApiInstruction: {
          name: ''
        },
        paramValidationApi: {
          name:  [{required: true, type: 'object', validator: validatorParams }],
        },
        imVirtualWebFunction: false,
        imVirtualBrowser: false,
      };
    },
    watch: {
      getInstructionBundleEntry: function() {
        this.instructions = JSON.parse(JSON.stringify(this.getInstructionBundleEntry.data));
        this.instructionBundleEntries = JSON.parse(JSON.stringify(this.getInstructionBundleEntry.data));
      }
    },
    computed: {
      ...mapGetters(['getTestCaseInstructions', 'getSelectTestCaseOverwrites', 'getSelectInstructionBundle', 'getInstructionBundleEntry', 'getSelectApplications', 'getSelectSections', 'getSelectElements', 'getInstructionActions', 'getSelectInstructionOptionTypes', 'getWebBroswerInstructionActions', 'getSelectTestCase', 'getSelectProjectApiElements', 'getSelectFolder', 'getSelectFolderTestCases'])
    },
    methods: {
      ...mapMutations(['READ_INSTRUCTION_BUNDLE_ENTRY']),
      ...mapActions(['readTestCaseInstructions', 'readTestCaseOverWrites', 'readInstructionBundle', 'readInstructionBundleEntry', 'readProjectApplications', 'readApplicationSections', 'readSectionElements', 'readInstructionActions', 'readInstructionOptionTypes', 'addTestCaseInstruction', 'readInstructionOptions', 'readWebBrowserInstructionActions', 'validateTestCaseRefrence', 'readRefProjectTestCases', 'readProjectApiElements', 'readFolders', 'readFolderTestCases']),
      objectIsEmpty(obj) {
        for (var key in obj) {
          return false;
        }
        return true;
      },
      showInsertInstructionBundleDialog() {
        this.instructionBundle.bundle = '';
        const obj = {
          pageSize: 'all',
          pageNumber: 1,
          orderBy: 'id desc'
        };
        this.readInstructionBundle(obj);
        this.insertInstructionBundleDialog = true;
      },
      submitInsertInstructionDialog(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.instructionBundle.bundle.id
            };
            obj.data = {
              pageSize: 'all',
              pageNumber: 1,
              orderBy: 'orderIndex asc'
            };
            this.readInstructionBundleEntry(obj);
            this.insertInstructionBundleDialog = false;
            this.instructionBundleEntryDialog = true;
          }
        })
      },
      showChangeInstructionBundleEntryToInstructionDialog(row) {
        this.instructionBundleEntry = row;
        if (row.instructionType == 'WebFunction' || row.instructionType =='VirtualWebFunction') {
          this.imVirtualWebFunction = true;
          this.showAddFunctionInstructionDialog();
        }
        if (row.instructionType == 'Manual') {
          this.showAddManualInstructionDialog();
        }
        if (row.instructionType == 'SQL') {
          this.showSqlDialog();
        }
        if (row.instructionType == 'JavaScript') {
          this.showJsDialog();
        }
        if (row.instructionType == 'Comment') {
          this.showAddCommentDialog();
        }
        if (row.instructionType == 'WebBrowser' || row.instructionType == 'VirutalWebBrowser') {
          this.imVirtualBrowser = true;
          this.showBrowserDialog();
        }
        if (row.instructionType == 'Reference') {
          this.showReferenceInstructionDialog();
        }
        if (row.instructionType == 'MathExpressionProcessor' || row.instructionType == 'StringDataProcessor') {
          this.showValidateInstructionDialog(row);
        }
        if (row.instructionType == 'REST_API') {
          this.showApiInstructionPage(row);
        }
      },
      changeInstructionBundleEntry(obj) {
        this.getInstructionBundleEntry.data.filter((item, index) => {
          if (item.orderIndex == obj.orderIndex) {
            this.instructions.splice(index, 1, obj);
            this.instructionBundleEntries[index].flag = true;
          };
        });
        this.$store.commit('READ_INSTRUCTION_BUNDLE_ENTRY', this.instructionBundleEntries);
      },

      showAddFunctionInstructionDialog() {
        const obj = {
          projectId: parseInt(this.projectId)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readProjectApplications(obj);
        this.functionInstruction.application = '';
        this.functionInstruction.section = '';
        this.functionInstruction.element = '';
        this.functionInstruction.action = '';
        this.functionInstruction.input = '';
        this.functionInstruction.options = '';
        this.functionInstruction.comment = '';
        this.instructionOptions = {};
        this.addFunctionInstructionDialog = true;
      },
      changeSelectionApplication(val) {
        const obj = {
          applicationId: parseInt(val.id)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        if (obj.applicationId) {
          this.readApplicationSections(obj);
          this.functionInstruction.section = '';
          this.functionInstruction.element = '';
          this.functionInstruction.action = '';
          this.functionInstruction.input = '';
          this.functionInstruction.options = '';
        }
      },
      changeSelectionSection(val) {
        const obj = {
          sectionId: parseInt(val.id)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all',
          type: this.instructionBundleEntry.elementType
        };
        if (obj.sectionId) {
          this.functionInstruction.element = '';
          this.functionInstruction.action = '';
          this.functionInstruction.input = '';
          this.functionInstruction.options = '';
          this.readSectionElements(obj);
        }
      },
      changeSelectionElement(val) {
        const obj = {
          elementId: parseInt(this.functionInstruction.element.id)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        if (obj.elementId) {
          this.functionInstruction.action = '';
          this.functionInstruction.input = '';
          this.functionInstruction.options = '';
          this.actionLoading = true;
          this.readInstructionActions(obj);
        }
      },
      changeSelectionAction(val) {
        this.functionInstruction.input = '';
        this.functionInstruction.options = '';
        const obj = {
          id: val.id
        };
        this.readInstructionOptionTypes(obj);
      },
      changeSelectionOption(val) {
        this.instructionOptions = {};
        for (let i in val) {
          this.$set(this.instructionOptions, i, val[i]);
        }
        if (this.instructionOptions.valueRequired) {
          this.$set(this.instructionOptions, 'value', '');
        }
      },
      newFunctionInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            var type = '';
            if (this.imVirtualWebFunction) {
              type = 'VirtualWebFunction';
              this.imVirtualWebFunction = false;
            } else {
              type ='WebFunction';
            }     
            const obj = {
              type: type,
              applicationId: this.functionInstruction.application.id,
              sectionId: this.functionInstruction.section.id,
              elementId: this.functionInstruction.element.id,
              action: this.functionInstruction.action.name,
              comment: this.functionInstruction.comment,
              instructionOptions: !this.objectIsEmpty(this.instructionOptions) ? [this.instructionOptions] : [],
            };
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            if (this.functionInstruction.input) {
              obj.input = this.functionInstruction.input;
            } else {
              obj.input = '';
            }
            this.changeInstructionBundleEntry(obj);
            this.addFunctionInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
      showAddManualInstructionDialog() {
        const obj = {
          projectId: parseInt(this.projectId)
        }
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readProjectApplications(obj);
        this.addManualInstructionDialog = true
        this.manualInstruction.application = '';
        this.manualInstruction.section = '';
        this.manualInstruction.comment = '';
        this.manualInstruction.stepDescription = '';
        this.manualInstruction.expectedDescription = '';
      },
      newManualInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              type: 'Manual',
              applicationId: this.manualInstruction.application.id,
              sectionId: this.manualInstruction.section.id,
              stepDescription: this.manualInstruction.stepDescription,
              expectedDescription: this.manualInstruction.expectedDescription,
              comment: this.manualInstruction.comment
            };
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            this.changeInstructionBundleEntry(obj);
            this.addManualInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
      showSqlDialog() {
        const param = {
          instructionType: 'SQL',
          elementType: 'SQL',
          instructionAction: 'Execute'
        }
        this.readInstructionOptions(param);
        this.addSqlInstructionDialog = true;
        this.sqlInstruction.option = {};
        this.sqlInstructionOption = {};
        this.sqlInstruction.input = '';
        this.sqlInstruction.comment = '';
      },
      changeSqlInstructionOption(val) {
        this.sqlInstructionOption = {};
        for (let i in val) {
          this.$set(this.sqlInstructionOption, i, val[i]);
        }
        if (this.sqlInstructionOption.valueRequired) {
          this.$set(this.sqlInstructionOption, 'value', '');
        }
      },
      addSqlInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              input: this.sqlInstruction.input,
              comment: this.sqlInstruction.comment,
              action: 'Execute',
              type: 'SQL',
              instructionOptions: !this.objectIsEmpty(this.sqlInstructionOption) ? [this.sqlInstructionOption] : []
            };
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            this.changeInstructionBundleEntry(obj);
            this.addSqlInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
      showJsDialog(row) {
        const param = {
          instructionType: 'JavaScript',
          elementType: 'JavaScript',
          instructionAction: 'Execute'
        }
        this.readInstructionOptions(param);
        this.addJsInstructionDialog = true;
        this.jsInstruction.input = '';
        this.jsInstruction.comment = '';
        this.jsInstruction.option = '';
        this.jsInstructionOption = {};
      },
      changeJsInstructionOption(val) {
        this.jsInstructionOption = {};
        for (let i in val) {
          this.$set(this.jsInstructionOption, i, val[i]);
        }
        if (this.jsInstructionOption.valueRequired) {
          this.$set(this.jsInstructionOption, 'value', '');
        }
      },
      addJsInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              input: this.jsInstruction.input,
              comment: this.jsInstruction.comment,
              type: 'JavaScript',
              action: 'Execute',
              isDriver: true,
              instructionOptions: !this.objectIsEmpty(this.jsInstructionOption) ? [this.jsInstructionOption] : []
            };
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            this.changeInstructionBundleEntry(obj);
            this.addJsInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
      showAddCommentDialog() {
        this.commentInstruction.comment = '';
        this.addCommentInstructionDialog = true;
      },
      newCommentInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              type: 'Comment',
              comment: this.commentInstruction.comment
            };
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            this.changeInstructionBundleEntry(obj);
            this.addCommentInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
      showBrowserDialog(row) {
        const obj = {
          id: 9
        };
        this.readWebBrowserInstructionActions(obj);
        this.addBrowserInstructionDialog = true;
        this.browserInstruction.action = '';
        this.browserInstruction.input = '';
        this.browserInstruction.comment = '';
      },
      addBrowserInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            var type = '';
            if (this.imVirtualBrowser) {
              type = 'VirtualWebBrowser';
              this.imVirtualWebFunction = false;
            } else {
              type ='WebBrowser';
            }
            const obj = {
              action: this.browserInstruction.action.name,
              input: this.browserInstruction.input,
              comment: this.browserInstruction.comment,
              type: type,
              isDriver: true
            };
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            this.changeInstructionBundleEntry(obj);
            this.addBrowserInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
      showReferenceInstructionDialog() {
        this.instructionType = 'Reference';
        const obj = {
          id: this.testCaseId
        };
        this.validateTestCaseRefrence(obj).then((res) => {
          if (res.metadata.count >= 0 && res.metadata.count <= 10) {
            const obj = {
              pageNumber: 1,
              pageSize: 'all',
            };
            this.readFolders(obj);
            this.referenceTestCaseDialog = true
            this.referenceTestCase.folder = '';
            this.referenceTestCase.testCase = '';
            this.referenceTestCase.testCaseOverwrite = '';
            this.referenceTestCase.comment = '';
          } else {
            this.$notify.error({
              title: this.lang.dialog.title.operation_error,
              message: this.lang.dialog.title.error_message
            });
          }
        })
      },
      changeSelectFolder(val) {
        const obj = {
          folderId: val.id,
          data: {
            pageNumber: 1,
            pageSize: 'all',
            refTestCaseId: this.testCaseId
          }
        };
        this.readFolderTestCases(obj);
        this.referenceTestCase.testCase = '';
        this.referenceTestCase.testCaseOverwrite = '';
      },
      changeSelectFolderTestCase(val) {
        const obj = {
          testCaseId: val.id,
          data: {
            pageNumber: 1,
            pageSize: 'all',
          }
        };
        this.readTestCaseOverWrites(obj);
        this.referenceTestCase.testCaseOverwrite = '';
      },
      addReferenceTestCasesInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              type: 'Reference',
              testCaseShareFolderId: this.updateReferenceTestCase.folder.id,
              refTestCaseId: this.referenceTestCase.testCase.id,
              comment: this.referenceTestCase.comment
            };
            this.referenceTestCase.testCaseOverwrite.id ? obj.refTestCaseOverwriteId = this.referenceTestCase.testCaseOverwrite.id : null;
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            this.changeInstructionBundleEntry(obj);
            this.referenceTestCaseDialog = false;
          } else {
            return false;
          }
        })
      },
      showValidateInstructionDialog(row) {
        if (row.instructionType == 'StringDataProcessor') {
          this.validateInstruction.type = false;
        } else {
          this.validateInstruction.type = true;
        }
        this.addValidateInstructionDialog = true;
        this.validateInstruction.input = '';
        this.validateInstruction.comment = '';
      },
      addValidateInInstruction() {
        const obj = {
          input: this.validateInstruction.input,
          comment: this.validateInstruction.comment
        };
        if (this.validateInstruction.type) {
          obj.type = 'MathExpressionProcessor';
        } else {
          obj.type = 'StringDataProcessor';
        }
        obj.orderIndex = this.instructionBundleEntry.orderIndex;
        this.changeInstructionBundleEntry(obj);
        this.addValidateInstructionDialog = false;
      },
      showApiInstructionPage(row) {
        const obj = {
          id: this.projectId,
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all',
          method: row.instructionAction,
          type: 'REST_API'
        }
        this.addApiInstruction.name = '';
        this.readProjectApiElements(obj);
        this.addApiInstructionDialog = true;
      },
      addApiElementInInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {};
            obj.type = 'REST_API';
            obj.elementId = this.addApiInstruction.name.id;
            obj.input = this.addApiInstruction.name.parameter.url;
            obj.comment = this.addApiInstruction.name.comment || '';
            obj.action = this.addApiInstruction.name.parameter.method || 'GET';
            obj.data = {};
            obj.data.apiName = this.addApiInstruction.name.name || this.addApiInstruction.name;
            obj.data.method = this.addApiInstruction.name.parameter.method;
            obj.data.responseCode = this.addApiInstruction.name.responseCode || null;
            obj.data.url = this.addApiInstruction.name.parameter.url;
            obj.data.jsonPathPackage = {
              jsonPath: this.addApiInstruction.name.jsonPath || '',
              expectedValue: this.addApiInstruction.name.expectedValue || ''
            };
            obj.instructionOptions = [];
            obj.data.requestHeaders = {};
            obj.data.queryParameters = {};
            obj.orderIndex = this.instructionBundleEntry.orderIndex;
            this.changeInstructionBundleEntry(obj);
            this.addApiInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
      submitInstructionBundleEntriesToInstruction() {
        let flag = true;
        for(let i = 0; i < this.getInstructionBundleEntry.data.length; i++) {
          if (!this.getInstructionBundleEntry.data[i].flag) {
            flag = false;
            break;
          }
        }
        if (flag) {
          const obj = {
            testCaseId: this.testCaseId
          }
          obj.data = this.instructions.map((item) => {
            item.orderIndex = item.orderIndex + this.getTestCaseInstructions.metadata.count;
            return item;
          });
          this.addTestCaseInstruction(obj).then((res) => {
            const param = {};
            param.testCaseId = this.testCaseId;
            param.data = {
              pageNumber: 1,
              pageSize: 25
            };
            this.readTestCaseInstructions(param);
          }, (err) => {
            console.log(err);
          });
          this.instructionBundleEntryDialog = false;
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.edit_error_message,
            position: 'bottom-right'
          });
        }
      },
      setRowKey(row) {
        return Math.random().toString(36).substr(2);
      },
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
      this.testCaseId = window.location.pathname.split('/')[6];
    }
  };
</script>

<style>
</style>
