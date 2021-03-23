<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="showProjectApplicationSectionUpdateDialog()">{{lang.operator.edit}}</el-button>

    <el-dialog  :title="lang.dialog.title.edit" :close-on-click-modal="false" :visible.sync="updateProjectApplicationSectionDialog" :show-close="false" :append-to-body="true">
      <el-form :model="updateSection" :rules="paramValidationUpdate" ref="updateSection" label-width="120px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" @keyup.enter.native="submitProjectApplicationSectionUpdate('updateSection')" v-model.trim="updateSection.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateSection.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateSection')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitProjectApplicationSectionUpdate('updateSection')">{{ lang.operator.confirm }}</el-button>
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
      var validatorSectionNameUpdate = (rule, value, callback) => {
        const obj = {
          name: value,
          applicationId: this.applicationId
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (this.updatePrevName && value != this.updatePrevName) {
            this.validateSectionName(obj).then((res) => {
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
        applicationId: null,
        updateProjectApplicationSectionDialog: false,
        updateSection: {
          id: null,
          name: '',
          comment: ''
        },
        paramValidationUpdate: {
          name: [{required: true, validator: validatorSectionNameUpdate, trigger: 'blur'}]
        },
        updatePrevName: '',
      };
    },
    methods: {
      ...mapActions(['updateApplicationSection', 'validateSectionName']),
      cancel(formname) {
        this.updateProjectApplicationSectionDialog = false;
        this.$refs[formname].resetFields();
      },
      showProjectApplicationSectionUpdateDialog() {
        this.updatePrevName = this.row.name;
        this.updateSection.id = this.row.id;
        this.updateSection.name = this.row.name;
        this.updateSection.comment = this.row.comment;
        this.updateProjectApplicationSectionDialog = true;
      },
      submitProjectApplicationSectionUpdate(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            var obj = {
              id: this.updateSection.id,
              name: this.updateSection.name,
              comment: this.updateSection.comment
            };
            this.updateApplicationSection([obj]).then((res) => {
              this.$emit('sectionEditDone');
            }, (err) => {
              console.log(err);
            });
            this.updateProjectApplicationSectionDialog = false;
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      this.applicationId = window.location.pathname.split('/')[6];
    }
  };
</script>

<style>
</style>