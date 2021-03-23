<template>
  <div class="component_button">
    <el-button class="button_text_table el_button_creat"  @click="newProjectLibDialog = true">{{lang.operator.new}}</el-button>


    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false"  :visible.sync="newProjectLibDialog" @open="InitDialog" :show-close="false">
      <el-form :model="newProject" :rules="paramValidation" ref="newProject" label-width="100px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" v-model.trim="newProject.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="newProject.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.project_type" prop="type">
          <el-select v-model="newProject.type" value-key="name"  size="small" filterable :placeholder="lang.dialog.placeholder.select_project_type">
            <el-option
              v-for="item in getSelectProjectType"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('newProject')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submit('newProject')">{{ lang.operator.confirm }}</el-button>
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
      var validatorProjectName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateProjectName(obj).then((res) => {
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
      var validatorProjectType = (rule, value, callback) => {
        if (!value) {
          return callback(new Error(this.lang.dialog.placeholder.select_project_type));
        } else {
          return callback();
        }
      };
      return {
        newProjectLibDialog: false,
        newProject: {
          name: '',
          comment: '',
          type: {}
        },
        paramValidation: {
          name: [{required: true, validator: validatorProjectName, trigger: 'blur'}],
          type: [{required: true, type: 'object', validator: validatorProjectType }]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectProjectType']),
    },
    methods: {
      ...mapActions(['readProjectTypes', 'addProject', 'validateProjectName']),
      InitDialog () {
        this.newProject.name = '';
        this.newProject.comment = '';
        this.newProject.type = '';
        this.readProjectTypes();
      },
      cancel(formname) {
        this.newProjectLibDialog = false;
        this.$refs[formname].resetFields();
      },
      submit(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.newProject.name,
              comment: this.newProject.comment,
              type: this.newProject.type.name
            };
            this.addProject([obj]).then((res) => {
              this.$emit('projectAddDone');
              this.cancel(formname);
            }, (err) => {
              console.log(err);
            });
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
