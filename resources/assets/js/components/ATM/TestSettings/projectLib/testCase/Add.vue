<template>
  <div class="component_button">
    <el-button class="button_text_table el_button_creat"  @click="newProjectTestCaseDialog = true">{{lang.operator.new}}</el-button>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false" :visible.sync="newProjectTestCaseDialog" @open="initAddProjectTestCaseDialog" :show-close="false" :append-to-body="true">
      <el-form :model="newTestCase" :rules="paramValidation" ref="newTestCase" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" v-model.trim="newTestCase.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="newTestCase.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.type">
          <el-select v-model="newTestCase.type" filterable default-first-option value-key="name" size="small" :placeholder="lang.dialog.placeholder.select_type">
            <el-option
              v-for="item in getSelectTypesForTestCase"
                :key="item.label + item.value.id"
                :label="testCaseTypeDict[item.label]"
                :value="item.label">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.tag">
          <el-select v-model="newTestCase.tags" filterable default-first-option multiple value-key="name" size="small" :multiple-limit="4" :placeholder="lang.dialog.placeholder.select_tag">
            <el-option
              v-for="item in getSelectTagsForTestCase"
                :key="item.label + item.value.id"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
          <el-tag
            :key="tag.name ? tag.name : tag"
            size="small"
            style="margin-right: 8px;"
            v-for="tag in newTestCase.tags">
            {{tag.name ? tag.name : tag}}
          </el-tag>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('newTestCase')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newProjectTestCase('newTestCase')">{{ lang.operator.confirm }}</el-button>
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
      var validatorTestCaseName = (rule, value, callback) => {
        const obj = {
          name: value,
          projectId: this.projectId
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateTestCaseName(obj).then((res) => {
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
        newProjectTestCaseDialog: false,
        newTestCase: {
          name: '',
          comment: '',
          tags: [],
          type: ''
        },
        testCaseTypeDict: {
          JMeter: "Press Test",
          JSON: "Normal Test",
          Android: "Mobile Test"
        },
        paramValidation: {
          name: [{required: true, validator: validatorTestCaseName, trigger: 'blur'}]
        },
      };
    },
    computed: {
      ...mapGetters([ 'getSelectTagsForTestCase', 'getSelectTypesForTestCase']),
    },
    methods: {
      ...mapActions(['addProjectTestCase', 'validateTestCaseName', 'readTags', 'editTagsForTestCase', 'readTestCaseTypes']),
      cancel(formname) {
        this.newProjectTestCaseDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddProjectTestCaseDialog() {
        this.newTestCase.name = '';
        this.newTestCase.comment = '';
        this.newTestCase.tags = [];
        this.newTestCase.type = 'JSON';
        this.readTags();
        this.readTestCaseTypes();
      },
      newProjectTestCase(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              projectId: this.projectId,
            };
            obj.data = [];
            obj.data.push({
              name: this.newTestCase.name,
              comment: this.newTestCase.comment,
              type: this.newTestCase.type
            });
            if (this.newTestCase.type === 'JMeter'){
              obj.data[0].parameter = '';
            }
            const tags = this.newTestCase.tags.map(tag => { return { id: tag.id } });
            this.addProjectTestCase(obj).then((res) => {
              const param = {
                id: res.data[0].id,
                data: tags
              };
              this.editTagsForTestCase(param).then((res) => {
                this.$emit('testCaseAddDone');
              }, (err) => {
                console.log(err);
              })
            }, (err) => {
              console.log(err);
            });
            this.cancel(formname);
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
    }
  };
</script>

<style>
</style>