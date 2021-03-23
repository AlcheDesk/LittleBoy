<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newSystemRequirementPackDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="newSystemRequirementPackDialog" @open="initAddSystemRequirementPackDialog" :show-close="false" :append-to-body="true">
      <el-form :model="systemRequirementPack" :rules="paramValidation" ref="systemRequirementPack" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" :placeholder="lang.dialog.placeholder.enter_name" v-model.trim="systemRequirementPack.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model="systemRequirementPack.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('systemRequirementPack')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newSystemRequirementPack('systemRequirementPack')">{{ lang.operator.confirm }}</el-button>
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
      var validatorDriverPackName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateSystemRequirementPack(obj).then((res) => {
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
        systemRequirementPack: {
          name: '',
          comment: ''
        },
        newSystemRequirementPackDialog: false,
        paramValidation: {
          name: [{required: true, validator: validatorDriverPackName, trigger: 'blur'}]
        },
      };
    },
    methods: {
      ...mapActions(['addSystemRequirementPack', 'validateSystemRequirementPack']),
      cancel(formname) {
        this.newSystemRequirementPackDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddSystemRequirementPackDialog() {
        this.systemRequirementPack.name = '';
        this.systemRequirementPack.comment = '';
      },
      newSystemRequirementPack(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {};
            obj.name = this.systemRequirementPack.name;
            obj.comment = this.systemRequirementPack.comment;
            this.addSystemRequirementPack([obj]).then((res) => {
              this.$emit('systemRequirementsPackAddDone');
            }, (err) => {
              console.log(err);
            });
            this.newSystemRequirementPackDialog = false;
          } else {
            return false;
          }
        });
      },
    },
  };
</script>