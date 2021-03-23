<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newInstructionBundleDialog = true">{{lang.operator.new}}</el-button>

    <el-dialog :title="lang.dialog.title.add" :close-on-click-modal="false" :visible.sync="newInstructionBundleDialog" @open="initAddInstructionBundleDialog" :append-to-body="true" :show-close="false">
      <el-form :model="instructionBundle" :rules="paramValidation" ref="instructionBundle" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input  :placeholder="lang.dialog.placeholder.enter_name" size="small" v-model.trim="instructionBundle.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="instructionBundle.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('instructionBundle')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newInstructionBundle('instructionBundle')">{{ lang.operator.confirm }}</el-button>
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
      var validatorInstructionBundleName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateInstructionBundleName(obj).then((res) => {
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
      return {
        instructionBundle: {
          name: '',
          comment: '',
        },
        newInstructionBundleDialog: false,
        paramValidation: {
          name: [{required: true, validator: validatorInstructionBundleName, trigger: 'blur'}]
        },
      };
    },
    methods: {
      ...mapActions(['addInstructionBundle', 'validateInstructionBundleName']),
      cancel(formname) {
        this.newInstructionBundleDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddInstructionBundleDialog() {
        this.instructionBundle.name = '';
        this.instructionBundle.comment = '';
      },
      newInstructionBundle(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.instructionBundle.name,
              comment: this.instructionBundle.comment
            };
            this.addInstructionBundle([obj]).then((res) => {
              this.$emit('bundleAddDone');
            }, (err) => {
              console.log(err);
            });
            this.newInstructionBundleDialog = false;
          } else {
            return false;
          }
        });
      },
    },
  };
</script>