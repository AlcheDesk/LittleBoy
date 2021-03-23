<template>
  <div>
    <project-container>
      <div slot="toolbar">
        <project-tool-bar :messageInfo="projectMessage">
          <div slot="breadcrumb">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item>
                <a href='/atm/TestSetting/Project/?page=1+25'>{{ lang.breadcrumb.project_lib }}</a>
              </el-breadcrumb-item>
              <el-breadcrumb-item>{{ lang.breadcrumb.test_case }}</el-breadcrumb-item>
            </el-breadcrumb>
          </div>
          <div slot="operation">
            <template v-if="permissionRule.add_test_cases_to_run_plan">
              <testcase-to-runlist
                class="button_text_table"
                :lang="lang"
                :permissionRule="permissionRule"
                :selections="multipleSelection"
                @clearSelect="clearMultipleSelect">
              </testcase-to-runlist>
            </template>
            <template v-if="permissionRule.add_test_cases">
              <add
                :lang="lang"
                @testCaseAddDone="getMessageDetails">
              </add>
            </template>
            <template v-if="permissionRule.view_test_case_tags">
              <el-button class="button_text_table el_button_open" @click="showTestCaseTagsDialog">{{lang.operator.tag_management}}</el-button>
            </template>
          </div>
        </project-tool-bar>
      </div>
      <div slot="container">
        <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
          <template v-slot:table>
            <el-row :gutter="20" class="tag_bar">
              <el-col :span="4" class="tags_select">
                <div class="tags_label">{{lang.table.tag}}:</div>
                <div class="tags_content">
                  <el-button size="mini" @click="showSelectTagsForSearchDialog" class="tag_button">{{lang.operator.select_tag}}</el-button>
                </div>
              </el-col>
              <el-col :span="20" class="tags_show">
                <el-tag
                  v-for="tag in searchObj.tags"
                  :key="tag.name"
                  size="small"
                  style="margin-right: 8px;">
                  {{tag}}
                </el-tag>
              </el-col>
            </el-row>
            <el-table
              border
              ref="testCaseTable"
              :data="getProjectTestCase.data"
              row-class-name="row_css"
              :default-sort="{prop: 'id', order: 'descending'}"
              @sort-change="sortChange"
              @row-dblclick="NavigationToCaseInstruction"
              @selection-change="handleSelectionChange"
              :row-key="setRowKey"
              style="width: auto">
              <el-table-column
                :label="lang.table.id"
                :resizable="true"
                align="left"
                sortable="custom"
                prop="id"
                width="100"
                show-overflow-tooltip>
                <template slot-scope="scope">
                {{ scope.row.id }}
                  <i class="fa fa-paperclip fa-fw fa-rotate-90" aria-hidden="true" v-if="scope.row.flagged"></i>
                </template>
              </el-table-column>
              <el-table-column
                type="selection"
                align="left"
                :reserve-selection="true"
                width="50">
              </el-table-column>
              <el-table-column
                :label="lang.table.name"
                :resizable="true"
                align="left"
                sortable="custom"
                prop="name"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <i class="icon_t"></i>
                  {{scope.row.name}}
                </template>
              </el-table-column>
              <!-- <el-table-column
                label="创建者"
                :resizable="true"
                align="left"
                prop="creator"
                show-overflow-tooltip>
              </el-table-column> -->
              <el-table-column
                :label="lang.table.create_at"
                :resizable="true"
                align="left"
                sortable="custom"
                prop="createdAt"
                show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                :label="lang.table.comment"
                :resizable="true"
                align="left"
                prop="comment"
                show-overflow-tooltip>
              </el-table-column>
              <el-table-column
                :label="lang.table.tag"
                :resizable="true"
                align="left"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <el-tag
                    :key="tag.name"
                    size="small"
                    style="margin-right: 8px;"
                    v-for="tag in scope.row.tags">
                    {{tag.name ? tag.name : tag}}
                  </el-tag>
                </template>
              </el-table-column>
              <template v-if="Object.keys(permissionRule).length">
                <el-table-column
                  :label="lang.table.operating"
                  :resizable="true"
                  align="left"
                  show-overflow-tooltip>
                  <template slot-scope="scope">
                    <template v-if="permissionRule.import_test_cases">
                      <el-button class="button_text_table" @click="downLoadTestCase(scope)">{{lang.operator.export}}</el-button>
                    </template>
                    <template v-if="permissionRule.edit_test_cases">
                      <edit
                        :lang="lang"
                        :row="scope.row"
                        @testCaseEditDone="getMessageDetails">
                      </edit>
                    </template>
                    <template v-if="permissionRule.copy_test_cases">
                      <el-button class="button_text_table" @click="showProjectTestCaseSaveAsDialog(scope)">{{lang.operator.copy}}</el-button>
                    </template>
                    <template v-if="permissionRule.edit_test_cases">
                      <template v-if="scope.row.flagged">
                        <el-button class="button_text_table tag_cancel_button" @click="markTestCase(scope)">{{ lang.operator.cancel }}</el-button>
                      </template>
                      <template v-else>
                        <el-button class="button_text_table" @click="markTestCase(scope)">{{ lang.table.mark }}</el-button>
                      </template>  
                    </template>
                    <template v-if="permissionRule.delete_test_cases">
                      <el-button class="button_text_table" @click.stop="removeProjectTestCase(scope)">{{lang.operator.delete}}</el-button>
                    </template>
                  </template>
                </el-table-column>
              </template>
            </el-table>
          </template>
        </search-pagination>
      </div>
    </project-container>

    <el-dialog  :title="lang.dialog.title.select_tag" :close-on-click-modal="false" :visible.sync="selectTagsForSearchDialog" :show-close="false">
      <el-form :model="searchObj" ref="searchObj" label-width="0px" label-position="right" label-suffix=":" style="text-align: left;">
        <el-form-item>
          <el-checkbox-group
            size="mini"
            :max="10"
            v-model="searchObj.tags">
            <el-checkbox
              border
              v-for="tag in getSelectTagsForTestCase"
              :label="tag.label"
              :key="tag.label">
              {{tag.label}}
            </el-checkbox>
          </el-checkbox-group>
        </el-form-item>
        <el-form-item>
          <el-switch
            v-model="searchObj.logic"
            :active-text="lang.operator.and"
            :inactive-text="lang.operator.or">
          </el-switch>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancelSelectTagsForSearch">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="getMessageDetails">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :close-on-click-modal="false" :title="lang.operator.tag_management" :visible.sync="testCaseTagsDialog" :show-close="false">
      <el-form :model="testCaseTag" :rules="paramValidationTag" ref="testCaseTag" label-width.first="100px" label-position="right" label-suffix=":" style="text-align: left;">
        <el-form-item :label="lang.table.name" prop="name">
          <el-row :gutter="10">
            <el-col :span="17">
              <el-input :placeholder="lang.dialog.placeholder.enter_name" size="small" v-model.trim="testCaseTag.name"></el-input>
            </el-col>
            <el-col :span="4">
              <template v-if="testCaseTag.alias.length">
                <template v-if="permissionRule.edit_test_case_tags">
                  <el-button size="mini" class="el_button_open" @click="updateTestCaseTagSubmit('testCaseTag')">{{lang.operator.edit}}</el-button>
                </template>
              </template>
              <template v-else>
                <template v-if="permissionRule.add_test_case_tags">
                  <el-button size="mini" class="el_button_open" @click="addTestCaseTagSubmit('testCaseTag')">{{lang.operator.new}}</el-button>
                </template>
              </template>
            </el-col>
          </el-row>
        </el-form-item>
        <el-form-item>
          <el-checkbox-group
            size="mini"
            :max="1"
            @change="changeTestCaseTag"
            v-model="testCaseTag.alias">
            <el-checkbox border
              :max="1"
              v-for="tag in getSelectTagsForTestCase"
              :label="tag.label"
              :key="tag.label">
              <template v-if="permissionRule.delete_test_case_tags">
                <el-tag size="mini" closable @close="handleClose(tag)">{{tag.label}}</el-tag>
              </template>
              <template v-else>
                <el-tag size="mini">{{tag.label}}</el-tag>
              </template>
            </el-checkbox>
          </el-checkbox-group>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('testCaseTag')">{{lang.operator.cancel}}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import testcaseToRunlist from './testCaseToRunList.vue'
  import Add from './Add.vue'
  import Edit from './Edit.vue'

  export default {
    props: ['message'],
    data() {
      var validatorTestCaseTag = (rule, value, callback) => {
        const self = this;
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        };
        if (this.testCaseTag.alias.length) {
          const flag1 = this.getSelectTagsForTestCase.find(function (tag) {
            if (tag.label === value) {
              self.testCaseTag.alias.push(tag.label);
              return true;
            }
          });
          if (flag1) {
            return callback(new Error(this.lang.validator.name.exist));
          } else {
            this.testCaseTag.alias = [];
            return callback();
          }
        } else {
          const flag = this.getSelectTagsForTestCase.find(function (tag) {
            if (tag.label === value) {
              self.testCaseTag.alias.push(tag.label);
              return true;
            }
          });
          if (flag) {
            return callback(new Error(this.lang.validator.name.exist));
          } else {
            this.testCaseTag.alias = [];
            return callback();
          }
        }
      };
      return {
        permissionRule: {},
        lang: {},
        projectId: null,
        total: 0,
        projectMessage: {},
        searchObj: {
          tags: [],
          logic: false
        },
        orderBy: 'id desc',
        selectTagsForSearchDialog: false,
        multipleSelection: [],
        testCaseTagsDialog: false,
        testCaseTag: {
          name: '',
          alias: []
        },
        paramValidationTag: {
          name: [{type: 'array', required: true, validator: validatorTestCaseTag, trigger: 'blur'}]
        },
        editTestCaseTagData: {},
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
      }
    },
    computed: {
      ...mapGetters(['getProjectTestCase', 'getSelectTagsForTestCase'])
    },
    components: { testcaseToRunlist, Add, Edit },
    watch: {
      getProjectTestCase: function() {
        this.total = this.getProjectTestCase.metadata.count;
      }
    },
    methods: {
      ...mapActions(['validateTestCaseDelete', 'readProjectTestCases', 'deleteProjectTestCase', 'saveasProjectTestCase', 'markProjectTestCase', 'readProjectFormessage', 'readFileDownLoadMessage', 'readTags', 'deleteTagsForTestCase', 'addTags', 'updateTags', 'removeTags', 'countRemoveTagsForTestCase']),
      cancel(formname) {
        this.testCaseTagsDialog = false;
        this.$refs[formname].resetFields();
      },
      setRowKey(row) {
        return row.name + row.id;
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      clearMultipleSelect() {
        this.$refs.testCaseTable.clearSelection();
      },
      NavigationToCaseInstruction(row, event) {
        localStorage.setItem('caseOrderBy', this.orderBy);
        window.open('/atm/TestSetting/Project/' + this.projectId + '/TestCase/' + row.id + '/Instruction/?page=1+25');
        localStorage.setItem('caseCurrentPage', this.queryObj.pageNumber);
        localStorage.setItem('caseCurrentSize', this.queryObj.pageSize);
      },
      downLoadTestCase(scope) {
        // this.readFileDownLoadMessage().then((res) => {
        //   var FileUrl = '';
        //   for (let l = 0; l < res.data.length; l++) {
        //     if (res.data[l].key == 'meowlomo.atm.hostname')
        //       FileUrl = res.data[l].value
        //   }
        //   const url = 'http://' + FileUrl + ':8080/api/download/testCases/' + scope.row.id;
        //   window.open(url);
        // }, (err) => {
        //   console.log(err);
        // })
        const url = 'http://' + window.location.host + '/atm/export/testCase/' + scope.row.id;
        window.open(url);
      },
      getMessageDetails() {
        const obj = {};
        obj.projectId = this.projectId;
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = this.orderBy;
        this.searchObj.tags.join(',') ? obj.data.tags = this.searchObj.tags.join(',') : null;
        this.searchObj.tags.join(',') ? obj.data.logic = this.searchObj.logic : null;
        this.selectTagsForSearchDialog = false;
        this.readProjectTestCases(obj);
      },
      markTestCase(scope) {
        var obj = {};
        obj.id = scope.row.id;
        obj.flagged = !scope.row.flagged;
        this.markProjectTestCase([obj]).then((res) => {
          this.getMessageDetails();
        }, (err) => {
          console.log(err);
        });
      },
      handleCloseTag(tag, scope) {
        const param = {
          id: scope.row.id,
          tagId: tag.id
        }
        this.deleteTagsForTestCase(param).then((res) => {
          this.getMessageDetails();
        }, (err) => {
          console.log(err);
        })
      },
      showProjectTestCaseSaveAsDialog(scope) {
        this.$confirm(this.lang.dialog.title.copy + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.copy, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = [{
            id: scope.row.id
          }];
          this.saveasProjectTestCase(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
        }).catch(() => {
          this.$message({
            type:'info',
            message: this.lang.dialog.title.uncopy
          });
        });
      },
      removeProjectTestCase(scope) {
        this.validateTestCaseDelete(scope.row.id).then((res) => {
          if (res.metadata.count) {
            this.$notify.warning({
              title: this.lang.dialog.title.delete_warnning,
              message: this.lang.dialog.title.delete_wrong_message_1 + scope.row.name + this.lang.dialog.title.delete_wrong_message_2,
              position: 'bottom-right'
            });
          } else {
            this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
              confirmButtonText: this.lang.operator.confirm,
              cancelButtonText: this.lang.operator.cancel,
              type: 'warning',
              dangerouslyUseHTMLString: true
            }).then(() => {
              const obj = {};
              obj.id = scope.row.id;
              obj.projectId = this.projectId;
              this.deleteProjectTestCase(obj).then((res) => {
                this.getMessageDetails();
              }, (err) => {
                console.log(err);
              });
            }).catch(() => {
              this.$message({
                type:'info',
                message: this.lang.operator.undelete
              });
            });
          }
        })
      },
      sortChange(column) {
        if (column && column.order === 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order === 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'id desc';
        }
        this.getMessageDetails();
      },
      showSelectTagsForSearchDialog() {
        const obj = {
          projectId: this.projectId
        }
        this.readTags(obj);
        this.selectTagsForSearchDialog = true;
      },
      cancelSelectTagsForSearch() {
        this.searchObj.tags = [];
        this.selectTagsForSearchDialog = false;
        this.getMessageDetails();
      },
      showTestCaseTagsDialog() {
        this.testCaseTag.name = '';
        this.testCaseTag.alias = [];
        this.testCaseTagsDialog = true;
        this.readTags();
      },
      changeTestCaseTag(val) {
        const self = this;
        this.getSelectTagsForTestCase.find(function (tag) {
          if (tag.label === val[0]) {
            self.editTestCaseTagData = tag.value;
          }
        });
        this.testCaseTag.name = val[0];
      },
      addTestCaseTagSubmit(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.testCaseTag.name
            };
            this.addTags([obj]).then((res) => {
              this.readTags();
              this.testCaseTag.name = '';
            });
          }
        });
      },
      updateTestCaseTagSubmit(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.editTestCaseTagData.id,
              name: this.testCaseTag.name
            };
            this.updateTags([obj]).then((res) => {
              this.readTags();
              this.testCaseTag.name = '';
              this.testCaseTag.alias = [];
            });
          }
        });
      },
      handleClose(tag) {
        this.testCaseTag.name = '';
        const obj = {
          tagId: tag.value.id
        };
        this.countRemoveTagsForTestCase(obj).then((res) => {
          this.$confirm(this.lang.dialog.title.delete_tag + ' ' + '<i style="color: red;">' + tag.label + '</i>' + ' ' + this.lang.dialog.title.association + ' ' + '<i style="color: red;">' + res.metadata.count + '</i>' + ' ' + this.lang.dialog.title.delete_tag_continue, this.lang.dialog.title.delete_tag, {
            confirmButtonText: this.lang.operator.confirm,
            cancelButtonText: this.lang.operator.cancel,
            type: 'warning',
            dangerouslyUseHTMLString: true
          }).then(() => {
            const obj = {
              id: tag.value.id
            };
            this.removeTags(obj).then((res) => {
              this.readTags();
              this.testCaseTag.name = '';
              this.testCaseTag.alias = [];
            });
          }).catch(() => {
            this.$message({
              type:'info',
              message: this.lang.operator.undelete
            });
          });
        })
      },
      getSearchPaginationModel(val, reset) {
        if (reset) {
          this.searchObj.tags = [];
          this.searchObj.logic = false;
        }
        this.queryObj = val;
        this.getMessageDetails();
      }
    },
    created: function () {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
      const project = {
        id: this.projectId
      };
      this.readProjectFormessage(project).then((res) => {
        this.projectMessage = res.data[0];
      }, (err) => {
        console.log(err);
      });
    }
  };
</script>

