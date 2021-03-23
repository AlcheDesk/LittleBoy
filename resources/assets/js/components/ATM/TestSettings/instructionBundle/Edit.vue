<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="showUpdateInstructionBundleDialog">{{lang.operator.edit}}</el-button>


    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.edit" :visible.sync="updateInstructionBundleDialog" :append-to-body="true" :show-close="false">
      <el-form :model="updateInstructionBundleData" :rules="paramValidationUpdate" ref="updateInstructionBundleData" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input  :placeholder="lang.dialog.placeholder.enter_name" @keyup.enter.native="editInstructionBundle('updateInstructionBundleData')" size="small" v-model.trim="updateInstructionBundleData.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateInstructionBundleData.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="updateInstructionBundleDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editInstructionBundle('updateInstructionBundleData')">{{ lang.operator.confirm }}</el-button>
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
      var validatorInstructionBundleNameUpdate = (rule, value, callback) => {
        const obj = {
          name: value,
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (this.updatePrevName && value != this.updatePrevName) {
            this.validateInstructionBundleName(obj).then((res) => {
              if (parseInt(res.metadata.count) === 0) {
                return callback();
              } else {
                return callback(new Error(this.lang.validator.name.exist));
              }
            }, (err) => {
              console.log(err);
            });
          } else {
            return callback();
          }
        } else {
          return callback(new Error(this.lang.validator.name.consists));
        }
      };
      return {
        updatePrevName: '',
        updateInstructionBundleDialog: false,
        updateInstructionBundleData: {
          id: null,
          name: '',
          comment: '',
        },
        paramValidationUpdate: {
          name: [{required: true, validator: validatorInstructionBundleNameUpdate, trigger: 'blur'}]
        },
      };
    },
    methods: {
      ...mapActions(['updateInstructionBundle', 'validateInstructionBundleName']),
      cancel(formname) {
        this.updateInstructionBundleDialog = false;
        this.$refs[formname].resetFields();
      },
      showUpdateInstructionBundleDialog() {
        this.updatePrevName = this.row.name;
        this.updateInstructionBundleData.id = this.row.id;
        this.updateInstructionBundleData.name = this.row.name;
        this.updateInstructionBundleData.comment = this.row.comment;
        this.updateInstructionBundleDialog = true;
      },
      editInstructionBundle(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.updateInstructionBundleData.id,
              name: this.updateInstructionBundleData.name,
              comment: this.updateInstructionBundleData.comment
            };
            this.updateInstructionBundle([obj]).then((res) => {
              this.$emit('bundleEditDone');
            }, (err) => {
              console.log(err);
            });
            this.updateInstructionBundleDialog = false;
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
