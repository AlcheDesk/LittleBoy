<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="projectApplicationSectionDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false" :visible.sync="projectApplicationSectionDialog" @open="initProjectApplicationSectionCreateDialog" :show-close="false" :append-to-body="true">
      <el-form :model="newSection" :rules="paramValidation" ref="newSection" label-width="120px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" @keyup.enter.native="submitProjectApplicationSection('newSection')" v-model.trim="newSection.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="newSection.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('newSection')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitProjectApplicationSection('newSection')">{{ lang.operator.confirm }}</el-button>
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
      var validatorSectionName = (rule, value, callback) => {
        const obj = {
          name: value,
          applicationId: this.applicationId
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateSectionName(obj).then((res) => {
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
        applicationId: null,
        newSection: {
          name: '',
          comment: ''
        },
        paramValidation: {
          name: [{required: true, validator: validatorSectionName, trigger: 'blur'}]
        },
        projectApplicationSectionDialog: false,
      };
    },
    methods: {
      ...mapActions(['addApplicationSection', 'validateSectionName']),
      cancel(formname) {
        this.projectApplicationSectionDialog = false;
        this.$refs[formname].resetFields();
      },
      initProjectApplicationSectionCreateDialog() {
        this.newSection.name = '';
        this.newSection.comment = '';
      },
      submitProjectApplicationSection(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            var obj = {
              applicationId: this.applicationId
            };
            obj.data = {
              projectId: this.projectId,
              name: this.newSection.name,
              comment: this.newSection.comment
            };
            const param = {};
            param.applicationId = obj.applicationId;
            param.data = [obj.data];
            this.addApplicationSection(param).then((res) => {
              this.$emit('sectionAddDone');
            }, (err) => {
              console.log(err);
            })
            this.projectApplicationSectionDialog = false;
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
      this.applicationId = window.location.pathname.split('/')[6];
    }
  };
</script>

<style>
</style>