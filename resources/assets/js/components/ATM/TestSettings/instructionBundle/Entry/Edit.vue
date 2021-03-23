<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="showUpdateInstructionBundleEntryDialog">{{lang.operator.edit}}</el-button>

    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.edit" :visible.sync="editInstructionBundleEntryDialog" :append-to-body="true" :show-close="false">
      <el-form :model="updateInstructionBundleEntry" :rules="paramValidation" ref="updateInstructionBundleEntry" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.instruction_type" prop="instructionType">
          <el-select v-model="updateInstructionBundleEntry.instructionType" value-key="name" size="small" @change="changeSelectionInstructionType" filterable :placeholder="lang.dialog.placeholder.select_instruction_type">
            <el-option
              v-for="item in getSelectInstructionType"
              v-if="item.label !== 'Reference'"
              :key="item.label + item.value.id"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <template v-if="showUpdateElementType">
          <el-form-item :label="lang.table.element_type" prop="elementType">
            <el-select v-model="updateInstructionBundleEntry.elementType" @change="changeSelectionElementType" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_element_type">
              <el-option
                v-for="item in getSelectElementTypeForInstructionType"
                :key="item.label + item.value.id"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="lang.table.instruction_action" prop="instructionAction">
            <el-select v-model="updateInstructionBundleEntry.instructionAction" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_action">
              <el-option
                v-for="item in getWebBroswerInstructionActions"
                :key="item.label + item.value.id"
                :label="item.label"
                :value="item.value">
              </el-option>
            </el-select>
          </el-form-item>
        </template>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateInstructionBundleEntry.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateInstructionBundleEntry')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="updateInstructionBundleEntryModel('updateInstructionBundleEntry')">{{ lang.operator.confirm }}</el-button>
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
      row: {
        default: {},
      }
    },
    data() {
      var validatorInstructionBundleEntry = (rule, value, callback) => {
        if (!value) {
          if (rule.field == 'instructionType') {
            return callback(new Error(this.lang.dialog.placeholder.select_instruction_type));
          }
          if (rule.field == 'elementType') {
            return callback(new Error(this.lang.dialog.placeholder.select_element_type));
          }
          if (rule.field == 'instructionAction') {
            return callback(new Error(this.lang.dialog.placeholder.select_action));
          }
          if (rule.field == 'comment') {
            return callback(new Error(this.lang.dialog.placeholder.enter_comment));
          }
        } else {
          return callback();
        }
      };
      return {
        editInstructionBundleEntryDialog: false,
        updateInstructionBundleEntry: {
          instructionType: '',
          elementType: '',
          instructionAction: '',
          comment: '',
        },
        paramValidation: {
          instructionType: [{required: true, type: 'object', validator: validatorInstructionBundleEntry }],
          elementType: [{required: true, type: 'object', validator: validatorInstructionBundleEntry }],
          instructionAction: [{required: true, type: 'object', validator: validatorInstructionBundleEntry }],
          comment: [{required: true, validator: validatorInstructionBundleEntry }]
        },
        showUpdateElementType: false,
      };
    },
    computed: {
      ...mapGetters(['getSelectInstructionType', 'getSelectElementTypeForInstructionType', 'getWebBroswerInstructionActions'])
    },
    methods: {
      ...mapActions(['editInstructionBundleEntry', 'readInstructionTypes', 'readElementTypesForInstructionType', 'readWebBrowserInstructionActions']),
      cancel(formname) {
        this.editInstructionBundleEntryDialog = false;
        this.$refs[formname].resetFields();
      },
      changeSelectionInstructionType(val) {
        const obj = {
          id: val.id
        };
        obj.data = {
          pageSize: 'all',
          pageNumber: 1,
        }
        if (val.name == 'Manual' || val.name == 'Reference' || val.name == 'Comment' ||val.name == 'StringDataProcessor' ||val.name == 'MathExpressionProcessor') {
          this.showUpdateElementType = false;
          this.updateInstructionBundleEntry.elementType = null;
        } else {
          this.showUpdateElementType = true;
          this.updateInstructionBundleEntry.elementType = '';
          this.readElementTypesForInstructionType(obj);
        }
        this.updateInstructionBundleEntry.instructionAction = '';
      },
      changeSelectionElementType(val) {
        const obj = {
          id: val.id
        };
        obj.data = {
          pageSize: 'all',
          pageNumber: 1,
        }
        this.readWebBrowserInstructionActions(obj);
        this.updateInstructionBundleEntry.instructionAction = '';
      },
      showUpdateInstructionBundleEntryDialog() {
        this.updateInstructionBundleEntry.instructionType = this.row.instructionType;
        this.updateInstructionBundleEntry.elementType = this.row.elementType;
        this.updateInstructionBundleEntry.instructionAction = this.row.instructionAction;
        this.updateInstructionBundleEntry.comment = this.row.comment;
        this.updateInstructionBundleEntry.id = this.row.id;
        const obj = {
          pageSize: 'all',
          pageNumber: 1,
        }
        this.readInstructionTypes(obj);
        this.editInstructionBundleEntryDialog = true;
        if (this.row.instructionType == 'Manual' || this.row.instructionType == 'Reference' || this.row.instructionType == 'Comment' || this.row.instructionType == 'StringDataProcessor' || this.row.instructionType == 'MathExpressionProcessor') {
          this.showUpdateElementType = false;
        } else {
          this.showUpdateElementType = true;
        }
      },
      updateInstructionBundleEntryModel(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = [{
              id: this.updateInstructionBundleEntry.id,
              instructionType: this.updateInstructionBundleEntry.instructionType.name || this.updateInstructionBundleEntry.instructionType,
              comment: this.updateInstructionBundleEntry.comment
            }];
            if (this.showUpdateElementType) {
              obj[0].elementType = this.updateInstructionBundleEntry.elementType.name || this.updateInstructionBundleEntry.elementType;
              obj[0]. instructionAction = this.updateInstructionBundleEntry.instructionAction.name || this.updateInstructionBundleEntry.instructionAction;
            }
            this.editInstructionBundleEntry(obj).then((res) => {
              this.$emit('entryEditDone');
            }, (err) => {
              console.log(err);
            });
            this.editInstructionBundleEntryDialog = false;
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
