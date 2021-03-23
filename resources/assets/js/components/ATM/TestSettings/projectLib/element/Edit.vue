<template>
  <div>
    <el-dialog  :title="lang.dialog.title.edit" :close-on-click-modal="false" :visible.sync="updateProjectApplicationSectionElementDialog" :show-close="false" :append-to-body="true">
      <el-form :model="updateInputElement" :rules="paramValidation" ref="updateInputElement" label-width=" 150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="updateInputElement.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.element_type" prop="type">
          <el-select v-model="updateInputElement.type" filterable value-key="name" @change="changeUpdateSelectionElementType" :automatic-dropdown="false" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option 
              v-for="item in getElementTypes"
              v-if="item.label != 'REST_API' && item.label != 'SOAP_API'"
              :key="item.label"
              :label="item.label"
              :value="item.value">                
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.position_attribute">
          <el-select v-model="updateInputElement.htmlPositionAttribute" filterable @change="changeUpdateSelectionPositionAttribute" :automatic-dropdown="false" value-key="name" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option 
              v-for="item in getElementLocatorTypes"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.attribute_value">
          <el-input :placeholder="lang.dialog.placeholder.enter" @keyup.enter.native="submitUpdateSectionElementDialog('updateInputElement')" size="small" v-model.trim="updateInputElement.htmlAttributeValue"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateInputElement.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateInputElement')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitUpdateSectionElementDialog('updateInputElement')">{{ lang.operator.confirm }}</el-button>
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
      updateElement: {
        default: {}
      }
    },
    data() {
      var validatorSectionName = (rule, value, callback) => {
        const obj = {
          name: value,
          sectionId: this.sectionId
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (this.updatePreName && value != this.updatePreName) {
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
            return callback();
          }
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
        updateProjectApplicationSectionElementDialog: false,
        updateInputElement: {
          id: '',
          type: '',
          name: '',
          htmlPositionAttribute: '',
          htmlAttributeValue:'',
          comment: ''
        },
        paramValidation: {
          name: [{required: true, validator: validatorSectionName, trigger: 'blur'}],
          type: [{required: true, type: 'object', validator: validatorParams }],
        },
        updatePreName: '',
      };
    },
    computed: {
      ...mapGetters(['getElementLocatorTypes', 'getElementTypes']),
    },
    watch: {
      updateElement: function() {
        if (this.updateElement.id) {
          this.countInstructionOverwriteElement(this.updateElement, this.showUpdateSectionElement);
        }
      },
    },
    methods: {
      ...mapActions(['readElementLocatorTypes', 'readElementTypes', 'updateSectionElement', 'validateSectionElementName', 'readElementTypeUpdate', 'countTestCaseOverwriterElement']),
      cancel(formname) {
        this.updateProjectApplicationSectionElementDialog = false;
        this.$refs[formname].resetFields();
        this.$emit('elementCancelEdit')
      },
      changeUpdateSelectionElementType() {
        if (typeof this.updateInputElement.type !== 'string') {
          const obj = {
            id: this.updateInputElement.type.id
          };
          this.readElementLocatorTypes(obj);
          this.updateInputElement.htmlPositionAttribute = '';
          this.updateInputElement.htmlAttributeValue = '';
        }
      },
      changeUpdateSelectionPositionAttribute() {
        if (typeof this.updateInputElement.htmlPositionAttribute !== 'string') {
          this.updateInputElement.htmlAttributeValue = '';
        }
      },
      countInstructionOverwriteElement(row, callback) {
        const param = {
          elementId: row.id
        };
        this.countTestCaseOverwriterElement(param).then((res) => {
          if (res.metadata.count) {
            this.$confirm(this.lang.dialog.title.edit_element_message_1 + res.metadata.count + this.lang.dialog.title.edit_element_message_2, this.lang.dialog.title.edit, {
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
        }, (err) => {
          console.log(err);
        })
      },
      showUpdateSectionElement(row) {
        var thiz = this;
        this.updatePreName = row.name
        this.updateInputElement.id = row.id
        this.updateInputElement.type = row.type
        this.updateInputElement.name = row.name
        this.updateInputElement.htmlPositionAttribute = row.locatorType
        this.updateInputElement.htmlAttributeValue = row.locatorValue
        this.updateInputElement.comment = row.comment
        this.readElementTypes();
        this.readElementTypeUpdate().then((res) => {
          const obj = {};
          for (let i = 0; i < res.data.length; i++) {
            if (res.data[i].name == thiz.updateInputElement.type) {
              obj.id = res.data[i].id;
            }
          }
          thiz.readElementLocatorTypes(obj);
        })
        this.updateProjectApplicationSectionElementDialog = true;
      },
      submitUpdateSectionElementDialog(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const element = {
              id: this.updateInputElement.id,
              name: this.updateInputElement.name,
              comment: this.updateInputElement.comment,
              locatorValue: this.updateInputElement.htmlAttributeValue
            }
            if (typeof this.updateInputElement.type != 'string') {
              element.type = this.updateInputElement.type.name;
            } else {
              element.type = this.updateInputElement.type;
            }
            if (typeof this.updateInputElement.htmlPositionAttribute != 'string') {
              element.locatorType = this.updateInputElement.htmlPositionAttribute.name;
            } else {
              element.locatorType = this.updateInputElement.htmlPositionAttribute;
            }
            this.updateSectionElement([element]).then((res) => {
              this.$emit('elementEditDone');
            }, (err) => {
              console.log(err);
            });
            this.updateProjectApplicationSectionElementDialog = false;
          } else {
            return false;
          }
        })
      },
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
    }
  };
</script>

<style>
</style>