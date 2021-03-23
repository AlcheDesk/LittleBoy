<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newEnginePropertiesDialog = true">{{lang.operator.new}}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="newEnginePropertiesDialog" @open="initAddEnginePropertiesDialog" :show-close="false" :append-to-body="true">
      <el-form :model="engineProperties" :rules="paramValidation" ref="engineProperties" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.property_name" prop="name">
          <el-select v-model="engineProperties.name" clearable value-key="name" @change="changeDriverProperties" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in selectProperties"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.defaults">
          <el-input size="small" placeholder="" disabled v-model.trim="engineProperties.defaultValue"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.description">
          <el-input type="textarea" :rows="2" placeholder="" disabled v-model.trim="engineProperties.description"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.value_type">
          <el-input size="small" placeholder="" disabled v-model.trim="engineProperties.valueType"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.value" prop="value">
          <template v-if="engineProperties.valueType == 'boolean'">
            <el-checkbox v-model="engineProperties.value">{{engineProperties.value}}</el-checkbox>
          </template>
          <template v-else-if="engineProperties.valueType == 'integer'">
            <el-input type="number" size="small"  placeholder="" v-model.number="engineProperties.value"></el-input>
          </template>
          <template v-else>
            <template v-if="!engineProperties.name.predefinedValueRequired">
              <el-input type="textarea" :rows="2" placeholder="" v-model.trim="engineProperties.value"></el-input>
            </template>
            <template v-else>
              <el-select v-model="engineProperties.value" value-key="name" clearable size="small" filterable :placeholder="lang.dialog.placeholder.select">
                <el-option
                  v-for="item in getDriverPropertyPredefinedValues"
                  :key="item.label"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </template>
          </template>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('engineProperties')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newEngineProperties('engineProperties')">{{ lang.operator.confirm }}</el-button>
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
        engineId: null,
        engineProperties: {
          name: '',
          defaultValue: '',
          description: '',
          valueType: '',
          value: ''
        },
        newEnginePropertiesDialog: false,
        paramValidation: {
          name: [{required: true, validator: validatorParams, trigger: 'blur'}],
          value: [{required: true, validator: validatorParams, trigger: 'blur'}]
        },
        selectProperties: [],
      };
    },
    computed: {
      ...mapGetters(['getEngines', 'getEngineProperties', 'getDriverPropertyPredefinedValues'])
    },
    watch: {
      getEngineProperties: function() {
        this.selectProperties = this.getEngineProperties.data.map(item => { return { label: item.name, value: item } });
      }
    },
    methods: {
      ...mapActions(['readEngineProperties', 'addEngines', 'readDriverPropertiesPredefinedValue']),
      cancel(formname) {
        this.newEnginePropertiesDialog = false;
        this.$refs[formname].resetFields();
      },
      changeDriverProperties(value) {
        this.engineProperties.defaultValue = value.defaultValue;
        this.engineProperties.description = value.description;
        this.engineProperties.valueType = value.valueType;
        if (value.valueType === 'string') {
          this.engineProperties.value = value.defaultValue;
        } else {
          this.engineProperties.value = null;
        }
        if (value.predefinedValueRequired) {
          this.readDriverPropertiesPredefinedValue(value);
        }
      },
      initAddEnginePropertiesDialog() {
        this.engineProperties.name = '';
        this.engineProperties.defaultValue = '';
        this.engineProperties.description = '';
        this.engineProperties.valueType = '';
        this.engineProperties.value = null;
        const obj = {
          engineId: this.engineId
        };
        this.readEngineProperties(obj);
      },
      newEngineProperties(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.engineId
            };
            const param = {};
            for (let [key, value] of Object.entries(this.getEngines.data[0].property)) {
              param[key] = value;
            }
            param[this.engineProperties.name.name] = this.engineProperties.value;
            obj.property = param;
            this.addEngines(obj).then((res) => {
              this.$emit('propertiesAddDone')
            }, (err) => {
              console.log(err);
            })
            this.newEnginePropertiesDialog = false;
          } else {
            return false;
          }
        })
      },
    },
    mounted() {
      this.engineId = window.location.pathname.split('/')[4];
    }
  };
</script>
