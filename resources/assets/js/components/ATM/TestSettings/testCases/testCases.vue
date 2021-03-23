<template>
  <div>
    <project-container>
      <div slot="toolbar">
        <project-tool-bar>
          <div slot="breadcrumb">
            {{ lang.breadcrumb.test_case_lib }}
          </div>
          <div slot="name">
            {{ lang.breadcrumb.test_case_list }}
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
              ref="multipleTable"
              :data="getTestCases.data"
              row-class-name="row_css"
              :row-key="setRowKey"
              :default-sort="{prop: 'name', order: 'descending'}"
              @sort-change="sortChange"
              @row-dblclick="NavigationToCaseInstruction"
              @selection-change="handleSelectionChange"
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
              <el-table-column
                :label="lang.table.project"
                :resizable="true"
                align="left"
                sortable="custom"
                prop="name"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <i class="icon_p"></i>
                  {{scope.row.projectName}}
                </template>
              </el-table-column>
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
                    {{tag.name}}
                  </el-tag>
                </template>
              </el-table-column>
              <template v-if="permissionRule.delete_test_cases || permissionRule.edit_test_cases">
                <el-table-column
                  :label="lang.table.operating"
                  :resizable="true"
                  align="left">
                  <template slot-scope="scope">
                    <template v-if="permissionRule.edit_test_cases">
                      <edit
                        :lang="lang"
                        :row="scope.row"
                        @testCaseEditDone="getMessageDetails">
                      </edit>
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
                      <el-button class="button_text_table" @click="removeProjectTestCase(scope)">{{lang.operator.delete}}</el-button>
                    </template>
                  </template>
                </el-table-column>
              </template>
            </el-table>
          </template>
        </search-pagination>
      </div>
    </project-container>

    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.select_tag" :visible.sync="selectTagsForSearchDialog" :show-close="false">
      <el-form :model="searchObj" label-width="0px" label-position="right" label-suffix=":" style="text-align: left;">
        <el-form-item>
          <el-checkbox-group
            size="mini"
            :max="10"
            v-model="searchObj.tags">
            <el-checkbox style="color: black;" border v-for="(tag, index) in getSelectTagsForTestCase" :label="tag.label" :key="tag.label + tag.value.id">{{tag.label}}</el-checkbox>
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
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import Edit from '../projectLib/testCase/Edit.vue'
  import testcaseToRunlist from '../projectLib/testCase/testCaseToRunList.vue'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        total: 0,
        searchObj: {
          tags: [],
          logic: false
        },
        orderBy: 'name desc',
        deleteTagIds: '',
        selectTagsForSearchDialog: false,
        multipleSelection: [],
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
      ...mapGetters(['getTestCases', 'getSelectTagsForTestCase'])
    },
    components: { testcaseToRunlist, Edit },
    watch: {
      getTestCases: function() {
        this.total = this.getTestCases.metadata.count;
      }
    },
    methods: {
      ...mapActions(['validateTestCaseDelete', 'readTestCases', 'deleteProjectTestCase', 'markProjectTestCase', 'readTags', 'deleteTagsForTestCase', 'editTagsForTestCase']),
      setRowKey(row) {
        return row.name + row.id;
      },
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      clearMultipleSelect() {
        this.$refs.multipleTable.clearSelection();
      },
      NavigationToCaseInstruction(row) {
        window.open('/atm/TestSetting/Project/' + row.projectId + '/TestCase/' + row.id + '/Instruction/?page=1+25');
        localStorage.setItem('caseCurrentPage', 1);
        localStorage.setItem('caseCurrentSize', 25);
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.searchObj.tags.join(',') ? obj.tags = this.searchObj.tags.join(',') : null;
        this.searchObj.tags.join(',') ? obj.logic = this.searchObj.logic : null;
        this.selectTagsForSearchDialog = false;
        this.readTestCases(obj);
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
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'createdAt desc';
        }
        this.getMessageDetails();
      },
      showSelectTagsForSearchDialog() {
        this.readTags();
        this.selectTagsForSearchDialog = true;
      },
      cancelSelectTagsForSearch() {
        this.searchObj.tags = [];
        this.selectTagsForSearchDialog = false;
        this.getMessageDetails();
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
      this.getMessageDetails();
    }
  };
</script>

