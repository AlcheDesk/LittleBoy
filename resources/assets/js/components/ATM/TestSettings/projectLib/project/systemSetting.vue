<template>
  <div>    
    <el-row :gutter="20" style="background:#fff;">
      <el-col :span="5" style="height: 45px; padding: 0px; background-color: #5fa683;">
        <div style="padding: 12px; text-align: left; margin-left: 30px;">{{ lang.breadcrumb.system_set }}</div>
      </el-col>
    </el-row>
    <div>
      <div style="height: 55px; display: block;">
        <el-row :gutter="20">
          <el-col :span="4">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">key:</div>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-input placeholder="请输入key" @keyup.enter.native="searchClick" v-model.trim="searchObj.key" size="mini"></el-input>
              </div>
            </div>
          </el-col>
          <el-col :span="4">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">value：</div>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-input placeholder="请输入value" @keyup.enter.native="searchClick" v-model.trim="searchObj.value" size="mini"></el-input>
              </div>
            </div>
          </el-col>
          <el-col :span="4">
            <div style="display: inline-block; float: left; height: auto; margin-left: 10px; padding: 18px 5px 0px;">
              <el-button size="mini" @click="searchClick" style="padding: 5px; float: left;">{{lang.operator.searching}}</el-button>
            </div>
            <div style="display: inline-block; float: left; height: auto; margin-left: 10px; padding: 18px 5px 0px;">
              <el-button size="mini" @click="resetSearch" style="padding: 5px; float: left;">{{lang.operator.reset}}</el-button>
            </div>
          </el-col>
        </el-row>
      </div>
      <el-table
        :data="getSystemSetting.data"
        style="width: 100%"
        border>
        <el-table-column
          :resizable="true"
          header-align="center"
          label="key"
          align="center"
          prop="key">
        </el-table-column>
        <el-table-column
          :resizable="true"
          header-align="center"
          label="value"
          align="center"
          prop="value"
          show-overflow-tooltip>
        </el-table-column>
        <template v-if="permissionRule.edit_system_setting">
          <el-table-column
            :resizable="true"
            width='100'
            :label="lang.table.operating"
            header-align="center">
            <template slot-scope="scope">
              <el-button class="button_text_table el_button_edit" @click="showUpdateSystemSettingDialog(scope)">{{lang.operator.edit}}</el-button>
            </template>
          </el-table-column>
        </template>
      </el-table>
      <el-pagination
        @current-change="handleCurrentChange"
        :current-page="pagination.currentPage"
        :page-size="pagination.sizePage"
        layout="total, prev, pager, next, jumper"
        :total="pagination.total"
        style="background-color: rgb(233, 235, 236);">
      </el-pagination>
    </div>

    <el-dialog  title="更新设置" :visible.sync="updateSystemSettingDialog">
      <el-form :model="systemSetting" :rules="paramValidation" ref="systemSetting" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item label="Value" prop="value">
          <el-input @keyup.enter.native="editSystemSetting('systemSetting')" placeholder="请输入Value" v-model.trim="systemSetting.value"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="updateSystemSettingDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editSystemSetting('systemSetting')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        systemSetting: {
          id: null,
          value: ''
        },
        updateSystemSettingDialog: false,
        paramValidation: {
          value: [{required: true, message: '请输入值', trigger: 'blur'}]
        },
        pagination: {
          currentPage: 1,
          sizePage: 25,
          total: 0
        },
        searchObj: {
          key: '',
          value: '',
        }
      }
    },
    computed: {
      ...mapGetters(['getSystemSetting'])
    },
    watch: {
      getSystemSetting: function() {
        this.pagination.total = this.getSystemSetting.metadata.count || this.getSystemSetting.data.length;
      }
    },
    methods: {
      ...mapActions(['readSystemSetting', 'updateSystemSetting']),
      searchClick() {
        const obj = {
          pageNumber: 1,
          pageSize: this.pagination.sizePage
        };
        for (var i in this.searchObj) {
          if (this.searchObj[i] != '') {
            obj[i] = this.searchObj[i];
          }
        }
        this.readSystemSetting(obj);
      },
      resetSearch() {
        this.searchObj = {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          status: ''
        };
        const obj = {
          pageNumber: 1,
          pageSize: this.pagination.sizePage
        }
        this.readSystemSetting(obj);
      },
      handleCurrentChange(val) {
        this.pagination.currentPage = val;
        const obj = {
          pageNumber: val,
          pageSize: this.pagination.sizePage
        }
        for (var i in this.searchObj) {
          if (this.searchObj[i] != '') {
            obj[i] = this.searchObj[i];
          }
        }
        this.readSystemSetting(obj);
      },
      showUpdateSystemSettingDialog(scope) {
        this.systemSetting.id = scope.row.id;
        this.systemSetting.value = scope.row.value;
        this.updateSystemSettingDialog = true;
      },
      editSystemSetting(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.systemSetting.id,
              value: this.systemSetting.value
            };
            this.updateSystemSetting([obj]).the((res) => {
              const obj = {
                pageNumber: this.pagination.currentPage,
                pageSize: this.pagination.sizePage
              }
              this.readSystemSetting(obj);
            }, (err) => {
              console.log(err);
            })
            this.updateSystemSettingDialog = false;
          } else {
            return false;
          }
        });
      }
    },
    created() {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
    },
    mounted() {
      const obj = {
        pageNumber: 1,
        pageSize: this.pagination.sizePage
      }
      this.readSystemSetting(obj);
    }
  };
</script>

<style scoped>
  .el-row {
    margin:  0px !important;
  }
</style>


