<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="initUpdateDialog">{{lang.operator.edit}}</el-button>

    <el-dialog :title="lang.dialog.title.edit" :visible.sync="updateFolderDialog" :show-close="false" :append-to-body="true">
      <el-form :model="updateTargetFolder" :rules="paramValidationUpdate" ref="updateTargetFolder" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" v-model.trim="updateTargetFolder.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateTargetFolder.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateTargetFolder')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editFolder('updateTargetFolder')">{{ lang.operator.confirm }}</el-button>
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
      var validatorUpdateFolderName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (value != this.updatePrevName) {
            this.validateFolderName(obj).then((res) => {
              if (parseInt(res.metadata.count) === 0) {
                return callback();
              } else {
                return callback(new Error(this.lang.validator.name.exist));
              }
            }, (err) => {
              console.log(err)
            });
          } else {
            return callback();
          }
        } else {
          return callback(new Error(this.lang.validator.name.consists));
        }
      };
      return {
        updateTargetFolder: {
          id: null,
          name: '',
          comment: '',
          type: ''
        },
        updatePrevName: '',
        paramValidationUpdate: {
          name: [{required: true, validator: validatorUpdateFolderName, trigger: 'onchange'}],
        },
        updateFolderDialog: false,
      };
    },
    methods: {
      ...mapActions(['validateFolderName', 'updateFolder']),
      cancel(formname) {
        this.updateFolderDialog = false;
        this.$refs[formname].resetFields();
      },
      initUpdateDialog() {
        this.updatePrevName = this.row.name;
        this.updateTargetFolder.id = this.row.id;
        this.updateTargetFolder.name = this.row.name;
        this.updateTargetFolder.comment = this.row.comment;
        this.updateFolderDialog = true;
      },
      editFolder(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.updateTargetFolder.id,
              name: this.updateTargetFolder.name,
              comment: this.updateTargetFolder.comment
            };
            this.updateFolder([obj]).then((res) => {
              this.$emit('folderEditDone');
            }, (err) => {
              console.log(err);
            });
            this.updateFolderDialog = false;
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
