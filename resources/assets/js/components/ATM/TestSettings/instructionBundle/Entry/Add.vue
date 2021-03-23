<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newInstructionBundleEntryDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="newInstructionBundleEntryDialog" @open="initAddInstructionBundleEntryDialog" :append-to-body="true" :show-close="false">
      <el-form :model="instructionBundleEntry" :rules="paramValidation" ref="instructionBundleEntry" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.instruction_type" prop="instructionType">
          <el-select v-model="instructionBundleEntry.instructionType" value-key="name" size="small" @change="changeSelectionInstructionType" filterable :placeholder="lang.dialog.placeholder.select_instruction_type">
            <el-option
              v-for="item in getSelectInstructionType"
              v-if="item.label !== 'Reference'"
              :key="item.label + item.value.id"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <template v-if="showElementType">
          <el-form-item :label="lang.table.element_type" prop="elementType">
            <el-select v-model="instructionBundleEntry.elementType" @change="changeSelectionElementType" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_element_type">
              <el-option
                v-for="item in getSelectElementTypeForInstructionType"
                :key="item.label + item.value.id"
                :label="item.label"
                :value="item.value">
                </el-option>
            </el-select>
          </el-form-item>
          <el-form-item :label="lang.table.instruction_action" prop="instructionAction">
            <el-select v-model="instructionBundleEntry.instructionAction" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_action">
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
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="instructionBundleEntry.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('instructionBundleEntry')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newInstructionBundleEntry('instructionBundleEntry')">{{ lang.operator.confirm }}</el-button>
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
      orderIndexAdd: {
        default: 0,
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
        bundleId: null,
        instructionBundleEntry: {
          instructionType: '',
          elementType: '',
          instructionAction: '',
          comment: '',
        },
        newInstructionBundleEntryDialog: false,
        paramValidation: {
          instructionType: [{required: true, type: 'object', validator: validatorInstructionBundleEntry }],
          elementType: [{required: true, type: 'object', validator: validatorInstructionBundleEntry }],
          instructionAction: [{required: true, type: 'object', validator: validatorInstructionBundleEntry }],
          comment: [{required: true, validator: validatorInstructionBundleEntry }]
        },
        showElementType: false,
      };
    },
    computed: {
      ...mapGetters(['getSelectInstructionType', 'getSelectElementTypeForInstructionType', 'getWebBroswerInstructionActions'])
    },
    methods: {
      ...mapActions(['addInstructionBundleEntry', 'readInstructionTypes', 'readElementTypesForInstructionType', 'readWebBrowserInstructionActions']),
      cancel(formname) {
        this.newInstructionBundleEntryDialog = false;
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
          this.showElementType = false;
        } else {
          this.showElementType = true;
          this.readElementTypesForInstructionType(obj);
        }
        this.instructionBundleEntry.elementType = '';
        this.instructionBundleEntry.instructionAction = '';
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
        this.instructionBundleEntry.instructionAction = '';
      },
      initAddInstructionBundleEntryDialog() {
        this.instructionBundleEntry.instructionType = '';
        this.instructionBundleEntry.elementType = '';
        this.instructionBundleEntry.instructionAction = '';
        this.instructionBundleEntry.comment = '';
        const obj = {
          pageSize: 'all',
          pageNumber: 1,
        }
        this.readInstructionTypes(obj);
      },
      newInstructionBundleEntry(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.bundleId
            }; 
            obj.data = [{
              instructionType: this.instructionBundleEntry.instructionType.name,
              elementType: this.instructionBundleEntry.elementType.name,
              instructionAction: this.instructionBundleEntry.instructionAction.name,
              comment: this.instructionBundleEntry.comment,
              orderIndex: this.orderIndexAdd + 1,
            }];
            this.addInstructionBundleEntry(obj).then((res) => {
              this.$emit('entryAddDone');
            }, (err) => {
              console.log(err);
            })
            this.newInstructionBundleEntryDialog = false;
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      this.bundleId = window.location.pathname.split('/')[4];
    }
  };
</script>
