<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newFolderLib = true">{{lang.operator.new}}</el-button>

    <el-dialog :title="lang.dialog.title.add" :visible.sync="newFolderLib" @open="InitDialog" :show-close="false" :append-to-body="true">
      <el-form :model="newFolderlib" :rules="paramValidation" ref="newFolderlib" label-width="100px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" v-model.trim="newFolderlib.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="newFolderlib.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('newFolderlib')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submit('newFolderlib')">{{ lang.operator.confirm }}</el-button>
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
      var validatorFolderName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
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
          return callback(new Error(this.lang.validator.name.consists));
        }
      };
      return {
        newFolderlib: {
          name: '',
          comment: '',
        },
        newFolderLib: false,
        paramValidation: {
          name: [{required: true, validator: validatorFolderName, trigger: 'blur'}],
        },
      };
    },
    methods: {
      ...mapActions(['addFolder', 'validateFolderName']),
      cancel(formname) {
        this.newFolderLib = false;
        this.$refs[formname].resetFields();
      },
      InitDialog () {
        this.newFolderlib.name = '';
        this.newFolderlib.comment = '';
      },
      submit(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.newFolderlib.name,
              comment: this.newFolderlib.comment,
            };
            this.addFolder([obj]).then((res) => {
              this.$emit('folderAddDone');
            }, (err) => {
              console.log(err);
            });
            this.newFolderLib = false;
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
