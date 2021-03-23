<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newEnginesDialog = true">{{lang.operator.new}}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="newEnginesDialog" @open="initAddEnginesDialog" :show-close="false" :append-to-body="true">
      <el-form :model="engines" :rules="paramValidation" ref="engines" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.engine_name" prop="name">
          <el-input size="small" v-model.trim="engines.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.type" prop="driverType">
          <el-select v-model="engines.driverType" value-key="name" @change="changeDriverType" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getDriverType"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.vendor" prop="driverVendor">
          <el-select v-model="engines.driverVendor" value-key="name" @change="changeDriverVendor" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="(item, index) in getDriverVendor"
              :key="item.label + index"
              :label="item.label"
              :value="item.value">
              <span style="float: left">{{ item.label }}</span>
              <span style="margin-left: 20px; color: #8492a6; font-size: 13px">version  {{ item.value.version || '(default)' }}</span>
            </el-option>
          </el-select>
        </el-form-item>
        <template v-if="JDBC">
          <el-form-item :label="lang.dialog.title.class_name" prop="dataSourceClassName">
            <el-input size="small" v-model.trim="engines.dataSourceClassName" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
          </el-form-item>
          <el-form-item label="jdbcUrl" prop="jdbcUrl">
            <el-input size="small" v-model.trim="engines.jdbcUrl" :placeholder="lang.dialog.placeholder.enter"></el-input>
          </el-form-item>
          <el-form-item :label="lang.dialog.title.user_name" prop="username">
            <el-input size="small" v-model.trim="engines.username" :placeholder="lang.dialog.placeholder.enter"></el-input>
          </el-form-item>
          <el-form-item :label="lang.dialog.title.password" prop="password">
            <el-input size="small" v-model.trim="engines.password" :placeholder="lang.dialog.placeholder.enter"></el-input>
          </el-form-item>
        </template>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="engines.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('engines')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newEngines('engines')">{{ lang.operator.confirm }}</el-button>
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
      var validatorAddEngineName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateDriversName(obj).then((res) => {
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
        engines: {
          name: '',
          comment: '',
          driverType: '',
          driverVendor: '',
          dataSourceClassName: '',
          jdbcUrl: '',
          username: '',
          password: ''
        },
        newEnginesDialog: false,
        paramValidation: {
          name: [{required: true, validator: validatorAddEngineName, trigger: 'blur'}],
          driverType: [{required: true, type: 'object', validator: validatorParams }],
          driverVendor: [{required: true, type: 'object', validator: validatorParams }],
          dataSourceClassName: [{required: true, validator: validatorParams }],
          jdbcUrl: [{required: true, validator: validatorParams }],
          username: [{required: true, validator: validatorParams }],
          password: [{required: true, validator: validatorParams }],
        },
        JDBC: false,
      };
    },
    computed: {
      ...mapGetters(['getDriverType', 'getDriverVendor'])
    },
    methods: {
      ...mapActions(['addEngines', 'readDriverType', 'readDriverVendor', 'validateDriversName']),
      cancel(formname) {
        this.newEnginesDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddEnginesDialog() {
        this.engines.name = '';
        this.engines.comment = '';
        this.engines.version = '';
        this.engines.driverType = '';
        this.engines.driverVendor = '';
        this.readDriverType();
      },
      changeDriverType(value) {
        const param = {
          id: value.id
        };
        this.engines.driverVendor = '';
        this.engines.comment = '';
        this.readDriverVendor(param);
        if (value.name === 'JDBC') {
          this.JDBC = true;
          this.engines.dataSourceClassName = '';
          this.engines.jdbcUrl = '';
          this.engines.username = '';
          this.engines.password = '';
        } else {
          this.JDBC = false;
        }
      },
      changeDriverVendor(value) {
        this.engines.comment = '';
      },
      newEngines(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {};
            obj.name = this.engines.name;
            obj.comment = this.engines.comment;
            obj.vendorName = this.engines.driverVendor.name;
            obj.type = this.engines.driverType.name;
            this.engines.driverVendor.version ? obj.version = this.engines.driverVendor.version : null;
            if (this.JDBC) {
              obj.property = {};
              obj.property.dataSourceClassName = this.engines.dataSourceClassName;
              obj.property.jdbcUrl = this.engines.jdbcUrl;
              obj.property.username = this.engines.username;
              obj.property.password = this.engines.password;
            }
            this.addEngines([obj]).then((res) => {
              this.$emit('engineAddDone');
            }, (err) => {
              console.log(err);
            });
            this.newEnginesDialog = false;
          } else {
            return false;
          }
        });
      },
    },
  };
</script>