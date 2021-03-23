<template>
  <div>
    <el-row class="bar_row">
      <template v-if="permissionRule.add_instructions">
        <el-col :span="24" class="text_left">
          <div class="operator_label">{{ lang.table.type }}：</div>
          <div class="operator_content">
            <el-button class="button_text web_function_button text_white" @click="showAddFunctionInstructionDialog" v-if="hiddenInstructions.indexOf('web_function') == -1">{{ lang.operator.web_function }}</el-button>
            <el-button class="button_text web_function_button text_white" @click="showAddVirtualFunctionInstructionDialog" v-if="hiddenInstructions.indexOf('virtual_web_function') == -1">{{ lang.operator.virtual_web_function }}</el-button>
            <el-button class="button_text manual_button text_white" @click="showAddManualInstructionDialog" v-if="hiddenInstructions.indexOf('manual') == -1">{{ lang.operator.manual }}</el-button>
            <el-button class="button_text text_white reference_button" @click="showReferenceInstructionDialog" v-if="hiddenInstructions.indexOf('reference') == -1">{{ lang.operator.reference }}</el-button>
            <el-button class="button_text rest_api_button text_white" @click="showApiInstructionPage" v-if="hiddenInstructions.indexOf('rest_api') == -1">{{ lang.operator.rest_api }}</el-button>
            <el-button class="button_text rpc_dubbo_button text_white" @click="showRpcDubboInstructionPage" v-if="hiddenInstructions.indexOf('rpc_dubbo') == -1">{{ lang.operator.rpc_dubbo }}</el-button>
            <el-button class="button_text processor_button text_white" @click="showValidateInstructionDialog" v-if="hiddenInstructions.indexOf('processor') == -1">{{ lang.operator.processor }}</el-button>
            <el-button class="button_text email_button text_white" @click="showCheckEmailInstructionDialog" v-if="hiddenInstructions.indexOf('email') == -1">{{ lang.operator.email }}</el-button>
            <el-button class="button_text" @click="showAddCommentDialog" v-if="hiddenInstructions.indexOf('comment') == -1">{{ lang.operator.comment }}</el-button>
            <el-button class="button_text" @click="showBrowserDialog" v-if="hiddenInstructions.indexOf('web_browser') == -1">{{ lang.operator.web_browser }}</el-button>
            <el-button class="button_text" @click="showVirtualBrowserDialog" v-if="hiddenInstructions.indexOf('virtual_web_browser') == -1">{{ lang.operator.virtual_web_browser }}</el-button>
            <el-button class="button_text" @click="showSqlDialog" v-if="hiddenInstructions.indexOf('sql') == -1">{{ lang.operator.sql }}</el-button>
            <el-button class="button_text" @click="showJsDialog" v-if="hiddenInstructions.indexOf('javascript') == -1">{{ lang.operator.javascript }}</el-button>
            <el-button class="button_text" @click="showRedisDialog" v-if="hiddenInstructions.indexOf('redis') == -1">{{ lang.operator.redis }}</el-button>
            <el-button class="button_text" @click="showStringUtilDialog" v-if="hiddenInstructions.indexOf('string_util') == -1">{{ lang.operator.string_util }}</el-button>
          </div>
        </el-col>
      </template>
    </el-row>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.insert_location" :visible.sync="newInstructionInsertDialog" :show-close="false" :append-to-body="true">
      <el-form :model="newInstructionInsertPosition" :rules="positionValidation" ref="newInstructionInsertPosition" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.insert_position" prop="type">
          <el-radio-group v-model="newInstructionInsertPosition.type">
            <el-radio label="行下插入">{{ lang.dialog.title.insert_under }}</el-radio>
            <el-radio label="行上插入">{{ lang.dialog.title.insert_on }}</el-radio>
          </el-radio-group>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('newInstructionInsertPosition')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitPosition('newInstructionInsertPosition')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="addFunctionInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="functionInstruction" :rules="paramValidation" ref="functionInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.application" prop="application">
          <el-select v-model="functionInstruction.application" size="small" value-key="name" @change="changeSelectionApplication" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectApplications"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.section" prop="section">
          <el-select v-model="functionInstruction.section" size="small" value-key="name" @change="changeSelectionSection" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectSections"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.element" prop="element">
          <el-row>
            <el-col :span="19">
              <el-select v-model="functionInstruction.element" size="small" value-key="name" @change="changeSelectionElement" filterable :placeholder="lang.dialog.placeholder.select">
                <el-option
                  v-for="item in getSelectElements"
                  :key="item.label"
                  :label="item.label"
                  :value="item.value">
                  </el-option>
              </el-select>
            </el-col>
            <el-col style="padding-left: 10px;" :span="5">
              <el-button size="small" style="background-color: #3333cc; color: white; text-align: center;" @click="showNewProjectApplicationSectionElementDialog">{{ lang.dialog.title.add_element }}</el-button>
            </el-col>
          </el-row>
        </el-form-item>
        <el-form-item :label="lang.table.action" prop="action">
          <el-select v-model="functionInstruction.action" @change="changeSelectionAction" size="small" value-key="name" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getInstructionActions"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <template v-if="fileContent">
          <el-form-item :label="lang.dialog.title.file_type" prop="fileType" key="fileType">
            <el-select v-model="functionInstruction.fileType" size="small" value-key="name" @change="changeSelectionFileType" filterable :placeholder="lang.dialog.placeholder.select">
              <el-option
                v-for="item in getSelectFileTypes"
                :key="item.label"
                :label="item.label"
                :value="item.value">
                </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="lang.dialog.title.file_path" prop="filePath" key="filePath">
            <el-select v-model="functionInstruction.filePath" size="small" value-key="sha256" filterable :placeholder="lang.dialog.placeholder.select">
              <el-option
                v-for="item in getSelectFilePath"
                :key="item.value.sha256"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
        </template>
        <template v-else>
          <el-form-item :label="lang.table.input" prop="input"  key="input">
            <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model="functionInstruction.input"></el-input>
          </el-form-item>
        </template>
        <el-form-item :label="lang.table.option" key="option">
          <el-select v-model="functionInstruction.options" clearable @change="changeSelectionOption" value-key="name" size="small" clearable :placeholder="lang.dialog.placeholder.select">
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
        <el-button @click="cancel('functionInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newFunctionInstruction('functionInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_element" :visible.sync="newProjectApplicationSectionElementDialog" @open="initNewProjectApplicationSectionElementDialog" :show-close="false" :append-to-body="true">
        <el-form :model="newInputElement" :rules="paramValidationAdd" ref="newInputElement" label-width=" 150px" label-position="right" label-suffix=":">
          <el-form-item :label="lang.table.name" prop="name">
            <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="newInputElement.name"></el-input>
          </el-form-item>
          <el-form-item :label="lang.table.element_type" prop="type">
            <el-select v-model="newInputElement.type" filterable value-key="name" @change="changeSelectionElementType" size="small" :placeholder="lang.dialog.placeholder.select">
              <el-option
                v-for="item in getElementTypes"
                :key="item.label"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
         <template>
          <el-form-item :label="lang.dialog.title.position_attribute">
            <el-select v-model="newInputElement.htmlPositionAttribute" filterable value-key="name" @change="changeSelectionPositionAttribute" size="small" :placeholder="lang.dialog.placeholder.select">
              <el-option
                v-for="item in getElementLocatorTypes"
                :key="item.label"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
            <el-form-item :label="lang.dialog.title.attribute_value" prop="htmlAttributeValue">
              <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="newInputElement.htmlAttributeValue"></el-input>
            </el-form-item>
            <el-form-item :label="lang.table.comment" prop="comment">
              <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="newInputElement.comment"></el-input>
            </el-form-item>
          </template>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="cancel('newInputElement')">{{ lang.operator.cancel }}</el-button>
            <el-button type="primary" @click="submitNewProjectApplicationSectionElementDialog('newInputElement')">{{ lang.operator.confirm }}</el-button>
        </div>
      </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_comment_instruction" :visible.sync="addCommentInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="commentInstruction" :rules="paramValidation" ref="commentInstruction" label-width=" 100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="commentInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('commentInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newCommentInstruction('commentInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="addManualInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="manualInstruction" :rules="paramValidation" ref="manualInstruction" label-width="100px" label-position="right" label-suffix=":">
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
        <el-button @click="cancel('manualInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newManualInstruction('manualInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" class="dialog" :title="lang.dialog.title.reference_testcase" :visible.sync="referenceTestCaseDialog" :show-close="false" :append-to-body="true">
      <el-form :model="referenceTestCase" ref="referenceTestCase" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item
          prop="folder"
          :label="lang.dialog.title.folder"
          :rules="paramValidationReferenceFolder">
            <el-select v-model="referenceTestCase.folder" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectFolder">
              <el-option
                v-for="item in getSelectFolder"
                  :key="item.label"
                  :label="item.label"
                  :value="item.value">
              </el-option>
            </el-select>
        </el-form-item>
        <template v-for="(item, index) in referenceTestCase.testCases">
          <el-row :gutter="10" class="reference_flex">
            <el-col :span="10">
              <el-form-item class="reference_testcase_content" :label="lang.dialog.title.target_testcase" :key="'testCases.' + index + '.testCase.name'" :prop="'testCases.' + index + '.testCase'" :rules="paramValidationReferenceTestCase">
                <el-select v-model="item.testCase" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectFolderTestCase(item)">
                  <el-option
                    v-for="item in getSelectFolderTestCases"
                      :key="item.label"
                      :label="item.label"
                      :value="item.value.testCase">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="10">
              <el-form-item class="reference_testcase_content" :label="lang.dialog.title.testcase_overwrite">
                <el-select v-model="item.testCaseOverwrite" clearable value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
                  <el-option
                    v-for="item in getSelectTestCaseOverwrites"
                      :key="item.label"
                      :label="item.label"
                      :value="item.value">
                  </el-option>
                </el-select>
              </el-form-item>
            </el-col>
            <el-col :span="1" class="reference_testcase_icon" v-if="index">
              <i class="el-icon-error" @click="removeTestCaseAndOverWrite(index)"></i>
            </el-col>
            <el-col :span="1" class="reference_testcase_icon">
              <i class="el-icon-circle-plus-outline" @click="addTestCaseAndOverWrite"
                v-if="referenceTestCase.testCases.length && index === referenceTestCase.testCases.length - 1">
              </i>
            </el-col>
          </el-row>
        </template>
        <el-form-item :label="lang.table.comment" prop="comment" :rules="paramValidationReferenceComment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="referenceTestCase.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('referenceTestCase')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addReferenceTestCasesInstruction('referenceTestCase')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_webbrowser_action"  :visible.sync="addBrowserInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="browserInstruction" ref="browserInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.webrowser_action">
          <el-select v-model="browserInstruction.action" @change="changeBrowserAction" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
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
        <el-form-item :label="lang.table.option">
          <el-select v-model="browserInstruction.option" @change="changeBrowserInstructionOption" value-key="name" size="small" filterable  clearable :placeholder="lang.dialog.placeholder.select">
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
          v-if="browserInstructionOption.valueRequired"
          :label="browserInstructionOption.name"
          :key="browserInstructionOption.name">
          <el-input v-model='browserInstructionOption.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="browserInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('browserInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addBrowserInstruction('browserInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_stringUtil_instruction"  :visible.sync="addStringUtilInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="stringUtilInstruction" ref="stringUtilInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.stringUtil_action">
          <el-select v-model="stringUtilInstruction.action" @change="changeStringUtilAction" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
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
        <el-form-item :label="lang.table.option">
          <el-select v-model="stringUtilInstruction.option" @change="changeStringUtilInstructionOption" value-key="name" size="small" filterable  clearable :placeholder="lang.dialog.placeholder.select">
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
          v-if="stringUtilInstructionOption.valueRequired"
          :label="stringUtilInstructionOption.name"
          :key="stringUtilInstructionOption.name">
          <el-input v-model='stringUtilInstructionOption.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="stringUtilInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('stringUtilInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addStringUtilInstruction('stringUtilInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_sql_statement"  :visible.sync="addSqlInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="sqlInstruction" ref="sqlInstruction" label-width="100px" label-position="right" label-suffix=":">
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
          <el-input v-model='sqlInstructionOption.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="sqlInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('sqlInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addSqlInstruction('sqlInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_js_script"  :visible.sync="addJsInstructionDialog" :show-close="false" :append-to-body="true">
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
        <el-button @click="cancel('jsInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addJsInstruction('jsInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_api_instruction" :visible.sync="addApiInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="addApiInstruction" :rules="paramValidationApi" ref="addApiInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item>
          <el-switch
            v-model="model"
            :active-text="lang.dialog.title.select"
            :inactive-text="lang.operator.new">
          </el-switch>
        </el-form-item>
          <template v-if="model">
            <el-form-item :label="lang.table.name" prop="name">
              <el-select v-model="addApiInstruction.name" clearable value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
                <el-option
                  v-for="item in getSelectProjectApiElements"
                    :key="item.label"
                    :label="item.label"
                    :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </template>
          <template v-else>
            <el-form-item :label="lang.table.name" prop="name">
              <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="addApiInstruction.name"></el-input>
            </el-form-item>
          </template>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('addApiInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addApiElementInInstruction('addApiInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_rpc_dubbo_instruction"  :visible.sync="addRpcDubboInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="rpcDubboInstruction" ref="rpcDubboInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.rpc_dubbo">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.rpc_dubbo_port" v-if="false">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.dubboPort"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.rpc_dubbo_zk_host" v-if="false">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.zkHost"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.rpc_dubbo_zk_port" v-if="false">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.zkPort"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.rpc_dubbo_qos_port" v-if="false">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.qosPort"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.rpc_dubbo_interface_name">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.dubboServiceInterfaceName"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.rpc_dubbo_interface_method">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.dubboServiceInterfaceMethod"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.rpc_dubbo_parameters">
          <el-input type="textarea" :autosize="{ minRows: 2, maxRows: 10}" :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="rpcDubboInstruction.dubboServiceInterfaceParamters"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="rpcDubboInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('rpcDubboInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addRpcDubboInInstruction('rpcDubboInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_check_email_instruction"  :visible.sync="addCheckEmailInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="checkEmailInstruction" ref="checkEmailInstruction" label-width="100px" label-position="right" label-suffix=":">
          <el-row>
              <el-col :span="8">
                  <el-form-item :label="lang.dialog.title.check_email_subject_check_type" prop="application">
                      <el-select v-model="checkEmailInstruction.subjectCheckType" size="small" value-key="name" @change="changeSelectionApplication" filterable :placeholder="lang.dialog.placeholder.select">
                          <el-option
                              v-for="item in [{'label':'等于','value':'Equal'}, {'label':'包含','value':'Contain'}]"
                              :key="item.label"
                              :label="item.label"
                              :value="item.value">
                          </el-option>
                      </el-select>
                  </el-form-item>
              </el-col>
              <el-col :span="14">
                  <el-form-item :label="lang.dialog.title.check_email_subject">
                      <el-input maxLength='32' :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="checkEmailInstruction.subject"></el-input>
                  </el-form-item>
              </el-col>
          </el-row>
          <el-row>
              <el-col :span="8">
                  <el-form-item :label="lang.dialog.title.check_email_content_check_type" prop="application">
                      <el-select v-model="checkEmailInstruction.contentCheckType" size="small" value-key="name" @change="changeSelectionApplication" filterable :placeholder="lang.dialog.placeholder.select">
                          <el-option
                              v-for="item in [{'label':'等于','value':'Equal'}, {'label':'包含','value':'Contain'}]"
                              :key="item.label"
                              :label="item.label"
                              :value="item.value">
                          </el-option>
                      </el-select>
                  </el-form-item>
              </el-col>
              <el-col :span="14">
                  <el-form-item :label="lang.dialog.title.check_email_content">
                      <el-input maxLength='128' :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="checkEmailInstruction.content"></el-input>
                  </el-form-item>
              </el-col>
          </el-row>
          <el-row>
              <el-col :span="14">
                  <el-form-item :label="lang.dialog.title.check_email_sender">
                      <el-input maxLength='32' :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="checkEmailInstruction.sender"></el-input>
                  </el-form-item>
              </el-col>
              <el-col :span="10">
                  <el-form-item :label="lang.dialog.title.check_email_time_span">
                      <el-input type='number' maxLength='4' max='3600' min='0' :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="checkEmailInstruction.timeSpan"></el-input>
                  </el-form-item>
              </el-col>
          </el-row>
          <el-form-item :label="lang.dialog.title.check_email_address">
              <el-input maxLength='64' :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="checkEmailInstruction.address"></el-input>
          </el-form-item>
          <el-form-item :label="lang.table.comment">
              <el-input maxLength='128' type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="checkEmailInstruction.comment"></el-input>
          </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
          <el-button @click="cancel('checkEmailInstruction')">{{ lang.operator.cancel }}</el-button>
          <el-button type="primary" @click="addCheckEmailInInstruction('checkEmailInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add_validator_instruction"  :visible.sync="addValidateInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="validateInstruction" ref="validateInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item>
          <el-switch
            v-model="validateInstruction.type"
            :active-text="lang.table.math_check"
            :inactive-text="lang.table.string_check">
          </el-switch>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.expression">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="validateInstruction.input"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="validateInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('validateInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addValidateInInstruction('validateInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


    <el-dialog class="dialog" :close-on-click-modal="false" :title="lang.dialog.title.add"  :visible.sync="addRedisInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="redisInstruction" :rules="paramValidationRedisOption" ref="redisInstruction" label-width="110px" label-position="right" label-suffix=":">
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item :label="lang.table.action" prop="action">
              <el-select v-model="redisInstruction.action" @change="changeRedisAction" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
                <el-option
                  v-for="item in getRedisInstructionActions"
                    :key="item.label"
                    :label="item.label"
                    :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="DB">
              <el-input size="small" type="number" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.db"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Key" prop="key">
              <el-input size="small" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.key"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item :label="lang.table.comment">
              <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="redisInstruction.comment"></el-input>
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <template v-if="showRedisValue">
            <el-col :span="12">
              <el-form-item label="Value">
                <el-input size="small" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.value"></el-input>
              </el-form-item>
            </el-col>
          </template>
          <template v-else-if="showRedisField">
            <el-col :span="12">
              <el-form-item label="Field">
                <el-input size="small" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.field"></el-input>
              </el-form-item>
            </el-col>
          </template>
        </el-row>
        <el-row :gutter="20" class="redis_driver">
          <el-col :span="12">
            <el-form-item :label="lang.dialog.title.driver">
              <el-select v-model="redisInstruction.driver" clearable value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
                <el-option
                  v-for="item in getSelectEngines"
                    :key="item.label"
                    :label="item.label"
                    :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <template v-if="redisInstruction.driver">
            <el-col :span="8">
              <el-form-item>
                <el-button round size="small" type="primary" @click="preExecutionRedis('redisInstruction')">{{ lang.dialog.title.pre_run }}</el-button>
              </el-form-item>
            </el-col>
          </template>
        </el-row>
        <el-row :gutter="20">
          <div class="redis_result">{{ this.lang.dialog.title.debug_result }}</div>
        </el-row>
        <el-row :gutter="20" class="result_redis">
          <el-input type="textarea" :rows="3" readonly v-model="redisInstruction.result"></el-input>
        </el-row>
        <el-row :gutter="20">
          <div class="redis_processor">{{ lang.operator.processor }}</div>
        </el-row>
        <el-row :gutter="20">
          <el-tabs type="card" :stretch="true" v-model="redisType" @tab-click="tabClickChange">
            <el-tab-pane label="JsonPath" name="JsonPath">
              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="JsonPath">
                    <el-input key="jsonPath" size="small" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.jsonPath"></el-input>
                  </el-form-item>
                </el-col>
                <el-col :span="10">
                  <el-form-item :label="lang.dialog.title.expected">
                    <el-input type="textarea" key="jsonExpectedValue" :rows="3" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.jsonExpectedValue"></el-input>
                  </el-form-item>
                </el-col>
                <template v-if="redisInstruction.jsonPath">
                  <el-col :span="2" style="padding-top: 30px;">
                    <el-button class="el-button button_text el-button--default" @click="validateRedis">{{ lang.operator.processor }}</el-button>
                  </el-col>
                </template>
              </el-row>
              <el-row :gutter="20" class="json_path_expected_block">
                <el-col :span="10">
                  <el-form-item :label="lang.dialog.title.check_result" class="block_item">
                    <el-input type="textarea" key="jsonResult" :rows="3" readonly v-model="redisInstruction.jsonResult"></el-input>
                  </el-form-item>
                </el-col>
                <el-col :span="6">
                    <el-checkbox style="margin-top: 30px;" v-model="redisInstruction.jsonOptionFlag">
                      {{ lang.dialog.title.save_not }}
                    </el-checkbox>
                </el-col>
                <el-col :span="8" class="block_item">
                  <el-input size="small" key="jsonValue" style="margin-top: 30px;" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.jsonValue"></el-input>
                </el-col>
              </el-row>
            </el-tab-pane>
            <el-tab-pane label="Text" name="Text">
              <el-row :gutter="20">
                <el-col :span="10">
                  <el-form-item :label="lang.dialog.title.expected">
                    <el-input type="textarea" key="textExpectedValue" :placeholder="lang.dialog.placeholder.enter" :rows="3" v-model="redisInstruction.textExpectedValue"></el-input>
                  </el-form-item>
                </el-col>
                <template v-if="redisInstruction.textExpectedValue">
                  <el-col :span="2" style="padding-top: 30px;">
                    <el-button class="el-button button_text el-button--default" @click="validateRedis">{{ lang.operator.processor }}</el-button>
                  </el-col>
                </template>
              </el-row>
              <el-row :gutter="20" class="json_path_expected_block">
                <el-col :span="10">
                  <el-form-item :label="lang.dialog.title.check_result" class="block_item">
                    <el-input type="textarea" key="textResult" :rows="3" readonly v-model="redisInstruction.textResult"></el-input>
                  </el-form-item>
                </el-col>
                <el-col :span="6">
                  <el-checkbox style="margin-top: 30px;" v-model="redisInstruction.textOptionFlag">
                    {{ lang.dialog.title.save_result }}
                  </el-checkbox>
                </el-col>
                <el-col :span="8" class="block_item">
                  <el-input size="small" key="textValue" style="margin-top: 30px;" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.textValue"></el-input>
                </el-col>
              </el-row>
            </el-tab-pane>
          </el-tabs>
        </el-row>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('redisInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="addRedisInstruction('redisInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'


export default {
  props: {
    selections: {
      default: []
    },
    lang: {
      default: {}
    },
    hiddenInstructions: {
      default: []
    },
    orderIndex: {
      default: 0
    },
    permissionRule: {
      default: {}
    }
  },
  data() {
    var validatorApiElementName = (rule, value, callback) => {
      if (typeof value !== 'string') {
        return callback();
      }
      const obj = {
        name: value,
        projectId: this.projectId
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        this.validateApiElementName(obj).then((res) => {
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
    var validatorAddSectionName = (rule, value, callback) => {
      const obj = {
        sectionId: this.functionInstruction.section.id,
        name: value
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        this.validateSectionElementName(obj).then((res) => {
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
    var validatorReferenceTestCase = (rule, value, callback, source) => {
      if (rule.required && !value.id) {
        return callback(new Error(this.lang.validator.name.required));
      } else {
        const obj = {
          testCaseId: value.id
        };
        this.validateTestCaseRefrence(obj).then((res) => {
          if (res.metadata.count >= 0 && res.metadata.count < 10) {
            return callback();
          } else {
            return callback(new Error(this.lang.dialog.title.error_message));
          }
        })
      }
    };
    return {
      projectId: null,
      testCaseId: null,
      newProjectApplicationSectionElementDialog: false,
      newInputElement: {
        type: '',
        name: '',
        htmlPositionAttribute: '',
        htmlAttributeValue:'',
        comment: ''
      },
      paramValidationAdd: {
        name: [{required: true, validator: validatorAddSectionName, trigger: 'blur'}],
        type: [{required: true, type: 'object', validator: validatorParams }],
        htmlPositionAttribute: [{required: true, type: 'object', validator: validatorParams }],
        htmlAttributeValue: [{ validator: validatorParams }],
        comment: [{ validator: validatorParams }]
      },
      newInstructionInsertDialog: false,
      newInstructionInsertPosition: {
        type: ''
      },
      positionValidation: {
        type: [{required: true, type: 'object', validator: validatorParams }]
      },
      addFunctionInstructionDialog: false,
      functionInstruction: {
        application: '',
        section: '',
        element: '',
        action: '',
        fileType: '',
        filePath: '',
        options: '',
        input: '',
        comment: ''
      },
      paramValidation: {
        application: [{required: true, type: 'object', validator: validatorParams }],
        section: [{required: true, type: 'object', validator: validatorParams }],
        element: [{required: true, type: 'object', validator: validatorParams }],
        action: [{required: true, type: 'object', validator: validatorParams }],
        fileType: [{required: true, type: 'object', validator: validatorParams }],
        filePath: [{required: true, type: 'object', validator: validatorParams }],
        options: [{required: true, type: 'object', validator: validatorParams }],
        input: [{ validator: validatorParams }],
        comment: [{ validator: validatorParams }],
        stepDescription: [{ validator: validatorParams }],
        expectedDescription: [{ validator: validatorParams }]
      },
      fileContent: false,
      instructionType: '',
      addCommentInstructionDialog: false,
      commentInstruction: {
        comment: ''
      },
      addManualInstructionDialog: false,
      manualInstruction: {
        application: '',
        section: '',
        comment: '',
        stepDescription: '',
        expectedDescription: ''
      },
      instructionOptions: {},
      referenceTestCaseDialog: false,
      referenceTestCase: {
        folder: '',
        testCases: [{
          testCase: '',
          testCaseOverwrite: '',
        }],
        comment: ''
      },
      paramValidationReferenceFolder: {
        required: true, type: 'object', validator: validatorParams, trigger: ['blur', 'change']
      },
      paramValidationReferenceTestCase: {
        required: true, type: 'object', validator: validatorReferenceTestCase, trigger: ['blur', 'change']
      },
      paramValidationReferenceComment: {
        validator: validatorParams, trigger: 'blur'
      },
      addBrowserInstructionDialog: false,
      browserInstructionOption: {},
      browserInstruction: {
        id: null,
        action: '',
        input: '',
        option: '',
        comment: ''
      },
      addSqlInstructionDialog: false,
      sqlInstruction: {
        id: null,
        input: '',
        comment: '',
        option: ''
      },
      sqlInstructionOption: {},
      addJsInstructionDialog: false,
      jsInstruction: {
        id: null,
        input: '',
        comment: '',
        option: '',
        dtaSaveText: ''
      },
      paramValidationJsOption: {
        dtaSaveText: [{required: true, validator: validatorParams }]
      },
      jsInstructionOption: {},
      jsRemoveInstructionOption: {},
      addApiInstructionDialog: false,
      addApiInstruction: {
        name: ''
      },
      paramValidationApi: {
        name: [{required: true, validator: validatorApiElementName, trigger: 'blur'}],
      },
      model: true,
      WebFunctionType: '',
      readOptionTypeElement: '',
      addRpcDubboInstructionDialog: false,
      rpcDubboInstruction: {
        type: 'dubbo-zookeeper',
        input: '',
        dubboPort: '20880',
        zkHost: '127.0.0.1',
        zkPort: '2181',
        qosPort: '22222',
        dubboServiceInterfaceName: 'like org.apache.dubbo.samples.api.GreetingService',
        dubboServiceInterfaceMethod: 'like sayHello',
        dubboServiceInterfaceParamters: 'like [{"java.lang.String":"Hello From AlcheDesk"}]',
        comment: ''
      },
      rpcDubboInstructionProtoType: {
        type: 'dubbo-zookeeper',
        input: '',
        dubboPort: '20880',
        zkHost: '127.0.0.1',
        zkPort: '2181',
        qosPort: '22222',
        dubboServiceInterfaceName: 'like org.apache.dubbo.samples.api.GreetingService',
        dubboServiceInterfaceMethod: 'like sayHello',
        dubboServiceInterfaceParamters: 'like [{"java.lang.String":"Hello From AlcheDesk"}]',
        comment: ''
      },
        addCheckEmailInstructionDialog: false,
        checkEmailInstruction: {
            subject: '',
            subjectCheckType: '',
            content: '',
            contentCheckType: '',
            sender: '',
            address: '',
            timeSpan: '3600',    //in seconds
            comment: ''
        },
      addValidateInstructionDialog: false,
      validateInstruction: {
        type: false,
        input: '',
        comment: ''
      },
      apiOrderIndex: false,
      addRedisInstructionDialog: false,
      redisInstruction: {
        action: '',
        db: '',
        key: '',
        value: '',
        field: '',
        comment: '',
        driver: '',
        result: '',
        jsonPath: '',
        jsonExpectedValue: '',
        jsonResult: '',
        jsonOptionFlag: false,
        jsonValue: '',
        textExpectedValue: '',
        textResult: '',
        textOptionFlag: false,
        textValue: '',
      },
      addStringUtilInstructionDialog: false,
      stringUtilInstructionOption: {},
      stringUtilInstruction: {
        id: null,
        action: '',
        input: '',
        option: '',
        comment: ''
      },
      paramValidationRedisOption: {
        key: [{required: true, validator: validatorParams }],
        action: [{required: true, validator: validatorParams }]
      },
      showRedisField: false,
      showRedisValue: false,
      redisType: 'JsonPath',
      imVirtualFunctionInstruction: false,
      imVirtualBrowser: false,
    }
  },
  computed: {
    ...mapGetters([
    	'getSelectApplications',
    	'getSelectSections',
    	'getSelectElements',
    	'getInstructionActions',
    	'getSelectInstructionOptionTypes',
    	'getSelectProjectApiElements',
    	'getWebBroswerInstructionActions',
    	'getStringUtilInstructionActions',
    	'getTestCaseOverWriteInstructions',
    	'getTestCaseOverwrites',
    	'getSelectTestCaseOverwrites',
    	'getSelectElementLocatorTypes',
    	'getElementLocatorTypes',
    	'getElementTypes',
    	'getSelectFolder',
    	'getSelectFolderTestCases',
    	'getRedisInstructionActions',
    	'getSelectFileTypes',
    	'getSelectFilePath',
    	'getSelectEngines'
    	]),
  },
  watch: {
    getInstructionActions:function(val) {
      this.getInstructionActions.forEach((element) => {
        if (element.label == 'Click') {
          this.functionInstruction.action = element.value;
          return;
        }
        if (element.label == 'Enter') {
          this.functionInstruction.action = element.value;
          return;
        }
        if (element.label == 'Select') {
          this.functionInstruction.action = element.value;
          return;
        }
        if (element.label == 'SwitchToFrame') {
          this.functionInstruction.action = element.value;
          return;
        }
        if (element.label == 'Navigate') {
          this.functionInstruction.action = element.value;
          return;
        }
        if (element.label == 'Execute') {
          this.functionInstruction.action = element.value;
          return;
        }
        if (element.label == 'Check') {
          this.functionInstruction.action = element.value;
          return;
        }
        if (element.label !== 'FileUpload' || element.label !== 'FileUploadByWindow' || element.label !== 'FileDownload') {
          this.fileContent = false;
        }
      });
      if (this.WebFunctionType === 'add' && this.functionInstruction.action.name) {
        const obj = {
          elementType: this.functionInstruction.element.type,
          instructionAction: this.functionInstruction.action.name,
        };
        this.readInstructionOptionTypes(obj);
      }
    },
    model: function() {
      this.addApiInstruction.name = '';
    }
  },
  methods: {
    ...mapActions(['readProjectApplications', 'readApplicationSections', 'readSectionElements', 'readInstructionActions', 'addTestCaseInstruction', 'readInstructionOptionTypes', 'readProjectApiElements', 'validateApiElementName', 'addProjectApiElementInInstruction', 'readWebBrowserInstructionActions', 'readStringUtilInstructionActions', 'readTestCaseOverWrites', 'readElementLocatorTypes', 'validateTestCaseRefrence', 'addSectionElement', 'readElementTypes', 'validateSectionElementName', 'readInstructionOptions', 'readFolders', 'readFolderTestCases', 'readRedisInstructionActions', 'readFileTypes', 'readFilePath', 'readEngines', 'redisPreExecution', 'validateRedisResult']),
    objectIsEmpty(obj) {
      for (var key in obj) {
        return false;
      }
      return true;
    },
    cancel(formname) {
      this.$refs[formname].resetFields();
      switch (formname) {
        case 'newInstructionInsertPosition':
          this.newInstructionInsertDialog = false;
          break;
        case 'functionInstruction':
          this.addFunctionInstructionDialog = false;
          break;
        case 'newInputElement':
          this.newProjectApplicationSectionElementDialog = false;
          break;
        case 'commentInstruction':
          this.addCommentInstructionDialog = false;
          break;
        case 'manualInstruction':
          this.addManualInstructionDialog = false;
          break;
        case 'referenceTestCase':
          this.referenceTestCaseDialog = false;
          break;
        case 'browserInstruction':
          this.addBrowserInstructionDialog = false;
          break;
        case 'sqlInstruction':
          this.addSqlInstructionDialog = false;
          break;
        case 'jsInstruction':
          this.addJsInstructionDialog = false;
          break;
        case 'addApiInstruction':
          this.addApiInstructionDialog = false;
          break;
        case 'validateInstruction':
          this.addValidateInstructionDialog = false;
          break;
        case 'redisInstruction':
          this.addRedisInstructionDialog = false;
          break
        case 'stringUtilInstruction':
          this.addStringUtilInstructionDialog = false;
          break;
        case 'rpcDubboInstruction':
          this.addRpcDubboInstructionDialog = false;
          break;
        case 'checkEmailInstruction':
          this.addCheckEmailInstructionDialog = false;
          break;
      }
    },
    showInstructionDialogType() {
      var len = this.selections.length;
      var maxLength = 1;
      if (len > maxLength) {
        this.$notify.error({
          title: this.lang.dialog.title.operation_error,
          message: this.lang.dialog.title.show_error_message
        });
        return true;
      }
      if (len == maxLength) {
        this.newInstructionInsertPosition.type = '';
        this.newInstructionInsertDialog = true;
        return true;
      }
      return false;
    },
    submitPosition(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          if (this.instructionType == 'WebFunction') {
            const obj = {
              projectId: parseInt(this.projectId)
            }
            obj.data = {
              pageNumber: 1,
              pageSize: 'all'
            };
            this.readProjectApplications(obj);
            this.addFunctionInstructionDialog = true;
            this.WebFunctionType = 'add';
          }
          if (this.instructionType == 'VirtualWebFunction') {
            const obj = {
              projectId: parseInt(this.projectId)
            }
            obj.data = {
              pageNumber: 1,
              pageSize: 'all'
            };
            this.readProjectApplications(obj);
            this.addFunctionInstructionDialog = true;
            this.WebFunctionType = 'add';
          }
          if (this.instructionType == 'Comment') {
            this.addCommentInstructionDialog = true;
          }
          if (this.instructionType == 'Reference') {
            const obj =  {
              pageNumber: 1,
              pageSize: 'all',
              noReference: true
            };
            this.readFolders(obj);
            this.referenceTestCaseDialog = true;
          }
          if (this.instructionType == 'Manual') {
            const obj = {
              projectId: parseInt(this.projectId)
            }
            obj.data = {
              pageNumber: 1,
              pageSize: 'all'
            };
            this.readProjectApplications(obj);
            this.applicationLoading = true;
            this.addManualInstructionDialog = true;
          }
          if (this.instructionType == 'REST_API') {
            this.apiOrderIndex = true;
            if (this.newInstructionInsertPosition.type == '行下插入') {
              localStorage.setItem('apiOrderIndex', this.selections[0].orderIndex + 1);
            }
            if (this.newInstructionInsertPosition.type == '行上插入') {
              localStorage.setItem('apiOrderIndex', this.selections[0].orderIndex);
            }
            this.addApiInstructionDialog = true;
          }
          if (this.instructionType == 'WebBrowser' || this.instructionType == 'VirtualWebBrowser') {
            this.addBrowserInstructionDialog = true;
          }
          if (this.instructionType == 'SQL') {
            this.addSqlInstructionDialog = true;
          }
          if (this.instructionType == 'JavaScript') {
            this.addJsInstructionDialog = true;
          }
          if (this.instructionType === 'Validate') {
            this.addValidateInstructionDialog = true;
          }
          if (this.instructionType === 'Redis') {
            this.addRedisInstructionDialog = true;
          }
          if (this.instructionType === 'StringUtil') {
              this.addStringUtilInstructionDialog = true;
          }
          this.newInstructionInsertDialog = false;
        } else {
          return false;
        }
      })
    },
    showAddFunctionInstructionDialog() {
      this.WebFunctionType = 'add';
      this.instructionType = 'WebFunction';
      console.log(this.lang.operator);
      console.log("hiddenInstructions in Add.vue:" + this.hiddenInstructions);
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.newInstructionInsertPosition.type = '';
        const obj = {
          projectId: parseInt(this.projectId)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readProjectApplications(obj);
        this.applicationLoading = true;
        this.addFunctionInstructionDialog = true;
      }
      this.functionInstruction.element = '';
      this.functionInstruction.action = '';
      this.functionInstruction.input = '';
      this.functionInstruction.options = '';
      this.functionInstruction.comment = '';
      this.instructionOptions = {};
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
        this.sectionLoading = true;
        this.readApplicationSections(obj);
        this.functionInstruction.section = '';
        this.functionInstruction.element = '';
        this.functionInstruction.action = '';
        this.functionInstruction.fileType = '';
        this.functionInstruction.filePath = '';
        this.functionInstruction.input = '';
        this.functionInstruction.options = '';
        this.instructionOptions = {};
      }
    },
    showAddVirtualFunctionInstructionDialog() {
      // 识别是virtualFunctionInstruction而不是functionInstruction
      this.imVirtualFunctionInstruction = true;

      this.WebFunctionType = 'add';
      this.instructionType = 'VirtualWebFunction';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.newInstructionInsertPosition.type = '';
        const obj = {
          projectId: parseInt(this.projectId)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readProjectApplications(obj);
        this.applicationLoading = true;
        this.addFunctionInstructionDialog = true;
      }
      this.functionInstruction.element = '';
      this.functionInstruction.action = '';
      this.functionInstruction.input = '';
      this.functionInstruction.options = '';
      this.functionInstruction.comment = '';
      this.instructionOptions = {};
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
        this.sectionLoading = true;
        this.readApplicationSections(obj);
        this.functionInstruction.section = '';
        this.functionInstruction.element = '';
        this.functionInstruction.action = '';
        this.functionInstruction.fileType = '';
        this.functionInstruction.filePath = '';
        this.functionInstruction.input = '';
        this.functionInstruction.options = '';
        this.instructionOptions = {};
      }
    },
    changeSelectionSection(val) {
      const obj = {
        sectionId: parseInt(val.id)
      };
      obj.data = {
        pageNumber: 1,
        pageSize: 'all',
        orderBy: 'id desc'
      };
      if (obj.sectionId) {
        this.functionInstruction.element = '';
        this.functionInstruction.action = '';
        this.functionInstruction.fileType = '';
        this.functionInstruction.filePath = '';
        this.functionInstruction.input = '';
        this.functionInstruction.options = '';
        this.instructionOptions = {};
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
        this.functionInstruction.fileType = '';
        this.functionInstruction.filePath = '';
        this.functionInstruction.input = '';
        this.functionInstruction.options = '';
        this.instructionOptions = {};
        this.readInstructionActions(obj);
      }
    },
    changeSelectionAction(val) {
      if (val.name == 'FileUpload' || val.name == 'FileUploadByWindow' || val.name == 'FileDownload') {
        this.fileContent = true;
        this.readFileTypes();
        this.functionInstruction.fileType = '';
        this.functionInstruction.filePath = '';
      } else {
        this.fileContent = false;
        this.functionInstruction.input = '';
      }
      this.functionInstruction.options = '';
      this.instructionOptions = {};
      const obj = {
        elementType: this.functionInstruction.element.type,
        instructionAction: val.name,
      };
      this.readInstructionOptionTypes(obj);
    },
    changeSelectionFileType(val) {
      this.functionInstruction.filePath = '';
      const obj = {
        type: val.name,
      };
      this.readFilePath(obj);
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
          const obj = {
            testCaseId: parseInt(this.testCaseId)
          };
          // @author rich chen
          var type = '';
          if (this.imVirtualFunctionInstruction) {
            type = 'VirtualWebFunction';
            // initial value
            this.imVirtualFunctionInstruction = false;
          } else {
            type = 'WebFunction';
          }
          // END

          obj.data = {
            type: type,
            applicationId: this.functionInstruction.application.id,
            sectionId: this.functionInstruction.section.id,
            elementId: this.functionInstruction.element.id,
            action: this.functionInstruction.action.name,
            comment: this.functionInstruction.comment,
            instructionOptions: !this.objectIsEmpty(this.instructionOptions) ? [this.instructionOptions] : []
          };
          if (this.newInstructionInsertPosition.type == '行下插入') {
            obj.data.orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
            obj.data.orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
            obj.data.orderIndex = this.orderIndex + 1;
          }
          if (this.fileContent) {
            obj.data.input = this.functionInstruction.filePath.path;
            obj.data.data = {
              fileType: this.functionInstruction.fileType.name
            }
          } else {
            if (this.functionInstruction.input) {
              obj.data.input = this.functionInstruction.input;
            } else {
              obj.data.input = '';
            }
          }
          const param = {};
          param.testCaseId = obj.testCaseId;
          param.data = [obj.data];
          this.addTestCaseInstruction(param).then((res) => {
              this.$emit('instructionAddDone');
            }, (err) => {
              console.log(err);
            });
          this.cancel(formname);
          this.addFunctionInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    showAddCommentDialog() {
      this.instructionType = 'Comment';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.newInstructionInsertPosition.type = '';
        this.addCommentInstructionDialog = true;
      }
      this.commentInstruction.comment = '';
    },
    newCommentInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            testCaseId: parseInt(this.testCaseId)
          };
          obj.data = {
            type: 'Comment',
            comment: this.commentInstruction.comment
          };
          if (this.newInstructionInsertPosition.type == '行下插入') {
            obj.data.orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
            obj.data.orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
            obj.data.orderIndex = this.orderIndex + 1;
          }
          const param = {};
          param.testCaseId = obj.testCaseId;
          param.data = [obj.data];
          this.addTestCaseInstruction(param).then((res) => {
            this.$emit('instructionAddDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.addCommentInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    showAddManualInstructionDialog() {
      this.instructionType = 'Manual';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.newInstructionInsertPosition.type = '';
        const obj = {
          projectId: parseInt(this.projectId)
        }
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readProjectApplications(obj);
        this.applicationLoading = true;
        this.addManualInstructionDialog = true
      }
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
            testCaseId: parseInt(this.testCaseId)
          };
          obj.data = {
            type: 'Manual',
            applicationId: this.manualInstruction.application.id,
            sectionId: this.manualInstruction.section.id,
            stepDescription: this.manualInstruction.stepDescription,
            expectedDescription: this.manualInstruction.expectedDescription,
            comment: this.manualInstruction.comment
          };
          if (this.newInstructionInsertPosition.type == '行下插入') {
            obj.data.orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
            obj.data.orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
            obj.data.orderIndex = this.orderIndex + 1;
          }
          const param = {};
          param.testCaseId = obj.testCaseId;
          param.data = [obj.data];
          this.addTestCaseInstruction(param).then((res) => {
            this.$emit('instructionAddDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.addManualInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    showReferenceInstructionDialog() {
      this.instructionType = 'Reference';
      const obj = {
        testCaseId: this.testCaseId
      };
      this.validateTestCaseRefrence(obj).then((res) => {
        if (res.metadata.count >= 0 && res.metadata.count <= 10) {
          var Dialog = this.showInstructionDialogType();
          if (!Dialog) {
            this.newInstructionInsertPosition.type = '';
            const obj = {
              pageNumber: 1,
              pageSize: 'all',
            };
            this.readFolders(obj);
            this.referenceTestCaseDialog = true
          }
          this.referenceTestCase.folder = '';
          this.referenceTestCase.testCases = [{
            testCase: '',
            testCaseOverwrite: ''
          }];
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
      this.referenceTestCase.testCases = [{
        testCase: '',
        testCaseOverwrite: ''
      }];
    },
    changeSelectFolderTestCase(val) {
      val.testCaseOverwrite = '';
      const obj = {
        testCaseId: val.testCase.id,
        data: {
          pageNumber: 1,
          pageSize: 'all',
        }
      };
      this.readTestCaseOverWrites(obj);
    },
    addTestCaseAndOverWrite() {
      const testCase = {
        testCase: "",
        testCaseOverwrite: ""
      };
      this.referenceTestCase.testCases.push(testCase);
    },
    removeTestCaseAndOverWrite(index) {
      if (index !== -1) {
        this.referenceTestCase.testCases.splice(index, 1);
      }
    },
    addReferenceTestCasesInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            testCaseId: parseInt(this.testCaseId)
          };
          var orderIndex =  (this.selections[0] && this.selections[0].orderIndex) || this.orderIndex || 0;
          obj.data = this.referenceTestCase.testCases.map((item) => {
            var param = {
              type: 'Reference',
              testCaseShareFolderId: this.referenceTestCase.folder.id,
              refTestCaseId: item.testCase.id,
              refTestCaseOverwriteId: item.testCaseOverwrite.id || null,
              comment: this.referenceTestCase.comment
            };
            if (this.newInstructionInsertPosition.type == '行下插入') {
              param.orderIndex = orderIndex + 1;
              orderIndex++;
            }
            if (this.newInstructionInsertPosition.type == '行上插入') {
              param.orderIndex = orderIndex;
              orderIndex++;
            }
            if (this.newInstructionInsertPosition.type == '') {
              param.orderIndex = orderIndex + 1;
              orderIndex++;
            }
            return param;
          });
          this.addTestCaseInstruction(obj).then((res) => {
            this.$emit('instructionAddDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.referenceTestCaseDialog = false;
        } else {
          return false;
        }
      })
    },
    showRpcDubboInstructionPage(row) {
      this.instructionType = 'RpcDubbo';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
          this.rpcDubboInstruction.input = this.rpcDubboInstructionProtoType.input;
          this.rpcDubboInstruction.dubboServiceInterfaceName = this.rpcDubboInstructionProtoType.dubboServiceInterfaceName;
          this.rpcDubboInstruction.dubboServiceInterfaceMethod = this.rpcDubboInstructionProtoType.dubboServiceInterfaceMethod;
          this.rpcDubboInstruction.dubboServiceInterfaceParamters = this.rpcDubboInstructionProtoType.dubboServiceInterfaceParamters;
          this.rpcDubboInstruction.comment = this.rpcDubboInstructionProtoType.comment;
          this.addRpcDubboInstructionDialog = true;
      }
    },
    addRpcDubboInInstruction(formname) {
      const newInstruction = {
        testCaseId: parseInt(this.testCaseId)
      };
      const parameters = JSON.parse(this.rpcDubboInstruction.dubboServiceInterfaceParamters);
      if (parameters instanceof Object) {
          newInstruction.data = [{
              type: 'RPC_Dubbo',
              action: 'Execute',
              isDriver: false,
              input: this.rpcDubboInstruction.input,
              comment: this.rpcDubboInstruction.comment,
              data: {
                  dubboPort: this.rpcDubboInstruction.dubboPort,
                  zkHost: this.rpcDubboInstruction.zkHost,
                  zkPort: this.rpcDubboInstruction.zkPort,
                  qosPort: this.rpcDubboInstruction.qosPort,
                  dubboServiceInterfaceName: this.rpcDubboInstruction.dubboServiceInterfaceName,
                  dubboServiceInterfaceMethod: this.rpcDubboInstruction.dubboServiceInterfaceMethod,
                  dubboServiceInterfaceParamters: parameters
              }
          }];
          if (this.newInstructionInsertPosition.type == '行下插入') {
              newInstruction.data[0].orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
              newInstruction.data[0].orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
              newInstruction.data[0].orderIndex = this.orderIndex + 1;
          }

          this.addTestCaseInstruction(newInstruction).then((res) => {
              this.$emit('instructionAddDone');
          }, (err) => {
              console.log(err);
          });
          this.cancel(formname);
      }
    },
    showValidateInstructionDialog(row) {
      this.instructionType = 'Validate';
      this.validateInstruction.type = false;
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.addValidateInstructionDialog = true;
      }
      this.validateInstruction.input = '';
      this.validateInstruction.comment = '';
    },
    //check email dialog
    showCheckEmailInstructionDialog(row) {
        this.instructionType = 'CheckEmail';
        if (!this.showInstructionDialogType()) {
            Object.keys(this.checkEmailInstruction).forEach(key => (this.checkEmailInstruction[key] = ''));
            this.checkEmailInstruction.timeSpan = '3600';
            this.addCheckEmailInstructionDialog = true;
        }
    },
    //todo
    addCheckEmailInInstruction(formname) {
      const newInstruction = {
          testCaseId: parseInt(this.testCaseId)
      };
      let theCheckEmailParameter = this.checkEmailInstruction;
      let theComment = theCheckEmailParameter.comment;
      delete theCheckEmailParameter.comment;
      newInstruction.data = [{
          type: 'CheckEmail',
          action: 'Execute',
          isDriver: false,
          input: theCheckEmailParameter.subject,
          comment: theComment,
          data: theCheckEmailParameter
      }];
      console.log(newInstruction);
      if (this.newInstructionInsertPosition.type == '行下插入') {
          newInstruction.data[0].orderIndex = this.selections[0].orderIndex + 1;
      }
      if (this.newInstructionInsertPosition.type == '行上插入') {
          newInstruction.data[0].orderIndex = this.selections[0].orderIndex;
      }
      if (this.newInstructionInsertPosition.type == '') {
          newInstruction.data[0].orderIndex = this.orderIndex + 1;
      }

      this.addTestCaseInstruction(newInstruction).then((res) => {
          this.$emit('instructionAddDone');
      }, (err) => {
          console.log(err);
      });
      this.cancel(formname);
    },
    addValidateInInstruction(formname) {
      const obj = {
        testCaseId: parseInt(this.testCaseId)
      };
      obj.data = {
        input: this.validateInstruction.input,
        comment: this.validateInstruction.comment
      };
      if (this.validateInstruction.type) {
        obj.data.type = 'MathExpressionProcessor';
      } else {
        obj.data.type = 'StringDataProcessor';
      }
      if (this.newInstructionInsertPosition.type == '行下插入') {
        obj.data.orderIndex = this.selections[0].orderIndex + 1;
      }
      if (this.newInstructionInsertPosition.type == '行上插入') {
        obj.data.orderIndex = this.selections[0].orderIndex;
      }
      if (this.newInstructionInsertPosition.type == '') {
        obj.data.orderIndex = this.orderIndex + 1;
      }
      const param = {};
      param.testCaseId = obj.testCaseId;
      param.data = [obj.data];
      this.addTestCaseInstruction(param).then((res) => {
        this.$emit('instructionAddDone');
      }, (err) => {
        console.log(err);
      });
      this.cancel(formname);
      this.addValidateInstructionDialog = false;
    },
    showBrowserDialog(row) {
      const obj = {
        id: 9
      };
      this.readWebBrowserInstructionActions(obj);
      this.instructionType = 'WebBrowser';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.addBrowserInstructionDialog = true;
      }
      this.browserInstruction.action = '';
      this.browserInstruction.input = '';
      this.browserInstruction.option = '';
      this.browserInstruction.comment = '';
    },
    showVirtualBrowserDialog(row) {
      this.imVirtualBrowser = true;
      const obj = {
        id: 9
      };

      this.readWebBrowserInstructionActions(obj);
      this.instructionType = 'VirtualWebBrowser';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.addBrowserInstructionDialog = true;
      }
      this.browserInstruction.action = '';
      this.browserInstruction.input = '';
      this.browserInstruction.option = '';
      this.browserInstruction.comment = '';
    },
    changeBrowserAction(val) {
      const param = {
        instructionType: 'WebBrowser',
        elementType: 'WebBrowser',
        instructionAction: val.name
      }
      this.readInstructionOptions(param);
      this.browserInstruction.option = '';
    },
    changeBrowserInstructionOption(val) {
      this.browserInstructionOption = {};
      for (let i in val) {
        this.$set(this.browserInstructionOption, i, val[i]);
      }
      if (this.browserInstructionOption.valueRequired) {
        this.$set(this.browserInstructionOption, 'value', '');
      }
    },
    addBrowserInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            testCaseId: this.testCaseId
          };
          // @author rich chen
          var type ='';
          if(this.imVirtualBrowser){
            type = 'VirtualWebBrowser';
            this.imVirtualBrowser = false;
          } else {
            type = 'WebBrowser';
          }
          // END
          obj.data = [{
            action: this.browserInstruction.action.name,
            input: this.browserInstruction.input,
            comment: this.browserInstruction.comment,
            type: type,
            isDriver: true,
            instructionOptions: !this.objectIsEmpty(this.browserInstructionOption) ? [this.browserInstructionOption] : []
          }]
          if (this.newInstructionInsertPosition.type == '行下插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
            obj.data[0].orderIndex = this.orderIndex + 1;
          }
          this.addTestCaseInstruction(obj).then((res) => {
            this.$emit('instructionAddDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.addBrowserInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    showStringUtilDialog(row) {
        const obj = {
          id: 16
        };
        this.readStringUtilInstructionActions(obj);
        this.instructionType = 'StringUtil';
        var Dialog = this.showInstructionDialogType();
        if (!Dialog) {
          this.addStringUtilInstructionDialog = true;
        }
        this.stringUtilInstruction.action = '';
        this.stringUtilInstruction.input = '';
        this.stringUtilInstruction.option = '';
        this.stringUtilInstruction.comment = '';
      },
      changeStringUtilAction(val) {
        const param = {
          instructionType: 'StringUtil',
          instructionAction: val.name
        }
        this.readInstructionOptions(param);
        this.stringUtilInstruction.option = '';
      },
      changeStringUtilInstructionOption(val) {
        this.stringUtilInstructionOption = {};
        for (let i in val) {
          this.$set(this.stringUtilInstructionOption, i, val[i]);
        }
        if (this.stringUtilInstructionOption.valueRequired) {
          this.$set(this.stringUtilInstructionOption, 'value', '');
        }
      },
      addStringUtilInstruction(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              testCaseId: this.testCaseId
            };
            obj.data = [{
              action: this.stringUtilInstruction.action.name,
              input: this.stringUtilInstruction.input,
              comment: this.stringUtilInstruction.comment,
              type: 'StringUtil',
              isDriver: false,
              instructionOptions: !this.objectIsEmpty(this.stringUtilInstructionOption) ? [this.stringUtilInstructionOption] : []
            }]
            if (this.newInstructionInsertPosition.type == '行下插入') {
              obj.data[0].orderIndex = this.selections[0].orderIndex + 1;
            }
            if (this.newInstructionInsertPosition.type == '行上插入') {
              obj.data[0].orderIndex = this.selections[0].orderIndex;
            }
            if (this.newInstructionInsertPosition.type == '') {
              obj.data[0].orderIndex = this.orderIndex + 1;
            }
            this.addTestCaseInstruction(obj).then((res) => {
              this.$emit('instructionAddDone');
            }, (err) => {
              console.log(err);
            });
            this.cancel(formname);
            this.addStringUtilInstructionDialog = false;
          } else {
            return false;
          }
        })
      },
    showSqlDialog(row) {
      const param = {
        instructionType: 'SQL',
        elementType: 'SQL',
        instructionAction: 'Execute'
      }
      this.readInstructionOptions(param);
      this.instructionType = 'SQL';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.addSqlInstructionDialog = true;
      }
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
            testCaseId: this.testCaseId
          };
          obj.data = [{
            input: this.sqlInstruction.input,
            comment: this.sqlInstruction.comment,
            action: 'Execute',
            isDriver: true,
            type: 'SQL',
            instructionOptions: !this.objectIsEmpty(this.sqlInstructionOption) ? [this.sqlInstructionOption] : []
          }]

          if (this.newInstructionInsertPosition.type == '行下插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
            obj.data[0].orderIndex = this.orderIndex + 1;
          }
          this.addTestCaseInstruction(obj).then((res) => {
            this.$emit('instructionAddDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
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
      this.instructionType = 'JavaScript';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.addJsInstructionDialog = true;
      }
      this.jsInstruction.input = '';
      this.jsInstruction.comment = '';
      this.jsInstruction.option = '';
      this.jsInstructionOption = {};
      this.jsRemoveInstructionOption = {};
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
            testCaseId: this.testCaseId
          };
          obj.data = [{
            input: this.jsInstruction.input,
            comment: this.jsInstruction.comment,
            type: 'JavaScript',
            action: 'Execute',
            isDriver: true,
            instructionOptions: !this.objectIsEmpty(this.jsInstructionOption) ? [this.jsInstructionOption] : []
          }]
          if (this.newInstructionInsertPosition.type == '行下插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
            obj.data[0].orderIndex = this.orderIndex + 1;
          }
          this.addTestCaseInstruction(obj).then((res) => {
            this.$emit('instructionAddDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.addJsInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    showApiInstructionPage() {
      this.instructionType = 'REST_API';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        const obj = {
          id: this.projectId,
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all',
          type: 'REST_API'
        }
        this.readProjectApiElements(obj);
        this.addApiInstructionDialog = true;
      }
    },
    addApiElementInInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          if (!this.model) {
            const param = {
              id: this.projectId
            };
            const element = {
              name: this.addApiInstruction.name,
              type: 'REST_API',
              driverType: 'API',
              locatorType : 'URL',
              locatorValue : ''
            };
            element.parameter = {};
            element.parameter.url = null;
            element.parameter.method = null;
            element.parameter.requestHeaders = {};
            element.parameter.queryParameters = {};
            param.data = [element];
            this.addProjectApiElementInInstruction(param).then((res) => {
              this.newInstructionInsertPosition.type = '';
              if (!this.apiOrderIndex) {
                localStorage.setItem('apiOrderIndex', this.orderIndex + 1);
              }
              localStorage.setItem('apiInstructionData', JSON.stringify(res.data[0]));
              localStorage.setItem('apiInstructionType', 'add');
              var str = window.location.href.split('?')[1];
              var currentPage = parseInt(str.split('&')[0].split('=')[1].split('+')[0]);
              var currentSize = parseInt(str.split('&')[0].split('=')[1].split('+')[1]);
              window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/ApiTest?page=' + currentPage + '+' + currentSize;
            }, (err) => {
              this.$message({
                type:'error',
                message: this.lang.dialog.title.add_error
              });
            })
          } else {
            const data = this.addApiInstruction.name;
            localStorage.setItem('apiInstructionData', JSON.stringify(data));
            this.newInstructionInsertPosition.type = '';
            if (!this.apiOrderIndex) {
              localStorage.setItem('apiOrderIndex', this.orderIndex + 1);
            }
            localStorage.setItem('apiInstructionType', 'add');
            var str = window.location.href.split('?')[1];
            var currentPage = parseInt(str.split('&')[0].split('=')[1].split('+')[0]);
            var currentSize = parseInt(str.split('&')[0].split('=')[1].split('+')[1]);
            window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/ApiTest?page=' + currentPage + '+' + currentSize;
          }
          this.cancel(formname);
          this.addApiInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    changeSelectionElementType(value) {
      const obj = {
        id: this.newInputElement.type.id
      };
      this.newInputElement.htmlPositionAttribute = '';
      this.newInputElement.htmlAttributeValue = '';
      this.newInputElement.comment = '';
      this.readElementLocatorTypes(obj);
    },
    changeSelectionPositionAttribute() {
      this.newInputElement.htmlAttributeValue = '';
      this.newInputElement.comment = '';
    },
    showNewProjectApplicationSectionElementDialog() {
      if (this.functionInstruction.application !== '' && this.functionInstruction.section !== '' ) {
        this.newProjectApplicationSectionElementDialog = true;
      } else {
        this.newProjectApplicationSectionElementDialog = false;
        this.$notify.error({
          title: this.lang.dialog.title.operation_error,
          message: this.lang.dialog.title.select_error_message
        });
      }
    },
    initNewProjectApplicationSectionElementDialog() {
      this.newInputElement.type = '';
      this.newInputElement.name = '';
      this.newInputElement.htmlPositionAttribute = '';
      this.newInputElement.htmlAttributeValue = '';
      this.newInputElement.comment = '';
      this.readElementTypes();
    },
    submitNewProjectApplicationSectionElementDialog(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            sectionId: this.functionInstruction.section.id,
          };
          var element = {
            projectId: this.projectId,
            applicationId: this.functionInstruction.application.id,
            sectionId: this.functionInstruction.section.id,
            name: this.newInputElement.name,
            type: this.newInputElement.type.name,
            locatorType: this.newInputElement.htmlPositionAttribute.name,
            locatorValue: this.newInputElement.htmlAttributeValue,
            comment: this.newInputElement.comment
          }
          obj.data = [element];
          this.addSectionElement(obj).then((res) => {
            let params = {
              sectionId: this.functionInstruction.section.id
            }
            params.data = {
              pageNumber: 1,
              pageSize: 'all',
              orderBy: 'id desc',
              isDriver: false
            };
            this.readSectionElements(params);
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.newProjectApplicationSectionElementDialog = false;
        } else {
          return false;
        }
      })
    },
    showRedisDialog(row) {
      const param = {
        id: 18
      }
      this.readRedisInstructionActions(param);
      this.instructionType = 'Redis';
      var Dialog = this.showInstructionDialogType();
      if (!Dialog) {
        this.addRedisInstructionDialog = true;
      }
      const obj = {
        orderBy: "id desc",
        pageNumber: 1,
        pageSize: 'all',
        type: 'Redis',
      };
      this.readEngines(obj);
      this.redisInstruction.key = '';
      this.redisInstruction.value = '';
      this.redisInstruction.field = '';
      this.redisInstruction.db = '';
      this.redisInstruction.action = '';
      this.redisInstruction.driver = '';
      this.redisInstruction.comment = '';
      this.redisInstruction.jsonPath = '';
      this.redisInstruction.jsonExpectedValue = '';
      this.redisInstruction.jsonResult = '';
      this.redisInstruction.jsonOptionFlag = false;
      this.redisInstruction.jsonValue = '';
      this.redisInstruction.textExpectedValue = '';
      this.redisInstruction.textResult = '';
      this.redisInstruction.textOptionFlag = false;
      this.redisInstruction.textValue = '';
      this.showRedisValue = false;
      this.showRedisField = false;
    },
    changeRedisAction(val) {
      if (val.name == 'Redis_append' || val.name == 'Redis_set') {
        this.showRedisValue = true;
      } else if (val.name == 'Redis_hget') {
        this.showRedisField = true;
      } else {
        this.showRedisValue = false;
        this.showRedisField = false;
      }
    },
    tabClickChange(val) {
      if (val.label == 'JsonPath') {
        this.redisType = 'JsonPath';
        this.redisInstruction.jsonPath = '';
        this.redisInstruction.jsonExpectedValue = '';
        this.redisInstruction.jsonResult = '';
        this.redisInstruction.jsonOptionFlag = false;
        this.redisInstruction.jsonValue = '';
        this.redisInstruction.textExpectedValue = '';
        this.redisInstruction.textResult = '';
        this.redisInstruction.textOptionFlag = false;
        this.redisInstruction.textValue = '';
      }
      if (val.label == 'Text') {
        this.redisType = 'Text';
        this.redisInstruction.textExpectedValue = '';
        this.redisInstruction.textResult = '';
        this.redisInstruction.textOptionFlag = false;
        this.redisInstruction.textValue = '';
        this.redisInstruction.jsonPath = '';
        this.redisInstruction.jsonExpectedValue = '';
        this.redisInstruction.jsonResult = '';
        this.redisInstruction.jsonOptionFlag = false;
        this.redisInstruction.jsonValue = '';
      }
    },
    addRedisInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            testCaseId: this.testCaseId
          };
          obj.data = [{
            type: 'Redis',
            data: {
              key: this.redisInstruction.key,
              db: parseInt(this.redisInstruction.db)
            },
            action: this.redisInstruction.action.name,
            comment: this.redisInstruction.comment,
            isDriver: true,
          }]
          if (this.newInstructionInsertPosition.type == '行下插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex + 1;
          }
          if (this.newInstructionInsertPosition.type == '行上插入') {
            obj.data[0].orderIndex = this.selections[0].orderIndex;
          }
          if (this.newInstructionInsertPosition.type == '') {
            obj.data[0].orderIndex = this.orderIndex + 1;
          }
          if (this.showRedisValue) {
            obj.data[0].data.value = this.redisInstruction.value;
          }
          if (this.showRedisField) {
            obj.data[0].data.field = this.redisInstruction.field;
          }
          if (this.redisType == 'JsonPath') {
            obj.data[0].data.type = 'jsonPath';
            obj.data[0].data.jsonPathPackage = {
              jsonPath: this.redisInstruction.jsonPath || null,
              expectedValue: this.redisInstruction.jsonExpectedValue || null
            }
            if (this.redisInstruction.jsonOptionFlag) {
              obj.data[0].instructionOptions = [{
                name: "DTA_SAVE_JSONPATH",
                value: this.redisInstruction.jsonValue || null,
                valueRequired: true
              }]
            }
          }
          if (this.redisType == 'Text') {
            obj.data[0].data.type = 'text';
            obj.data[0].data.expectedValue = this.redisInstruction.textExpectedValue;
            if (this.redisInstruction.textOptionFlag) {
              obj.data[0].instructionOptions = [{
                name: "DTA_SAVE_TEXT",
                value: this.redisInstruction.textValue,
                valueRequired: true
              }]
            }
          }
          this.addTestCaseInstruction(obj).then((res) => {
            this.$emit('instructionAddDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.addRedisInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    preExecutionRedis(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            type: 'Redis',
            data: {
              key: this.redisInstruction.key,
              db: parseInt(this.redisInstruction.db)
            },
            action: this.redisInstruction.action.name,
            comment: this.redisInstruction.comment,
            isDriver: true,
            driverId: this.redisInstruction.driver.id
          }
          if (this.showRedisValue) {
            obj.data.value = this.redisInstruction.value;
          }
          if (this.showRedisField) {
            obj.data.field = this.redisInstruction.field;
          }
          this.redisPreExecution(obj).then((res) => {
            if (res.data.redisActionData) {
              this.$set(this.redisInstruction, 'result', res.data.redisActionData);
            } else if (res.data.redisActionMsg) {
              this.$set(this.redisInstruction, 'result', res.data.redisActionMsg);
            } else {
              this.$set(this.redisInstruction, 'result', '');
            }
          })
        } else {
          return false;
        }
      })
    },
    validateRedis() {
      let obj = {
        source: this.redisInstruction.result
      };
      if (this.redisType == 'JsonPath') {
        obj.jsonPath = this.redisInstruction.jsonPath;
        obj.expectedValue = this.redisInstruction.jsonExpectedValue;
        obj.type = 'jsonPath';
      }
      if (this.redisType == 'Text') {
        obj.expectedValue = this.redisInstruction.textExpectedValue;
        obj.type = 'text';
      }
      this.validateRedisResult(obj).then((res) => {
        if (res.data.type == 'jsonPath') {
          this.$set(this.redisInstruction, 'jsonResult', JSON.stringify(res.data.result));
        }
        if (res.data.type == 'text') {
          this.$set(this.redisInstruction, 'textResult', JSON.stringify(res.data.result));
        }
      })
    },
  },
  mounted() {
    this.projectId = window.location.pathname.split('/')[4];
    this.testCaseId = window.location.pathname.split('/')[6];
  }
};
</script>
