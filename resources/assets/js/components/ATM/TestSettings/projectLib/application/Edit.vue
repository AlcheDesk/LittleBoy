<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="updateApplicationSection()">{{lang.operator.edit}}</el-button>


    <el-dialog  :title="lang.dialog.title.edit" :close-on-click-modal="false" :visible.sync="updateProjectApplicationDialog" :show-close="false" :append-to-body="true">
      <el-form :model="updateApplication" :rules="paramValidationUpdate" ref="updateApplication" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" @keyup.enter.native="editProjectApplication('updateApplication')" v-model.trim="updateApplication.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateApplication.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateApplication')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editProjectApplication('updateApplication')">{{ lang.operator.confirm }}</el-button>
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
      var validatorApplicationNameUpdate = (rule, value, callback) => {
        const obj = {
          name: value,
          projectId: this.projectId
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (this.updatePrevName && value != this.updatePrevName) {
            this.validateApplicationName(obj).then((res) => {
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
        projectId: null,
        updateApplication: {
          id: null,
          name: '',
          comment: ''
        },
        paramValidationUpdate: {
          name: [{required: true, validator: validatorApplicationNameUpdate, trigger: 'blur'}]
        },
        updateProjectApplicationDialog: false,
        updatePrevName: '',
      };
    },
    methods: {
      ...mapActions(['validateApplicationName', 'updateProjectApplication']),
      cancel(formname) {
        this.updateProjectApplicationDialog = false;
        this.$refs[formname].resetFields();
      },
      updateApplicationSection() {
        this.updatePrevName = this.row.name;
        this.updateApplication.id = this.row.id;
        this.updateApplication.name = this.row.name;
        this.updateApplication.comment = this.row.comment;
        this.updateProjectApplicationDialog = true;
      },
      editProjectApplication(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            var obj = {
              id: this.updateApplication.id,
              name: this.updateApplication.name,
              comment: this.updateApplication.comment
            }
            this.updateProjectApplication([obj]).then((res) => {
              this.$emit('applicationEditDone');
            }, (err) => {
              console.log(err);
            });
            this.updateProjectApplicationDialog = false;
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