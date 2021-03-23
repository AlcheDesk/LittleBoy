<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="addProjectApplicationDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false" :visible.sync="addProjectApplicationDialog" @open="initProjectApplicationDialog" :show-close="false">
      <el-form :model="newApplication" :rules="paramValidation" ref="newApplication" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" v-model.trim="newApplication.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="newApplication.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('newApplication')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitProjectApplication('newApplication')">{{ lang.operator.confirm }}</el-button>
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
      var validatorApplicationName = (rule, value, callback) => {
        const obj = {
          name: value,
          projectId: this.projectId
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateApplicationName(obj).then((res) => {
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
        projectId: null,
        addProjectApplicationDialog: false,
        newApplication: {
          name: '',
          comment: ''
        },
        paramValidation: {
          name: [{required: true, validator: validatorApplicationName, trigger: 'blur'}]
        },
      };
    },
    methods: {
      ...mapActions(['addProjectApplication', 'validateApplicationName']),
      cancel(formname) {
        this.addProjectApplicationDialog = false;
        this.$refs[formname].resetFields();
      },
      initProjectApplicationDialog() {
        this.newApplication.name = '';
        this.newApplication.comment = '';
      },
      submitProjectApplication(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            var obj = {
              projectId: this.projectId
            }
            obj.data = {
              name: this.newApplication.name,
              comment: this.newApplication.comment
            }
            const param = {};
            param.projectId = obj.projectId;
            param.data = [obj.data];
            this.addProjectApplication(param).then((res) => {
              this.$emit('applicationAddDone');
            }, (err) => {
              console.log(err);
            });
            this.addProjectApplicationDialog = false;
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