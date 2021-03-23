<template>
  <div class="component_button">
    <el-button class="button_text_table el_button_edit" @click.stop="updateProjectDialog = true">{{lang.operator.edit}}</el-button>

    <el-dialog :append-to-body="true" :title="lang.dialog.title.edit" :close-on-click-modal="false" :visible.sync="updateProjectDialog" @open="initUpdateDialog" :show-close="false">
      <el-form :model="updateTargetProject" :rules="paramValidationUpdate" ref="updateTargetProject" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" @keyup.enter.native="editProject('updateTargetProject')" v-model.trim="updateTargetProject.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateTargetProject.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.project_type" prop="type">
          <el-select v-model="updateTargetProject.type" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_project_type">
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
        <el-button @click="cancel('updateTargetProject')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editProject('updateTargetProject')">{{ lang.operator.confirm }}</el-button>
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
      var validatorUpdateProjectName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (value != this.updatePrevName) {
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
            return callback();
          }
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
        updateProjectDialog: false,
        updateTargetProject: {
          id: null,
          name: '',
          comment: '',
          type: {}
        },
        updatePrevName: '',
        paramValidationUpdate: {
          name: [{required: true, validator: validatorUpdateProjectName, trigger: 'blur'}],
          type: [{required: true, type: 'object', validator: validatorProjectType }]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectProjectType']),
    },
    methods: {
      ...mapActions(['readProjectTypes', 'updateProject', 'validateProjectName']),
      cancel(formname) {
        this.updateProjectDialog = false;
        this.$refs[formname].resetFields();
      },
      initUpdateDialog() {
        this.updatePrevName = this.row.name;
        this.updateTargetProject.id = this.row.id;
        this.updateTargetProject.name = this.row.name;
        this.updateTargetProject.comment = this.row.comment;
        this.updateTargetProject.type = this.row.type;
        this.readProjectTypes();
      },
      editProject(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.updateTargetProject.id,
              name: this.updateTargetProject.name,
              comment: this.updateTargetProject.comment
            }
            obj.type = this.updateTargetProject.type.name || this.updateTargetProject.type;
            this.updateProject([obj]).then((res) => {
              this.$emit('projectEditDone');
            }, (err) => {
              console.log(err);
            });
            this.cancel(formname);
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
