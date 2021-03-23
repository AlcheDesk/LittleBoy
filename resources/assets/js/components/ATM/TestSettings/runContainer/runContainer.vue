<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.run_list }}
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_run_sets">
          <add :lang="lang" @runListAddDone="getMessageDetails"></add>
        </template>
        <template v-if="permissionRule.view_run_sets_tags">
          <el-button class="button_text_table el_button_open" @click="showRunListAliasDialog">{{ lang.operator.alias_management }}</el-button>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-row :gutter="20" class="tag_bar">
          <el-col :span="4" class="tags_select">
            <div class="tags_label">{{lang.table.alias}}:</div>
            <div class="tags_content">
              <el-button size="mini" @click="showSelectAliasForSearchDialog" class="tag_button">{{lang.operator.select_alias}}</el-button>
            </div>
          </el-col>
          <el-col :span="20" class="tags_show">
            <el-tag
              v-for="tag in searchObj.aliases"
              :key="tag.name"
              size="small"
              style="margin-right: 8px;">
              {{tag}}
            </el-tag>
          </el-col>
        </el-row>
        <el-table
          :data="getRunContainer.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="navigationToRunListTestCases">
          <el-table-column
            :label="lang.table.id"
            prop="id"
            align="left"
            sortable="custom"
            :resizable="true"
            width="100">
          </el-table-column>
          <el-table-column
            :label="lang.table.name"
            prop="name"
            sortable="custom"
            align="left"
            :resizable="true"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <i class="icon_l"></i>
              {{scope.row.name}}
            </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.testcase_number"
            align="left"
            :resizable="true"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{ scope.row.testCases.length || 0 }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            sortable="custom"
            prop="createdAt"
            :label="lang.table.create_at"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.table.alias"
            :resizable="true"
            align="left"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <el-tag
                :key="tag || tag.name"
                size="small"
                style="margin-right: 8px;"
                v-for="tag in scope.row.aliases">
                {{tag.name ? tag.name : tag}}
              </el-tag>
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            sortable="custom"
            prop="priority"
            :label="lang.table.priority"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.comment"
            prop="comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_run_sets || permissionRule.edit_run_sets">
            <el-table-column
              :label="lang.table.operating"
              :resizable="true"
              align="left"
              width="150">
              <template slot-scope="scope">
                <el-button class="button_text_table" @click="downLoadRunSet(scope)">{{lang.operator.export}}</el-button>
                <template v-if="permissionRule.delete_run_sets">
                  <el-button class="button_text_table" @click="removeRunContainer(scope)">{{lang.operator.delete}}</el-button>
                </template>
                <template v-if="permissionRule.edit_run_sets">
                  <edit
                    :lang="lang"
                    :row="scope.row"
                    @runListEditDone="getMessageDetails">
                  </edit>
                </template>
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </search-pagination>

    <el-dialog  :close-on-click-modal="false" :title="lang.operator.alias_management" :visible.sync="runListAliasDialog" :show-close="false" :append-to-body="true">
      <el-form :model="runListAlias" :rules="paramValidationAlias" ref="runListAlias" label-width.first="100px" label-position="right" label-suffix=":" style="text-align: left;">
        <el-form-item :label="lang.table.name" prop="name">
          <div style="display: flex;">
            <div style="flex: 8">
              <el-input  :placeholder="lang.dialog.placeholder.enter_name" size="small" v-model.trim="runListAlias.name"></el-input>
            </div>
            <div style="flex: 2; text-align: center;">
              <template v-if="!RunListAliasFlag">
                <template v-if="permissionRule.add_run_sets_tags">
                  <el-button size="mini" key="runListAliasAdd" class="el_button_open" @click="addRunListAliasSubmit('runListAlias')">{{lang.operator.new}}</el-button>
                </template>
              </template>
              <template v-else>
                <template v-if="permissionRule.edit_run_sets_tags">
                  <el-button size="mini" key="runListAliasEdit" class="el_button_open" @click="updateRunListAliasSubmit('runListAlias')">{{lang.operator.edit}}</el-button>
                </template>
              </template>
            </div>
          </div>
        </el-form-item>
        <el-form-item>
          <el-checkbox-group
            size="mini"
            :max="1"
            @change="changeRunListAliasTag"
            v-model="runListAlias.aliases">
            <el-checkbox style="color: black; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" border :max="1" v-for="tag in getSelectRunListAlias" :label="tag.label" :key="tag.label">
              <template v-if="permissionRule.delete_run_sets_tags">
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
        <el-button @click="runListAliasDialog = false">{{lang.operator.cancel}}</el-button>
      </div>
    </el-dialog>


    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.select_alias" :visible.sync="selectAliasForSearchDialog" :show-close="false" :append-to-body="true">
      <el-form :model="searchObj" label-width="0px" label-position="right" label-suffix=":" style="text-align: left;">
        <el-form-item>
          <el-checkbox-group
            size="mini"
            :max="10"
            v-model="searchObj.aliases">
            <el-checkbox style="color: black;" border v-for="tag in getSelectRunListAlias" :label="tag.label" :key="tag.label">{{tag.label}}</el-checkbox>
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
  import Add from './Add'
  import Edit from './Edit'


  export default {
    props: ['message'],
    data() {
      var validatorRunListAlias = (rule, value, callback) => {
        const self = this;
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        };
        if (this.runListAlias.aliases.length) {
          const flag1 = this.getSelectRunListAlias.find(function (tag) {
            if (tag.label === value) {
              self.runListAlias.aliases.push(tag.label);
              return true;
            }
          });
          if (flag1) {
            return callback(new Error(this.lang.validator.name.exist));
          } else {
            this.runListAlias.aliases = [];
            return callback();
          }
        } else {
          const flag = this.getSelectRunListAlias.find(function (tag) {
            if (tag.label === value) {
              self.runListAlias.aliases.push(tag.label);
              return true;
            }
          });
          if (flag) {
            return callback(new Error(this.lang.validator.name.exist));
          } else {
            this.runListAlias.aliases = [];
            return callback();
          }
        }
      }
      return {
        permissionRule: {},
        lang: {},
        total: 0,
        searchObj: {
          aliases: [],
          logic: false
        },
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        orderBy: 'createdAt desc',
        runListAliasDialog: false,
        runListAlias: {
          name: '',
          aliases: []
        },
        paramValidationAlias: {
          name: [{type: 'array', required: true, validator: validatorRunListAlias, trigger: 'blur'}]
        },
        editRunListAliasData: {},
        selectAliasForSearchDialog: false,
        RunListAliasFlag: false
      }
    },
    computed: {
      ...mapGetters(['getRunContainer', 'getSelectRunListAlias'])
    },
    watch: {
      getRunContainer: function() {
        this.total = this.getRunContainer.metadata.count;
      }
    },
    components: { Add, Edit },
    methods: {
      ...mapActions(['readRunContainer', 'deleteRunContainer', 'readRunListAlias', 'addRunListAlias', 'updateRunListAlias', 'removeRunListAlias', 'countRemoveAliasForRunList']),
    downLoadRunSet(scope) {
      const url = 'http://' + window.location.host + '/atm/export/runSet/' + scope.row.id;
      window.open(url);
      
    },
      navigationToRunListTestCases(row) {
          window.location.href = '/atm/TestSetting/RunList/' + row.id + '/TestCase?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.searchObj.aliases.join(',') ? obj.aliases = this.searchObj.aliases.join(',') : null;
        this.searchObj.aliases.join(',') ? obj.logic = this.searchObj.logic : null;
        this.selectAliasForSearchDialog = false;
        this.readRunContainer(obj);
      },
      removeRunContainer(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = scope.row;
          this.deleteRunContainer(obj).then((res) => {
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
      showRunListAliasDialog() {
        this.runListAlias.name = '';
        this.runListAlias.aliases = [];
        this.runListAliasDialog = true;
        this.readRunListAlias();
      },
      changeRunListAliasTag(val) {
        const self = this;
        if (val.length) {
          this.getSelectRunListAlias.find(function (tag) {
            if (tag.label === val[0]) {
              self.editRunListAliasData = tag.value;
            }
          });
          this.runListAlias.name = val[0];
          this.RunListAliasFlag = true;
        } else {
          this.RunListAliasFlag = false;
          this.runListAlias.name = '';
        }
      },
      addRunListAliasSubmit(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.runListAlias.name
            };
            this.addRunListAlias([obj]).then((res) => {
              this.readRunListAlias();
              this.runListAlias.name = '';
              this.RunListAliasFlag = false;
            });
          }
        });
      },
      updateRunListAliasSubmit(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.editRunListAliasData.id,
              name: this.runListAlias.name
            };
            this.updateRunListAlias([obj]).then((res) => {
              this.readRunListAlias();
              this.runListAlias.name = '';
              this.runListAlias.aliases = [];
              this.RunListAliasFlag = false;
            });
          }
        });
      },
      handleClose(tag) {
        this.runListAlias.name = '';
        const obj = {
          aliasId: tag.value.id
        };
        this.countRemoveAliasForRunList(obj).then((res) => {
          this.$confirm(this.lang.dialog.title.delete_tag + ' ' + '<i style="color: red;">' + tag.label + '</i>' + ' ' + this.lang.dialog.title.association + ' ' + '<i style="color: red;">' + res.metadata.count + '</i>' + ' ' + this.lang.dialog.title.delete_tag_continue, this.lang.dialog.title.delete_tag, {
            confirmButtonText: this.lang.operator.confirm,
            cancelButtonText: this.lang.operator.cancel,
            type: 'warning',
            dangerouslyUseHTMLString: true
          }).then(() => {
            const obj = {
              id: tag.value.id
            };
            this.removeRunListAlias(obj).then((res) => {
              this.readRunListAlias();
              this.runListAlias.name = '';
              this.runListAlias.aliases = [];
              this.RunListAliasFlag = false;
            });
          }).catch(() => {
            this.$message({
              type:'info',
              message: this.lang.operator.undelete
            });
          });
        })
      },
      showSelectAliasForSearchDialog() {
        this.readRunListAlias();
        this.selectAliasForSearchDialog = true;
      },
      cancelSelectTagsForSearch() {
        this.searchObj.aliases = [];
        this.selectAliasForSearchDialog = false;
      },
      getSearchPaginationModel(val, reset) {
        if (reset) {
          this.searchObj.aliases = [];
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


