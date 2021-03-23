<template>
  <div class="rbac_content">
    <panel-pagination :lang="lang" :total="total" @search="getSearchPaginationModel">
      <template v-slot:title>{{ lang.breadcrumb.system_auth_manage }}</template>
      <template v-slot:operation>
        <template v-if="permissionRule.add_permissions">
          <el-button plain class="button_text_table" @click="showAddPermissionDialog" size="mini">{{ lang.operator.new }}</el-button>
        </template>
      </template>
      <template v-slot:table>
        <el-table
          :data="getPermissions.data"
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
            :label="lang.table.permission_name">
          </el-table-column>
          <el-table-column
            prop="comment"
            align="left"
            show-overflow-tooltip
            :label="lang.table.comment">
          </el-table-column>
          <el-table-column
            align="left"
            show-overflow-tooltip
            :label="lang.table.distribution_details">
            <template slot-scope="scope">
              <el-button size="mini" @click="showPermissionUsersAndRolesMessage(scope.row)" type="text">{{ lang.table.click_for_detail }}</el-button>
            </template>
          </el-table-column>
          <el-table-column
            prop="created_at"
            align="left"
            show-overflow-tooltip
            :label="lang.table.create_at">
          </el-table-column>
          <template v-if="permissionRule.edit_permissions || permissionRule.delete_permissions">
            <el-table-column
              align="left"
              show-overflow-tooltip
              width="100"
              :label="lang.table.operating">
              <template slot-scope="scope">
                <template v-if="permissionRule.edit_permissions && scope.row.name !== 'edit_permissions' && scope.row.name !== 'delete_permissions'">
                  <el-button class="button_text_table" @click="showEditPermissionDialog(scope.row)" size="mini">{{lang.operator.edit}}</el-button>
                </template>
                <template v-if="permissionRule.delete_permissions && scope.row.name !== 'delete_permissions' && scope.row.name !== 'edit_permissions'">
                  <el-button class="button_text_table" @click="removePermission(scope.row)" size="mini">{{lang.operator.delete}}</el-button>
                </template>
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </panel-pagination>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false"  :visible.sync="newPermissionDialog">
      <el-form :model="permission" :rules="paramValidation" ref="permission" label-width="150px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.label.permission_name" prop="name">
          <el-input size="small" clearable v-model.trim="permission.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" clearable :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="permission.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="newPermissionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitPermission('permission')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.dialog.title.edit" :close-on-click-modal="false"  :visible.sync="editPermissionDialog">
      <el-form :model="editPermission" :rules="paramEditValidation" ref="editPermission" label-width="150px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.label.permission_name" prop="name">
          <el-input size="small" clearable v-model.trim="editPermission.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" clearable :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="editPermission.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="editPermissionDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitEditPermission('editPermission')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.dialog.title.permission_details" :close-on-click-modal="false" :visible.sync="permissionsAssignmentDetailsDialog">
      <div class="infoBody">
        <div class="infoContent">{{ lang.dialog.title.have_permission }} <i style="color: #463927;">{{ permissionName }}</i> {{ lang.dialog.title.details_of_permission }}:
        </div>
        <el-row :gutter="30">
          <el-col :span="4" class="infoLabel">{{ lang.dialog.label.user }}:</el-col>
          <el-col :span="18" class="infoContent">
            <i style="color: teal;">{{ userStr }}</i>
          </el-col>
        </el-row>
        <el-row :gutter="30">
          <el-col :span="4" class="infoLabel">{{ lang.dialog.label.group }}:</el-col>
          <el-col :span="18" class="infoContent">
            <i style="color: #821318;">{{ roleStr }}</i>
          </el-col>
        </el-row>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="permissionsAssignmentDetailsDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  props: ['message'],
  data() {
    var validatorPermissionName = (rule, value, callback) => {
      const obj = {
        name: value
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        this.validatePermissionName(obj).then((res) => {
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
    var validatorEditPermissionName = (rule, value, callback) => {
      const obj = {
        name: value
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        if (value != this.updatePreName) {
          this.validatePermissionName(obj).then((res) => {
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
    var validatorParams = (rule, value, callback) => {
      if (rule.required && !value) {
        return callback(new Error(this.lang.dialog.placeholder.enter_comment));
      } else {
        return callback();
      }
    };
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
      newPermissionDialog: false,
      permission: {
        name: '',
        comment: ''
      },
      paramValidation: {
        name: [{required: true, validator: validatorPermissionName, trigger: 'blur'}],
        comment: [{required: true, validator: validatorParams, trigger: 'blur'}]
      },
      permissionName: '',
      userStr: '',
      roleStr: '',
      permissionsAssignmentDetailsDialog: false,
      editPermissionDialog: false,
      editPermission: {
        id: null,
        name: '',
        comment: ''
      },
      paramEditValidation: {
        name: [{required: true, validator: validatorEditPermissionName, trigger: 'blur'}],
        comment: [{required: true, validator: validatorParams, trigger: 'blur'}]
      },
      updatePreName: ''
    }
  },
  watch: {
    getPermissions: function() {
      this.total = this.getPermissions.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getPermissions'])
  },
  methods: {
    ...mapActions(['readPermissions', 'addPermission', 'updatePermission', 'deletePermission', 'readPermissionUserAndRoleMessage', 'validatePermissionName']),
    getMessageDetails() {
      const obj = {};
      for (var i in this.queryObj) {
        if (this.queryObj[i] !== '') {
          obj[i] = this.queryObj[i];
        }
      }
      obj.orderBy = this.orderBy;
      this.readPermissions(obj);
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
    showPermissionUsersAndRolesMessage(row) {
      this.permissionName = row.name;
      this.readPermissionUserAndRoleMessage(row).then((res) => {
        this.userStr = res.data.users.map((user) => { return user.name }).join(',');
        this.roleStr = res.data.roles.map((role) => { return role.name }).join(',');
        this.permissionsAssignmentDetailsDialog = true;
      }, (err) => {
        console.log(err);
      })
    },
    showAddPermissionDialog() {
      this.permission.name = '';
      this.permission.comment = '';
      this.newPermissionDialog = true;
    },
    submitPermission(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            name: this.permission.name,
            comment: this.permission.comment
          };
          this.addPermission(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
          this.newPermissionDialog = false;
        } else {
          return false;
        }
      });
    },
    showEditPermissionDialog(row) {
      this.updatePreName = row.name;
      this.editPermission.id = row.id;
      this.editPermission.name = row.name;
      this.editPermission.comment = row.comment;
      this.editPermissionDialog = true;
    },
    submitEditPermission(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.editPermission.id,
            name: this.editPermission.name,
            comment: this.editPermission.comment
          };
          this.updatePermission(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
          this.editPermissionDialog = false;
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
        this.deletePermission(row).then((res) => {
          console.log(res);
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
