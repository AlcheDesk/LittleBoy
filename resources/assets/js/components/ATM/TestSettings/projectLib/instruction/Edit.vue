<template>
  <div>
    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit" :visible.sync="updateFunctionInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="updateCaseInstruction" :rules="paramValidation" ref="updateCaseInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.application" prop="application">
          <el-select v-model="updateCaseInstruction.application" value-key="name" size="small" @change="changeUpdateSelectionApplication" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectApplications"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.section" prop="section">
          <el-select v-model="updateCaseInstruction.section" value-key="name" size="small" @change="changeUpdateSelectionSection" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectSections"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.element" prop="element">
          <el-select v-model="updateCaseInstruction.element" value-key="name" size="small" @change="changeUpdateSelectionElement" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectElements"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.action" prop="action">
          <el-select v-model="updateCaseInstruction.action" value-key="name" size="small" @change="changeUpdateSelectionAction" filterable :placeholder="lang.dialog.placeholder.select">
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
            <el-select v-model="updateCaseInstruction.fileType" size="small" value-key="name" @change="changeUpdateSelectionFileType" filterable :placeholder="lang.dialog.placeholder.select">
              <el-option
                v-for="item in getSelectFileTypes"
                :key="item.label"
                :label="item.label"
                :value="item.value">
                </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="lang.dialog.title.file_path" prop="filePath" key="filePath">
            <el-select v-model="updateCaseInstruction.filePath" size="small" value-key="sha256" filterable :placeholder="lang.dialog.placeholder.select">
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
          <el-form-item :label="lang.table.input" prop="input" key="input">
            <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model="updateCaseInstruction.input"></el-input>
          </el-form-item>
        </template>
        <el-form-item :label="lang.table.option" key="option">
          <el-select v-model="updateCaseInstruction.options" @change="changeUpdateSelectionOption" size="small" value-key="name" clearable filterable :placeholder="lang.dialog.placeholder.select">
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
          v-if="updateInstructionOptions.valueRequired"
          :label="updateInstructionOptions.name"
          :key="updateInstructionOptions.name">
          <el-input v-model='updateInstructionOptions.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="updateCaseInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateCaseInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editFunctionInstruction('updateCaseInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit_comment_instruction" :visible.sync="updateCommentInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="updateCommentInstruction" :rules="paramValidation" ref="updateCommentInstruction" label-width=" 100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="updateCommentInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateCommentInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editCommentInstruction('updateCommentInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit" :visible.sync="updateManualInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="updateManualInstruction" :rules="paramValidation" ref="updateManualInstruction" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.application" prop="application">
          <el-select v-model="updateManualInstruction.application" size="small" value-key="name" @change="changeUpdateSelectionApplication" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectApplications"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.section" prop="section">
          <el-select v-model="updateManualInstruction.section" size="small" value-key="name" @change="changeUpdateSelectionSection" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectSections"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.summary_comment" prop="comment">
          <el-input size="small" @keyup.enter.native="editManualInstruction('updateManualInstruction')" :placeholder="lang.dialog.placeholder.enter_comment" v-model="updateManualInstruction.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.step" prop="stepDescription" >
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model.trim="updateManualInstruction.stepDescription"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.expected" prop="expectedDescription" >
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model.trim="updateManualInstruction.expectedDescription"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateManualInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editManualInstruction('updateManualInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="true" :close-on-click-modal="false" :title="lang.dialog.title.edit_check_email_instruction"  :visible.sync="updateCheckEmailInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="checkEmailInstruction" ref="checkEmailInstruction" label-width="150px" label-position="right" label-suffix=":">
          <el-row>
              <el-col :span="8">
                  <el-form-item :label="lang.dialog.title.check_email_subject_check_type" prop="application">
                      <el-select v-model="checkEmailInstruction.subjectCheckType" size="small" value-key="name" filterable :placeholder="lang.dialog.placeholder.select">
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
                      <el-select v-model="checkEmailInstruction.contentCheckType" size="small" value-key="name" filterable :placeholder="lang.dialog.placeholder.select">
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
          <el-button type="primary" @click="updateCheckEmailInstruction('checkEmailInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit_reference_testcase"  :visible.sync="editReferenceTestCaseDialog" :append-to-body="true" :show-close="false">
      <el-form :model="updateReferenceTestCase" :rules="paramValidationReference" ref="updateReferenceTestCase" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.folder" prop="folder">
          <el-select v-model="updateReferenceTestCase.folder" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectFolder">
            <el-option
              v-for="item in getSelectFolder"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.target_testcase" prop="testCase">
          <el-select v-model="updateReferenceTestCase.testCase" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select" @change="changeSelectFolderTestCase">
            <el-option
              v-for="item in getSelectFolderTestCases"
                :key="item.label"
                :label="item.label"
                :value="item.value.testCase">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.testcase_overwrite" prop="testCaseOverwrite">
          <el-select v-model="updateReferenceTestCase.testCaseOverwrite" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectTestCaseOverwrites"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="updateReferenceTestCase.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateReferenceTestCase')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editReferenceTestCasesInstruction('updateReferenceTestCase')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="this.lang.dialog.title.edit_webbrowser_action"  :visible.sync="updateBrowserInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="browserInstruction" ref="browserInstruction" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.webrowser_action">
          <el-select v-model="browserInstruction.action"  @change="changeBrowserAction" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
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
          v-if="sqlInstructionOption.valueRequired"
          :label="sqlInstructionOption.name"
          :key="sqlInstructionOption.name">
          <el-input v-model='sqlInstructionOption.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="browserInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('browserInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="updateBrowserInstruction('browserInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit_sql_statement"  :visible.sync="updateSqlInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="sqlInstruction" ref="sqlInstruction" label-width="150px" label-position="right" label-suffix=":">
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
        <el-button type="primary" @click="updateSqlInstruction('sqlInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit_js_script"  :visible.sync="updateJsInstructionDialog" :append-to-body="true" :show-close="false">
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
        <el-button type="primary" @click="updateJsInstruction('jsInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.edit_rpc_dubbo_instruction"  :visible.sync="updateRpcDubboInstructionDialog" :show-close="false" :append-to-body="true">
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
        <el-button type="primary" @click="updateRpcDubboInstruction('rpcDubboInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit_validator_instruction"  :visible.sync="updateValidateInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="validateInstruction" ref="validateInstruction" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item>
          <el-switch
            :disabled="true"
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
        <el-button type="primary" @click="updateValidateInInstruction('validateInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>


 <!--    <el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit"  :visible.sync="editRedisInstructionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="redisInstruction" :rules="paramValidationRedisOption" ref="redisInstruction" label-width="100px" label-position="right" label-suffix=":">
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
        <el-form-item label="DB">
          <el-input size="small" type="number" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.db"></el-input>
        </el-form-item>
        <el-form-item label="Key" prop="key">
          <el-input size="small" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.key"></el-input>
        </el-form-item>
        <el-form-item label="Value">
          <el-input size="small" :placeholder="lang.dialog.placeholder.enter" v-model="redisInstruction.value"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.option">
          <el-select v-model="redisInstruction.option" @change="changeRedisInstructionOption" value-key="name" size="small" filterable clearable :placeholder="lang.dialog.placeholder.select">
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
          v-if="redisInstructionOption.valueRequired"
          :label="redisInstructionOption.name"
          :key="redisInstructionOption.name">
          <el-input v-model='redisInstructionOption.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="redisInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('redisInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editRedisInstruction('redisInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog> -->

    <el-dialog class="dialog" :close-on-press-escape="false" :close-on-click-modal="false" :title="lang.dialog.title.edit"  :visible.sync="editRedisInstructionDialog" :show-close="false" :append-to-body="true">
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
        <el-button type="primary" @click="editRedisInstruction('redisInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

	<el-dialog :close-on-press-escape="false" :close-on-click-modal="false" :title="this.lang.dialog.title.edit_stringUtil_action"  :visible.sync="updateStringUtilInstructionDialog" :append-to-body="true" :show-close="false">
      <el-form :model="stringUtilInstruction" ref="stringUtilInstruction" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.stringUtil_instruction">
          <el-select v-model="stringUtilInstruction.action"  @change="changeStringUtilAction" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
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
          v-if="sqlInstructionOption.valueRequired"
          :label="sqlInstructionOption.name"
          :key="sqlInstructionOption.name">
          <el-input v-model='sqlInstructionOption.value' style="width: 75%; float: right;" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="stringUtilInstruction.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('stringUtilInstruction')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="updateStringUtilInstruction('stringUtilInstruction')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'


export default {
  props: {
    lang: {
      default: {}
    },
    permissionRule: {
      default: {}
    },
    updateInstruction: {
      default: {}
    }
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
      instructionType: '',
      updateInstructionOptions: {},
      WebFunctionType: '',
      readOptionTypeElement: '',
      updateFunctionInstructionDialog: false,
      updateCaseInstruction: {
        id: null,
        application: '',
        applicationId: null,
        section: '',
        sectionId: null,
        element: '',
        elementId: null,
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
      updateCommentInstructionDialog: false,
      updateCommentInstruction: {
        id: null,
        comment: ''
      },
      updateManualInstructionDialog: false,
      updateManualInstruction: {
        id: null,
        application: '',
        applicationId: null,
        section: '',
        sectionId: null,
        comment: '',
        stepDescription: '',
        expectedDescription: ''
      },
        updateCheckEmailInstructionDialog: false,
        checkEmailInstruction: {
            subject: '',
            subjectCheckType: '',
            content: '',
            contentCheckType: '',
            sender: '',
            address: '',
            timeSpan: 3600,    //in seconds
            comment: ''
        },
      paramValidationReference: {
        folder: [{required: true, type: 'object', validator: validatorParams }],
        testCase: [{required: true, type: 'object', validator: validatorParams }],
        testCaseOverwrite: [{type: 'object', validator: validatorParams }],
        comment: [{validator: validatorParams }]
      },
      editReferenceTestCaseDialog: false,
      updateReferenceTestCase: {
        id: null,
        folder: '',
        testCase: '',
        testCaseOverwrite: '',
        comment: ''
      },
      updateBrowserInstructionDialog: false,
      browserInstruction: {
        id: null,
        action: '',
        input: '',
        option: '',
        comment: ''
      },
      browserInstructionOption: {},
      updateSqlInstructionDialog: false,
      sqlInstruction: {
        id: null,
        input: '',
        comment: '',
        option: ''
      },
      sqlInstructionOption: {},
      updateJsInstructionDialog: false,
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
      updateRpcDubboInstructionDialog: false,
      rpcDubboInstruction: {
        type: 'dubbo-zookeeper',
        input: '',
        dubboPort: '20880',
        zkHost: '127.0.0.1',
        zkPort: '2181',
        qosPort: '22222',
        dubboServiceInterfaceName: 'like org.apache.dubbo.samples.api.GreetingService',
        dubboServiceInterfaceMethod: 'like sayHello',
        dubboServiceInterfaceParamters: '{}',
        comment: ''
      },
      updateValidateInstructionDialog: false,
      validateInstruction: {
        type: false,
        input: '',
        comment: ''
      },
      validateUpdateInstruction: {
        type: '',
        input: ''
      },
      editRedisInstructionDialog: false,
      redisInstruction: {
        id: null,
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
      updateStringUtilInstructionDialog: false,
      stringUtilInstruction: {
        id: null,
        action: '',
        input: '',
        option: '',
        comment: ''
      },
      browserInstructionOption: {},
      paramValidationRedisOption: {
        key: [{required: true, validator: validatorParams }],
        action: [{required: true, validator: validatorParams }]
      },
      showRedisField: false,
      showRedisValue: false,
      redisType: 'JsonPath',
    }
  },
  computed: {
    ...mapGetters(['getSelectApplications', 'getSelectSections', 'getSelectElements', 'getInstructionActions', 'getSelectInstructionOptionTypes', 'getWebBroswerInstructionActions', 'getSelectTestCaseOverwrites', 'getSelectFolder', 'getSelectFolderTestCases', 'getRedisInstructionActions', 'getSelectFileTypes', 'getSelectFilePath', 'getSelectEngines']),
  },
  watch: {
    updateInstruction: function () {
      if (this.updateInstruction.type) {
        this.showUpdateInstructionDialog();
      }
    },
    getInstructionActions:function(val) {
      if (this.WebFunctionType === 'edit' && this.updateCaseInstruction.action) {
        const obj = {
          elementType: this.updateCaseInstruction.element.type || this.updateCaseInstruction.elementType,
          instructionAction: this.updateCaseInstruction.action.name || this.updateCaseInstruction.action,
        };
        this.readInstructionOptionTypes(obj);
      }
    },
  },
  methods: {
    ...mapActions(['readProjectApplications', 'readApplicationSections', 'readInstructionActions', 'updateTestCaseInstruction', 'readInstructionOptionTypes', 'readWebBrowserInstructionActions', 'readStringUtilInstructionActions', 'readTestCaseOverWrites', 'validateTestCaseRefrence', 'readSectionElements', 'countTestCaseOverwriterInstruction', 'readInstructionOptions', 'readFolders', 'readFolderTestCases', 'readRedisInstructionActions', 'readFileTypes', 'readFilePath', 'readEngines', 'redisPreExecution', 'validateRedisResult']),
    objectIsEmpty(obj) {
      for (var key in obj) {
        return false;
      }
      return true;
    },
    cancel(formname) {
      this.$refs[formname].resetFields();
      switch (formname) {
        case 'updateCaseInstruction':
          this.updateFunctionInstructionDialog = false;
          break;
        case 'updateCommentInstruction':
          this.updateCommentInstructionDialog = false;
          break;
        case 'updateManualInstruction':
          this.updateManualInstructionDialog = false;
          break;
        case 'updateReferenceTestCase':
          this.editReferenceTestCaseDialog = false;
          break;
        case 'browserInstruction':
          this.updateBrowserInstructionDialog = false;
          break;
        case 'sqlInstruction':
          this.updateSqlInstructionDialog = false;
          break;
        case 'jsInstruction':
          this.updateJsInstructionDialog = false;
          break;
        case 'validateInstruction':
          this.updateValidateInstructionDialog = false;
          break;
        case 'redisInstruction':
          this.editRedisInstructionDialog = false;
          break;
        case 'rpcDubboInstruction':
          this.updateRpcDubboInstructionDialog = false;
          break;
        case 'stringUtilInstruction':
          this.updateStringUtilInstructionDialog = false;
          break;
        case 'checkEmailInstruction':
          this.updateCheckEmailInstructionDialog = false;
          break;
      }
      this.$emit('instructionCancelEdit')
    },
    showUpdateInstructionDialog() {
      if (this.permissionRule.edit_instructions) {
        switch(this.updateInstruction.type) {
            case 'WebFunction':
            case 'VirtualWebFunction':
                this.countInstructionOverwrite(this.updateInstruction, this.showUpdateFunctionInstructionDialog);
                break;
            case 'Comment':
                this.showUpdateCommentInstructionDialog(this.updateInstruction);
                break;
            case 'Manual':
                this.showUpdateManualInstructionDialog(this.updateInstruction);
                break;
            case 'Reference':
                this.countInstructionOverwrite(this.updateInstruction, this.showUpdateReferenceTestCaseDialog);
                break;
            case 'REST_API':
                this.countInstructionOverwrite(this.updateInstruction, this.ApiInstructionEdit);
                break;
            case 'WebBrowser':
            case 'VirtualWebBrowser':
                this.showBrowserDialog(this.updateInstruction);
                break;
            case 'SQL':
                this.showSqlDialog(this.updateInstruction);
                break;
            case 'JavaScript':
                this.showJsDialog(this.updateInstruction);
                break;
            case 'MathExpressionProcessor':
            case 'StringDataProcessor':
                this.showValidateInstructionDialog(this.updateInstruction);
                break;
            case 'Redis':
                this.showRedisDialog(this.updateInstruction);
                break;
            case 'StringUtil':
                this.showStringUtilDialog(this.updateInstruction);
                break;
            case 'RPC_Dubbo':
                this.showRpcDubboDialog(this.updateInstruction);
                break;
            case 'CheckEmail':
                this.showCheckEmailDialog(this.updateInstruction);
                break;
        }
      }
    },
    countInstructionOverwrite(row, callback) {
      const param = {
        instructionId: row.id
      }
      this.countTestCaseOverwriterInstruction(param).then((res) => {
        if (res.metadata.count) {
          this.$confirm(this.lang.dialog.title.edit_instructin_overwrite_message_1 + res.metadata.count + this.lang.dialog.title.edit_instructin_overwrite_message_2, this.lang.dialog.title.edit, {
            confirmButtonText: this.lang.operator.confirm,
            cancelButtonText: this.lang.operator.cancel,
            type: 'warning'
          }).then(() => {
            callback(row);
          }).catch((err) => {
            this.$message({
              type:'info',
              message: this.lang.dialog.title.unedit
            });
          });
        } else {
          callback(row);
        }
      })
    },
    showUpdateFunctionInstructionDialog(row) {
      this.readOptionTypeElement = row.element;
      this.WebFunctionType = 'edit';
      if (row.target) {
        this.updateCaseInstruction.id = row.id;
        this.updateCaseInstruction.applicationId = row.applicationId;
        this.updateCaseInstruction.sectionId = row.sectionId;
        this.updateCaseInstruction.elementId = row.elementId;
        this.updateCaseInstruction.elementType = row.elementType;
        this.updateCaseInstruction.action = row.action;
        this.updateCaseInstruction.actionId = row.actionId;
        this.updateCaseInstruction.comment = row.comment;
        this.updateCaseInstruction.application = row.target.split('.')[0];
        this.updateCaseInstruction.section = row.target.split('.')[1];
        this.updateCaseInstruction.element = row.target.split('.')[2];
        this.updateCaseInstruction.type = row.type;
        this.updateCaseInstruction.options = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
        this.updateInstructionOptions = this.updateCaseInstruction.options
        const application = {
          projectId: parseInt(this.projectId)
        };
        application.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readProjectApplications(application);
        const section = {
          applicationId: row.applicationId
        };
        section.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readApplicationSections(section);
        const element = {
          sectionId: row.sectionId
        };
        element.data = {
          pageNumber: 1,
          pageSize: 'all',
          includeDriver: 'true',
          orderBy: 'id desc'
        };
        this.readSectionElements(element);
        const action = {
          elementId: row.elementId
        };
        action.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readInstructionActions(action);
        this.updateFunctionInstructionDialog = true;
        if (row.action == 'FileUpload' || row.action == 'FileUploadByWindow' || row.action == 'FileDownload') {
          this.fileContent = true;
          this.updateCaseInstruction.fileType = row.data.fileType;
          this.updateCaseInstruction.filePath = row.input;
          this.readFileTypes();
          const fileType = {
            type: row.data.fileType
          }
          this.readFilePath(fileType);
        } else {
          this.fileContent = false;
          this.updateCaseInstruction.input = row.input;
        }
      } else {
        this.$notify.error({
          title: this.lang.dialog.title.operation_error,
          message: this.lang.dialog.title.data_error_message
        });
      }
    },
    changeUpdateSelectionApplication(val) {
      if (typeof this.updateCaseInstruction.application !== 'string' || typeof this.updateManualInstruction.application !== 'string') {
        this.updateCaseInstruction.section = '';
        this.updateCaseInstruction.element = '';
        this.updateCaseInstruction.sectionId = null;
        this.updateCaseInstruction.elementId = null;
        this.updateCaseInstruction.action = '';
        this.updateCaseInstruction.input = '';
        this.updateCaseInstruction.fileType = '';
        this.updateCaseInstruction.filePath = '';
        this.updateCaseInstruction.options = '';
        this.updateInstructionOptions = {};
        this.updateManualInstruction.section = '';
        this.updateManualInstruction.sectionId = null;
        this.updateManualInstruction.stepDescription = '';
        this.updateManualInstruction.expectedDescription = '';
        this.updateManualInstruction.comment = '';
        const obj = {
          applicationId: parseInt(val.id)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readApplicationSections(obj);
      }
    },
    changeUpdateSelectionSection(val) {
      if (typeof this.updateCaseInstruction.section !== 'string' || typeof this.updateManualInstruction.section !== 'string') {
        this.updateCaseInstruction.element = '';
        this.updateCaseInstruction.elementId = null;
        this.updateCaseInstruction.action = '';
        this.updateCaseInstruction.input = '';
        this.updateCaseInstruction.fileType = '';
        this.updateCaseInstruction.filePath = '';
        this.updateCaseInstruction.options = '';
        this.updateInstructionOptions = {};
        this.updateManualInstruction.stepDescription = '';
        this.updateManualInstruction.expectedDescription = '';
        this.updateManualInstruction.comment = '';
        const obj = {
          sectionId: parseInt(val.id)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readSectionElements(obj);
      }
      if (typeof this.updateManualInstruction.section !== 'string') {
        this.updateManualInstruction.stepDescription = '';
        this.updateManualInstruction.expectedDescription = '';
        this.updateManualInstruction.comment = '';
      }
    },
    changeUpdateSelectionElement(val) {
      if (typeof this.updateCaseInstruction.element !== 'string') {
        this.updateCaseInstruction.action = '';
        this.updateCaseInstruction.input = '';
        this.updateCaseInstruction.fileType = '';
        this.updateCaseInstruction.filePath = '';
        this.updateCaseInstruction.options = '';
        this.updateInstructionOptions = {};
        const obj = {
          elementId: parseInt(this.updateCaseInstruction.element.id)
        };
        obj.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readInstructionActions(obj);
      }
    },
    changeUpdateSelectionAction(val) {
      if (typeof this.updateCaseInstruction.action !== 'string') {
        this.updateCaseInstruction.input = '';
        this.updateCaseInstruction.options = '';
        this.updateInstructionOptions = {};
      }
      if (val.name == 'FileUpload' || val.name == 'FileUploadByWindow' || val.name == 'FileDownload') {
        this.fileContent = true;
        this.readFileTypes();
        this.updateCaseInstruction.fileType = '';
        this.updateCaseInstruction.filePath = '';
      } else {
        this.fileContent = false;
        this.updateCaseInstruction.input = '';
      }
      const obj = {
        elementType: this.updateCaseInstruction.element.type || this.updateCaseInstruction.elementType,
        instructionAction: val.name,
      };
      this.readInstructionOptionTypes(obj);
    },
    changeUpdateSelectionFileType(val) {
      this.updateCaseInstruction.filePath = '';
      const obj = {
        type: val.name,
      };
      this.readFilePath(obj);
    },
    changeUpdateSelectionOption(val) {
      this.updateInstructionOptions = {};
      for (let i in val) {
        this.$set(this.updateInstructionOptions, i, val[i]);
      }
      if (this.updateInstructionOptions.valueRequired) {
        this.$set(this.updateInstructionOptions, 'value', '');
      }
    },
    editFunctionInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.updateCaseInstruction.id,
            comment: this.updateCaseInstruction.comment,
            action: this.updateCaseInstruction.action.name || this.updateCaseInstruction.action,
            instructionOptions: !this.objectIsEmpty(this.updateInstructionOptions) ? [this.updateInstructionOptions] : []
          };
          if (typeof this.updateCaseInstruction.application != 'string') {
            obj.applicationId = this.updateCaseInstruction.application.id;
          } else {
            obj.applicationId = this.updateCaseInstruction.applicationId;
          }
          if (typeof this.updateCaseInstruction.section != 'string') {
            obj.sectionId = this.updateCaseInstruction.section.id;
          } else {
            obj.sectionId = this.updateCaseInstruction.sectionId;
          }
          if (typeof this.updateCaseInstruction.element != 'string') {
            obj.elementId = this.updateCaseInstruction.element.id;
          } else {
            obj.elementId = this.updateCaseInstruction.elementId;
          }
          if (this.fileContent) {
            obj.input = this.updateCaseInstruction.filePath.path || this.updateCaseInstruction.filePath;
            obj.data = {
              fileType: this.updateCaseInstruction.fileType.name || this.updateCaseInstruction.fileType
            }
          } else {
            if (this.updateCaseInstruction.input) {
              obj.input = this.updateCaseInstruction.input;
            } else {
              obj.input = '';
            }
          }
          this.updateTestCaseInstruction([obj]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.updateFunctionInstructionDialog = false;
        } else {
          return false;
        }
      })
    },

      //校验邮件
    showCheckEmailDialog(row) {
        this.instructionType = 'CheckEmail';
        this.checkEmailInstruction.id = row.id;
        this.checkEmailInstruction.comment = row.comment;
        this.checkEmailInstruction.input = row.input;
        //json properties
        this.checkEmailInstruction.subject = row.data.subject;
        this.checkEmailInstruction.subjectCheckType = row.data.subjectCheckType;
        this.checkEmailInstruction.content = row.data.content;
        this.checkEmailInstruction.contentCheckType = row.data.contentCheckType;
        this.checkEmailInstruction.sender = row.data.sender;
        this.checkEmailInstruction.address = row.data.address;
        this.checkEmailInstruction.timeSpan = parseInt(row.data.timeSpan);

        this.updateCheckEmailInstructionDialog = true;
    },
    updateCheckEmailInstruction(formname){
        const updateInstructions = [{
            id: this.checkEmailInstruction.id,
            input: this.checkEmailInstruction.input,
            comment: this.checkEmailInstruction.comment,
            data: {
                subject: this.checkEmailInstruction.subject,
                subjectCheckType: this.checkEmailInstruction.subjectCheckType,
                content: this.checkEmailInstruction.content,
                contentCheckType: this.checkEmailInstruction.contentCheckType,
                sender: this.checkEmailInstruction.sender,
                address: this.checkEmailInstruction.address,
                timeSpan: this.checkEmailInstruction.timeSpan
            }
        }];

        this.updateTestCaseInstruction(updateInstructions).then((res) => {
            this.$emit('instructionEditDone');
        }, (err) => {
            console.log(err);
        });
        this.updateCheckEmailInstructionDialog = false;
    },

    //rpc dubbo instruction
    showRpcDubboDialog(row) {
      this.instructionType = 'RPC_Dubbo';
      this.rpcDubboInstruction.id = row.id;
      this.rpcDubboInstruction.comment = row.comment;
      this.rpcDubboInstruction.input = row.input;
      //json properties
      this.rpcDubboInstruction.dubboPort = row.data.dubboPort;
      this.rpcDubboInstruction.zkHost = row.data.zkHost;
      this.rpcDubboInstruction.zkPort = row.data.zkPort;
      this.rpcDubboInstruction.qosPort = row.data.qosPort;
      this.rpcDubboInstruction.dubboServiceInterfaceName = row.data.dubboServiceInterfaceName;
      this.rpcDubboInstruction.dubboServiceInterfaceMethod = row.data.dubboServiceInterfaceMethod;
      this.rpcDubboInstruction.dubboServiceInterfaceParamters = JSON.stringify(row.data.dubboServiceInterfaceParamters);

      this.updateRpcDubboInstructionDialog = true;
    },
    updateRpcDubboInstruction(formname) {
      const parameters = JSON.parse(this.rpcDubboInstruction.dubboServiceInterfaceParamters);
      if (parameters instanceof Object) {
          const updateInstructions = [{
              id: this.rpcDubboInstruction.id,
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

          this.updateTestCaseInstruction(updateInstructions).then((res) => {
              this.$emit('instructionEditDone');
          }, (err) => {
              console.log(err);
          });
          this.updateRpcDubboInstructionDialog = false;
      }
    },
    showValidateInstructionDialog(row) {
      this.instructionType = 'Validate';
      this.validateInstruction.id = row.id;
      this.validateInstruction.comment = row.comment;
      this.validateInstruction.input = row.input;
      if (row.type === 'StringDataProcessor') {
        this.validateInstruction.type = false;
      } else {
        this.validateInstruction.type = true;
      }
      this.updateValidateInstructionDialog = true;
    },
    updateValidateInInstruction(formname) {
      const param = {
        id: this.validateInstruction.id,
        input: this.validateInstruction.input,
        comment: this.validateInstruction.comment
      }
      if (this.validateInstruction.type) {
        param.type = 'MathExpressionProcessor';
      } else {
        param.type = 'StringDataProcessor';
      }
      this.updateTestCaseInstruction([param]).then((res) => {
        this.$emit('instructionEditDone');
      }, (err) => {
        console.log(err);
      });
      this.updateValidateInstructionDialog = false;
    },
    ApiInstructionEdit(row) {
      localStorage.setItem('apiInstructionData', JSON.stringify(row));
      localStorage.setItem('apiInstructionType', 'edit');
      var str = window.location.href.split('?')[1];
      var currentPage = parseInt(str.split('&')[0].split('=')[1].split('+')[0]);
      var currentSize = parseInt(str.split('&')[0].split('=')[1].split('+')[1]);
      window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase/' + this.testCaseId + '/ApiTest?page=' + currentPage + '+' + currentSize;
    },
    showUpdateCommentInstructionDialog(row) {
      this.updateCommentInstruction.id = row.id;
      this.updateCommentInstruction.comment = row.comment;
      this.updateCommentInstructionDialog = true;
    },
    editCommentInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.updateCommentInstruction.id,
            comment: this.updateCommentInstruction.comment,
          };
          this.updateTestCaseInstruction([obj]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.updateCommentInstructionDialog = false;
        }
      })
    },
    showUpdateManualInstructionDialog(row) {
      if (row.target) {
        this.updateManualInstruction.id = row.id;
        this.updateManualInstruction.applicationId = row.applicationId;
        this.updateManualInstruction.sectionId = row.sectionId;
        this.updateManualInstruction.comment = row.comment;
        this.updateManualInstruction.application = row.target.split('.')[0];
        this.updateManualInstruction.section = row.target.split('.')[1];
        this.updateManualInstruction.stepDescription = row.stepDescription;
        this.updateManualInstruction.expectedDescription = row.expectedDescription;

        const application = {
          projectId: parseInt(this.projectId)
        };
        application.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readProjectApplications(application);
        const section = {
          applicationId: row.applicationId
        };
        section.data = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readApplicationSections(section);
        this.updateManualInstructionDialog = true;
      } else {
        this.$notify.error({
          title: this.lang.dialog.title.operation_error,
          message: this.lang.dialog.title.data_error_message
        });
      }
    },
    editManualInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.updateManualInstruction.id,
            comment: this.updateManualInstruction.comment,
            stepDescription: this.updateManualInstruction.stepDescription,
            expectedDescription: this.updateManualInstruction.expectedDescription
          };
          if (typeof this.updateManualInstruction.application != 'string') {
            obj.applicationId = this.updateManualInstruction.application.id;
          } else {
            obj.applicationId = this.updateManualInstruction.applicationId;
          }
          if (typeof this.updateManualInstruction.section != 'string') {
            obj.sectionId = this.updateManualInstruction.section.id;
          } else {
            obj.sectionId = this.updateManualInstruction.sectionId;
          }
          this.updateTestCaseInstruction([obj]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.updateManualInstructionDialog = false;
        } else {
          return false;
        }
      })
    },
    showUpdateReferenceTestCaseDialog(row) {
      if (row.target) {
        this.updateReferenceTestCase.id = row.id;
        this.updateReferenceTestCase.folder = row.target.split('.')[1];
        this.updateReferenceTestCase.folderId = row.testCaseShareFolderId;
        this.updateReferenceTestCase.testCase = row.target.split('.')[0];
        this.updateReferenceTestCase.testCaseId = row.refTestCaseId;
        this.updateReferenceTestCase.testCaseOverwrite = row.refTestCaseOverwriteName;
        this.updateReferenceTestCase.testCaseOverwriteId = row.refTestCaseOverwriteId;
        this.updateReferenceTestCase.comment = row.comment;
        const obj = {
          pageNumber: 1,
          pageSize: 'all',
        };
        this.readFolders(obj);
        const param = {
          folderId: row.testCaseShareFolderId,
          data: {
            pageNumber: 1,
            pageSize: 'all',
            refTestCaseId: this.testCaseId
          }
        };
        this.readFolderTestCases(param);
        const obj1 = {
          testCaseId: row.refTestCaseId,
          data: {
            pageNumber: 1,
            pageSize: 'all',
          }
        };
        this.readTestCaseOverWrites(obj1);
        this.editReferenceTestCaseDialog = true;
      } else {
        this.$notify.error({
          title: this.lang.dialog.title.operation_error,
          message: this.lang.dialog.title.data_error_message
        });
      }
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
      this.updateReferenceTestCase.testCase = '';
      this.updateReferenceTestCase.testCaseOverwrite = '';
    },
    changeSelectFolderTestCase(val) {
      const obj = {
        testCaseId: val.id
      };
      this.validateTestCaseRefrence(obj).then((res) => {
        if (res.metadata.count >= 0 && res.metadata.count < 10) {
          const obj = {
            testCaseId: val.id,
            data: {
              pageNumber: 1,
              pageSize: 'all',
            }
          };
          this.readTestCaseOverWrites(obj);
          this.updateReferenceTestCase.testCaseOverwrite = '';
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.error_message
          });
          this.editReferenceTestCaseDialog = false;
          this.updateReferenceTestCase.folder = '';
          this.updateReferenceTestCase.testCase = '';
          this.updateReferenceTestCase.testCaseOverwrite = '';
          this.updateReferenceTestCase.comment = '';
        }
      })
    },
    editReferenceTestCasesInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.updateReferenceTestCase.id,
            comment: this.updateReferenceTestCase.comment
          };
          if (typeof this.updateReferenceTestCase.testCase != 'string') {
            obj.refTestCaseId = this.updateReferenceTestCase.testCase.id;
          } else {
            obj.refTestCaseId = this.updateReferenceTestCase.testCaseId;
          }
          if (typeof this.updateReferenceTestCase.folder != 'string') {
            obj.testCaseShareFolderId = this.updateReferenceTestCase.folder.id;
          } else {
            obj.testCaseShareFolderId = this.updateReferenceTestCase.folderId;
          }
          if (this.updateReferenceTestCase.testCaseOverwrite && typeof this.updateReferenceTestCase.testCaseOverwrite != 'string') {
            obj.refTestCaseOverwriteId = this.updateReferenceTestCase.testCaseOverwrite.id;
          } else {
            obj.refTestCaseOverwriteId = this.updateReferenceTestCase.testCaseOverwriteId;
          }
          this.updateTestCaseInstruction([obj]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.editReferenceTestCaseDialog = false;
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
      this.instructionType = 'WebBrowser';
      this.browserInstruction.id = row.id;
      this.browserInstruction.action = row.action;
      this.browserInstruction.input = row.input;
      this.browserInstruction.option = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.browserInstructionOption = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.browserInstruction.comment = row.comment;
      const param = {
        instructionType: 'WebBrowser',
        elementType: 'WebBrowser',
        instructionAction: row.action
      }
      this.readInstructionOptions(param);
      this.updateBrowserInstructionDialog = true;
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
    updateBrowserInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const param = {
            id: this.browserInstruction.id,
            action: this.browserInstruction.action.name || this.browserInstruction.action,
            input: this.browserInstruction.input,
            comment: this.browserInstruction.comment,
            type: 'WebBrowser',
            isDriver: true,
            instructionOptions: !this.objectIsEmpty(this.browserInstructionOption) ? [this.browserInstructionOption] : []
          };
          this.updateTestCaseInstruction([param]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.updateBrowserInstructionDialog = false;
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
      this.sqlInstruction.id = row.id;
      this.sqlInstruction.input = row.input;
      this.sqlInstruction.comment = row.comment;
      this.sqlInstruction.option = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.sqlInstructionOption = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.updateSqlInstructionDialog = true;
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
    updateSqlInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const param = {
            id: this.sqlInstruction.id,
            input: this.sqlInstruction.input,
            comment: this.sqlInstruction.comment,
            action: 'Execute',
            type: 'SQL',
            instructionOptions: !this.objectIsEmpty(this.sqlInstructionOption) ? [this.sqlInstructionOption] : []
          };
          this.updateTestCaseInstruction([param]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.updateSqlInstructionDialog = false;
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
      this.jsInstruction.id = row.id;
      this.jsInstruction.input = row.input;
      this.jsInstruction.comment = row.comment;
      this.jsInstruction.option = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.jsInstructionOption = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.updateJsInstructionDialog = true;
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
    updateJsInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const param = {
            id: this.jsInstruction.id,
            input: this.jsInstruction.input,
            comment: this.jsInstruction.comment,
            type: 'JavaScript',
            action: 'Execute',
            isDriver: true,
            instructionOptions: !this.objectIsEmpty(this.jsInstructionOption) ? [this.jsInstructionOption] : []
          };
          this.updateTestCaseInstruction([param]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.updateJsInstructionDialog = false;
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
      const obj = {
        orderBy: "id desc",
        pageNumber: 1,
        pageSize: 'all',
        type: 'Redis',
      };
      this.readEngines(obj);
      this.redisInstruction.id = row.id;
      this.redisInstruction.key = row.data.key;
      this.redisInstruction.db = row.data.db;
      this.redisInstruction.driver = '';
      if (row.data.value || row.action == 'Redis_append' || row.action == 'Redis_set') {
        this.redisInstruction.value = row.data.value;
        this.showRedisValue = true;
        this.showRedisField = false;
      } else if (row.data.field || row.action == 'Redis_hget') {
        this.redisInstruction.field = row.data.field;
        this.showRedisValue = false;
        this.showRedisField = true;
      } else {
        this.showRedisValue = false;
        this.showRedisField = false;
      }
      this.redisInstruction.action = row.action;
      this.redisInstruction.comment = row.comment;
      if (row.data.type == 'jsonPath') {
        this.redisType = 'JsonPath';
        this.redisInstruction.jsonPath = row.data.jsonPathPackage.jsonPath;
        this.redisInstruction.jsonExpectedValue = row.data.jsonPathPackage.expectedValue;
        this.redisInstruction.jsonResult = '';
        if (row.instructionOptions[0] && row.instructionOptions[0].value && row.instructionOptions[0].name == 'DTA_SAVE_JSONPATH') {
          this.redisInstruction.jsonOptionFlag = true;
          this.redisInstruction.jsonValue = row.instructionOptions[0].value;
        }
      } else if (row.data.type == 'text') {
        this.redisType = 'Text';
        this.redisInstruction.textExpectedValue = row.data.expectedValue;;
        this.redisInstruction.textResult = '';
        if (row.instructionOptions[0] && row.instructionOptions[0].value && row.instructionOptions[0].name == 'DTA_SAVE_TEXT') {
          this.redisInstruction.textOptionFlag = true;
          this.redisInstruction.textValue = row.instructionOptions[0].value;
        }
      } else {
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
      this.editRedisInstructionDialog = true;
    },
    changeRedisAction(val) {
      if (val.name == 'Redis_append' || val.name == 'Redis_set') {
        this.showRedisValue = true;
        this.showRedisField = false;
      } else if (val.name == 'Redis_hget') {
        this.showRedisField = true;
        this.showRedisValue = false;
      } else {
        this.showRedisValue = false;
        this.showRedisField = false;
      }
    },
    showStringUtilDialog(row) {
      const obj = {
        id: 16
      };
      this.readStringUtilInstructionActions(obj);
      this.instructionType = 'StringUtil';
      this.stringUtilInstruction.id = row.id;
      this.stringUtilInstruction.action = row.action;
      this.stringUtilInstruction.input = row.input;
      this.stringUtilInstruction.option = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.stringUtilInstructionOption = JSON.parse(JSON.stringify(row.instructionOptions[0] || {}));
      this.stringUtilInstruction.comment = row.comment;
      const param = {
        instructionType: 'StringUtil',
        instructionAction: row.action
      }
      this.readInstructionOptions(param);
      this.updateStringUtilInstructionDialog = true;
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
    updateStringUtilInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const param = {
            id: this.stringUtilInstruction.id,
            action: this.stringUtilInstruction.action.name || this.stringUtilInstruction.action,
            input: this.stringUtilInstruction.input,
            comment: this.stringUtilInstruction.comment,
            type: 'StringUtil',
            isDriver: true,
            instructionOptions: !this.objectIsEmpty(this.stringUtilInstructionOption) ? [this.stringUtilInstructionOption] : []
          };
          this.updateTestCaseInstruction([param]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.updateStringUtilInstructionDialog = false;
        } else {
          return false;
        }
      })
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
    editRedisInstruction(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.redisInstruction.id,
            type: 'Redis',
            data: {
              key: this.redisInstruction.key,
              db: parseInt(this.redisInstruction.db),
            },
            action: this.redisInstruction.action.name || this.redisInstruction.action,
            comment: this.redisInstruction.comment,
            isDriver: true
          };
          if (this.showRedisValue) {
            obj.data.value = this.redisInstruction.value;
          }
          if (this.showRedisField) {
            obj.data.field = this.redisInstruction.field;
          }
          if (this.redisType == 'JsonPath') {
            obj.data.type = 'jsonPath';
            obj.data.jsonPathPackage = {
              jsonPath: this.redisInstruction.jsonPath || null,
              expectedValue: this.redisInstruction.jsonExpectedValue || null
            }
            if (this.redisInstruction.jsonOptionFlag) {
              obj.instructionOptions = [{
                name: "DTA_SAVE_JSONPATH",
                value: this.redisInstruction.jsonValue || null,
                valueRequired: true
              }]
            }
          }
          if (this.redisType == 'Text') {
            obj.data.type = 'text';
            obj.data.expectedValue = this.redisInstruction.textExpectedValue;
            if (this.redisInstruction.textOptionFlag) {
              obj.instructionOptions = [{
                name: "DTA_SAVE_TEXT",
                value: this.redisInstruction.textValue,
                valueRequired: true
              }]
            }
          }
          this.updateTestCaseInstruction([obj]).then((res) => {
            this.$emit('instructionEditDone');
          }, (err) => {
            console.log(err);
          });
          this.cancel(formname);
          this.editRedisInstructionDialog = false;
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
            action: this.redisInstruction.action.name || this.redisInstruction.action,
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
