<template>
  <div class="component_button">
    <el-button class="button_text_table" @click.stop="showProjectTestCaseEditDialog">{{lang.operator.edit}}</el-button>


    <el-dialog :append-to-body="true" :title="lang.dialog.title.edit" :close-on-click-modal="false" :visible.sync="projectTestCaseEditDialog" :show-close="false">
      <el-form :model="updateTestCase" :rules="paramValidationUpdate" ref="updateTestCase" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" v-model.trim="updateTestCase.name" :placeholder="lang.dialog.placeholder.enter_name" @keyup.enter.native="submitProjectTestCaseEdit('updateTestCase')"></el-input>
        </el-form-item>
        <!-- <el-form-item :label="lang.table.type">
          <el-input readonly size="small" :placeholder="lang.dialog.placeholder.select_type" v-model.trim="updateTestCase.type"></el-input>
        </el-form-item> -->
        <el-form-item :label="lang.table.type">
          <el-select v-model="updateTestCase.type" filterable default-first-option value-key="name" size="small" :placeholder="lang.dialog.placeholder.select_type">
            <el-option
              v-for="item in getSelectTypesForTestCase"
                :key="item.label + item.value.id"
                :label="testCaseTypeDict[item.label]"
                :value="item.label">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.table.comment">
          <el-input type="textarea" :rows="3" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateTestCase.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.tag">
          <el-select v-model="updateTestCase.tags" filterable multiple value-key="name" size="small" :multiple-limit="4" :placeholder="lang.dialog.placeholder.select_tag">
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
            v-for="tag in updateTestCase.tags">
            {{tag.name ? tag.name : tag}}
          </el-tag>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateTestCase')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitProjectTestCaseEdit('updateTestCase')">{{ lang.operator.confirm }}</el-button>
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
      var validatorTestCaseNameUpdate = (rule, value, callback) => {
        const obj = {
          name: value,
          projectId: this.projectId
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (this.updatePrevName && value !== this.updatePrevName) {
            this.validateTestCaseName(obj).then((res) => {
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
        updatePrevName: '',
        deleteTagIds: '',
        paramValidationUpdate: {
          name: [{required: true, validator: validatorTestCaseNameUpdate, trigger: 'blur'}]
        },
        projectTestCaseEditDialog: false,
        testCaseTypeDict: {
          JMeter: "Press Test",
          JSON: "Normal Test",
          Android: "Mobile Test"
        },
        updateTestCase: {
          id: null,
          name: '',
          comment: '',
          tags: []
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectTagsForTestCase', 'getSelectTypesForTestCase']),
    },
    methods: {
      ...mapActions(['markProjectTestCase', 'validateTestCaseName', 'readTags', 'deleteTagsForTestCase', 'editTagsForTestCase', 'readTestCaseTypes']),
      cancel(formname) {
        this.projectTestCaseEditDialog = false;
        this.$refs[formname].resetFields();
      },
      showProjectTestCaseEditDialog() {
        this.updatePrevName = this.row.name;
        this.updateTestCase.id = this.row.id;
        this.updateTestCase.name = this.row.name;
        this.updateTestCase.type = this.testCaseTypeDict[this.row.type];
        this.updateTestCase.comment = this.row.comment;
        this.updateTestCase.tags = this.row.tags;
        this.readTags();
        this.readTestCaseTypes();
        const tags = this.row.tags.map(tag => { return tag.id });
        this.deleteTagIds = tags.join(',');
        this.projectTestCaseEditDialog = true;
      },
      submitProjectTestCaseEdit(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.updateTestCase.id,
              name: this.updateTestCase.name,
              comment: this.updateTestCase.comment
            };
            const tags = this.updateTestCase.tags.map(tag => { return { id: tag.id } });
            const len = tags.length;
            this.markProjectTestCase([obj]).then((res) => {
              const del = {
                id: res.data[0].id,
                tagId: this.deleteTagIds
              };
              if (this.deleteTagIds) {
                this.deleteTagsForTestCase(del).then((res) => {
                  if (len) {
                    const addObj = {
                      id: this.updateTestCase.id,
                      data: tags
                    }
                    this.editTagsForTestCase(addObj).then((res) => {
                      this.cancel(formname);
                      this.$emit('testCaseEditDone');
                    })
                  } else {
                    this.cancel(formname);
                    this.$emit('testCaseEditDone');
                  }
                }, (err) => {
                  console.log(err);
                })
              } else {
                if (len) {
                  const addObj = {
                    id: this.updateTestCase.id,
                    data: tags
                  }
                  this.editTagsForTestCase(addObj).then((res) => {
                    this.cancel(formname);
                    this.$emit('testCaseEditDone');
                  })
                } else {
                  this.cancel(formname);
                  this.$emit('testCaseEditDone');
                }
              }
            }, (err) => {
              console.log(err);
            });
            this.projectTestCaseEditDialog = false;
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