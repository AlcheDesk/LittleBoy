<template>
  <div class="component_button">
    <el-button class="button_text" @click="newProjectApplicationSectionElementDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false" :visible.sync="newProjectApplicationSectionElementDialog" @open="initNewProjectApplicationSectionElementDialog" :show-close="false" :append-to-body="true">
      <el-form :model="newInputElement" :rules="paramValidationAdd" ref="newInputElement" label-width=" 150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input :placeholder="lang.dialog.placeholder.enter_name" size="small" v-model.trim="newInputElement.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.element_type" prop="type">
          <el-select v-model="newInputElement.type" filterable value-key="name" @change="changeSelectionElementType" size="small" :automatic-dropdown="false" :placeholder="lang.dialog.placeholder.select">
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
          <el-select v-model="newInputElement.htmlPositionAttribute" value-key="name" @change="changeSelectionPositionAttribute" :automatic-dropdown="false" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option 
              v-for="item in getElementLocatorTypes"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.attribute_value">
          <el-input :placeholder="lang.dialog.placeholder.enter" size="small" v-model.trim="newInputElement.htmlAttributeValue"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="newInputElement.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('newInputElement')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitNewProjectApplicationSectionElementDialog('newInputElement')">{{ lang.operator.confirm }}</el-button>
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
    },
    data() {
      var validatorAddSectionName = (rule, value, callback) => {
        const obj = {
          sectionId: this.sectionId,
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
      }
      var validatorParams = (rule, value, callback) => {
        if (rule.required && !value) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        projectId: null,
        applicationId: null,
        sectionId: null,
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
        },
      };
    },
    computed: {
      ...mapGetters(['getElementLocatorTypes', 'getElementTypes']),
    },
    methods: {
      ...mapActions(['addSectionElement', 'validateSectionElementName', 'readElementLocatorTypes', 'readElementTypes']),
      cancel(formname) {
        this.newProjectApplicationSectionElementDialog = false;
        this.$refs[formname].resetFields();
      },
      changeSelectionElementType(value) {
        const obj = {
          id: this.newInputElement.type.id
        };
        this.newInputElement.htmlPositionAttribute = '';
        this.newInputElement.htmlAttributeValue = '';
        this.readElementLocatorTypes(obj);
      },
      changeSelectionPositionAttribute() {
        this.newInputElement.htmlAttributeValue = '';
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
              sectionId: this.sectionId,
            };
            var element = {
              projectId: this.projectId,
              applicationId: this.applicationId,
              sectionId: this.sectionId,
              name: this.newInputElement.name,
              type: this.newInputElement.type.name,
              locatorType: this.newInputElement.htmlPositionAttribute.name,
              locatorValue: this.newInputElement.htmlAttributeValue,
              comment: this.newInputElement.comment
            }
            obj.data = [element];
            this.addSectionElement(obj).then((res) => {
              this.$emit('elementAddDone');
            }, (err) => {
              console.log(err);
            });
            this.newProjectApplicationSectionElementDialog = false;
          } else {
            return false;
          }
        })
      },
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
      this.applicationId = window.location.pathname.split('/')[6];
      this.sectionId = window.location.pathname.split('/')[8];
    }
  };
</script>
