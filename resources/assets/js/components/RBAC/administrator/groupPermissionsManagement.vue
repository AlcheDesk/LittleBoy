<template>
  <div class="rbac_content">
    <panel-pagination :lang="lang" :total="total" @search="getSearchPaginationModel">
      <template v-slot:title>{{ lang.breadcrumb.group_permission }}</template>
      <template v-slot:operation>
        <template v-if="permissionRule.add_group_permissions">
          <el-button plain class="button_text_table" @click="showAddGroupPermissionDialog" size="mini">{{ lang.operator.new }}</el-button>
        </template>
      </template>
      <template v-slot:table>
        <el-table
          :data="getGroupPermissions.data"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          style="width: 100%; margin: 10px 0px 5px;">
          <el-table-column
            prop="id"
            align="left"
            :label="lang.table.id"
            sortable="custom"
            show-overflow-tooltip
            width="100">
          </el-table-column>
          <el-table-column
            prop="name"
            align="left"
            sortable="custom"
            show-overflow-tooltip
            :label="lang.table.group_permission_name">
          </el-table-column>
          <el-table-column
            prop="comment"
            align="left"
            show-overflow-tooltip
            :label="lang.table.comment">
          </el-table-column>
          <el-table-column
            prop="created_at"
            align="left"
            show-overflow-tooltip
            :label="lang.table.create_at">
          </el-table-column>
          <el-table-column
            align="left"
            show-overflow-tooltip
            width="100"
            :label="lang.table.operating">
            <template slot-scope="scope">
              <template v-if="permissionRule.delete_group_permissions">
                <el-button class="button_text_table" @click="removePermission(scope.row)" size="mini">{{lang.operator.delete}}</el-button>
              </template>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </panel-pagination>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false"  :visible.sync="newGroupPermissionDialog">
      <el-form :model="groupPermission" :rules="paramValidation" ref="groupPermission" label-width="150px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.label.group_permission_name" prop="name">
          <el-select v-model="groupPermission.name" clearable multiple value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_permission">
            <el-option
              v-for="item in getSelectPermissions"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              <span style="float: left">{{ item.label }}</span>
              <span style="float: right; color: #8492a6; font-size: 13px">{{ item.value.comment }}</span>
              </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="newGroupPermissionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitGroupPermission('groupPermission')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  props: ['message'],
  data() {
    return {
      permissionRule: {},
      lang: {},
      total: 0,
      queryObj: {
        name: '',
        pageSize: 25,
        pageNumber: 1
      },
      orderBy: 'id desc',
      newGroupPermissionDialog: false,
      groupPermission: {
        name: []
      },
      paramValidation: {
        name: [{required: true}, {type: 'regexp', pattern: '/^[a-zA-Z0-9]+/', trigger: 'blur'}]
      }
    }
  },
  watch: {
    getGroupPermissions: function() {
      this.total = this.getGroupPermissions.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getGroupPermissions', 'getSelectPermissions'])
  },
  methods: {
    ...mapActions(['readGroupPermissions', 'associateGroupAndPermissions', 'deleteGroupPermissionAssociate', 'readPermissions']),
    getMessageDetails() {
      const obj = {
        id: window.location.pathname.split('/')[4],
      };
      obj.data = {};
      for (var i in this.queryObj) {
        if (this.queryObj[i] !== '') {
          obj.data[i] = this.queryObj[i];
        }
      }
      obj.data.orderBy = this.orderBy;
      this.readGroupPermissions(obj);
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
    showAddGroupPermissionDialog() {
      this.groupPermission.name = [];
      const obj = {
        id: window.location.pathname.split('/')[4]
      };
      this.readPermissions(obj);
      this.newGroupPermissionDialog = true;
    },
    submitGroupPermission(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const groupPermissionIds = this.groupPermission.name.map((item) => { return item.id });
          const obj = {
            id: window.location.pathname.split('/')[4]
          };
          obj.data = {
            ids: groupPermissionIds
          }
          this.associateGroupAndPermissions(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
          this.newGroupPermissionDialog = false;
        } else {
          return false;
        }
      });
    },
    removePermission(row) {
      this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning',
        dangerouslyUseHTMLString: true
      }).then(() => {
        const obj = {
          gid: window.location.pathname.split('/')[4],
          pid: row.id
        }
        this.deleteGroupPermissionAssociate(obj).then((res) => {
          this.getMessageDetails();
        }, (err) => {
          console.log(err);
        })
      }).catch(() => {
        this.$message({
          type:'info',
          message: this.lang.operator.undelete
        });
      });
    },
    getSearchPaginationModel(val) {
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
