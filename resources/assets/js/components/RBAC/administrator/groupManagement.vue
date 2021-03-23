<template>
  <div class="rbac_content">
    <panel-pagination :lang="lang" :total="total" @search="getSearchPaginationModel">
      <template v-slot:title>{{ lang.breadcrumb.group_manage }}</template>
      <template v-slot:operation>
        <template v-if="roleRule.add_roles">
          <el-button plain class="button_text_table" @click="showAddRoleDialog" size="mini">{{ lang.operator.new }}</el-button>
        </template>
      </template>
      <template v-slot:table>
        <el-table
          :data="getRoles.data"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          style="width: 100%; margin: 10px 0px 5px;">
          <el-table-column
            :label="lang.table.id"
            align="left"
            prop="id"
            sortable="custom"
            show-overflow-tooltip
            width="100">
          </el-table-column>
          <el-table-column
            prop="name"
            align="left"
            sortable="custom"
            show-overflow-tooltip
            :label="lang.table.group_name">
          </el-table-column>
         <!--  <el-table-column
            prop="guard_name"
            align="left"
            show-overflow-tooltip
            label="Guard">
          </el-table-column> -->
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
              <el-button size="mini" @click="showRoleUsersAndRolesMessage(scope.row)" type="text">{{ lang.table.click_for_detail }}</el-button>
            </template>
          </el-table-column>
          <el-table-column
            prop="created_at"
            align="left"
            show-overflow-tooltip
            :label="lang.table.create_at">
          </el-table-column>
          <template v-if="roleRule.edit_roles || roleRule.delete_roles">
            <el-table-column
              align="left"
              show-overflow-tooltip
              width="150"
              :label="lang.table.operating">
              <template slot-scope="scope">
                <template v-if="roleRule.edit_roles">
                  <el-button class="button_text_table" @click="Navigation(scope.row)" size="mini">{{lang.operator.config}}</el-button>
                  <el-button class="button_text_table" @click="showEditRoleDialog(scope.row)" size="mini">{{lang.operator.edit}}</el-button>
                </template>
                <template v-if="roleRule.delete_roles">
                  <el-button class="button_text_table" @click="removeRole(scope.row)" size="mini">{{lang.operator.delete}}</el-button>
                </template>
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </panel-pagination>

    <el-dialog :title="lang.dialog.title.add" :close-on-click-modal="false"  :visible.sync="newRoleDialog">
      <el-form :model="role" :rules="paramValidation" ref="role" label-width="150px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.label.group_name" prop="name">
          <el-input size="small" clearable v-model.trim="role.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" clearable :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="role.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="newRoleDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitRole('role')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :title="lang.dialog.title.edit" :close-on-click-modal="false"  :visible.sync="editRoleDialog">
      <el-form :model="editRole" :rules="paramEditValidation" ref="editRole" label-width="150px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.label.group_name" clearable prop="name">
          <el-input size="small" v-model.trim="editRole.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" clearable :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="editRole.comment"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="editRoleDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitEditRole('editRole')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.dialog.title.group_details" :close-on-click-modal="false" :visible.sync="rolesAssignmentDetailsDialog">
      <div class="infoBody">
        <div class="infoContent">{{ lang.dialog.title.have_group }} <i style="color: #463927;">{{ roleName }}</i> {{ lang.dialog.title.details_of_group }}:
        </div>
        <el-row :gutter="30">
          <el-col :span="4" class="infoLabel">{{ lang.dialog.label.user }}:</el-col>
          <el-col :span="18" class="infoContent">
            <i style="color: teal;">{{ userStr }}</i>
          </el-col>
        </el-row>
        <el-row :gutter="30">
          <el-col :span="4" class="infoLabel">{{ lang.dialog.label.permission }}:</el-col>
          <el-col :span="18" class="infoContent">
            <i style="color: #821318;">{{ permissionStr }}</i>
          </el-col>
        </el-row>
      </div>
      <div slot="footer" class="dialog-footer">
        <el-button @click="rolesAssignmentDetailsDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.dialog.title.open" :close-on-click-modal="false" :visible.sync="openNewPageDialog">
      <el-form label-width="0px" label-position="right" label-suffix=":">
        <el-form-item>
          <div style="display: flex;">
            <div style="flex: 1; text-align: center;">
              <el-button type="primary" size="medium" round @click="NavigationToGroupUsersPage">{{ lang.operator.group_user }}</el-button>
            </div>
            <div style="flex: 1; text-align: center;">
              <el-button class="el_button_open" type="success" size="medium" round @click="NavigationToGroupPermissionsPage">{{ lang.operator.group_permission }}</el-button>
            </div>
          </div>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="openNewPageDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  props: ['message'],
  data() {
    var validatorRoleName = (rule, value, callback) => {
      const obj = {
        name: value
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        this.validateRoleName(obj).then((res) => {
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
    var validatorEditRoleName = (rule, value, callback) => {
      const obj = {
        name: value
      };
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        if (value != this.updatePreName) {
          this.validateRoleName(obj).then((res) => {
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
      roleRule: {},
      lang: {},
      orderBy: 'id desc',
      total: 0,
      queryObj: {
        name: '',
        pageSize: 25,
        pageNumber: 1
      },
      newRoleDialog: false,
      role: {
        name: '',
        comment: ''
      },
      paramValidation: {
        name: [{required: true, validator: validatorRoleName, trigger: 'blur'}],
        comment: [{required: true, validator: validatorParams, trigger: 'blur'}]
      },
      roleName: '',
      userStr: '',
      permissionStr: '',
      rolesAssignmentDetailsDialog: false,
      editRoleDialog: false,
      editRole: {
        id: null,
        name: '',
        comment: ''
      },
      paramEditValidation: {
        name: [{required: true, validator: validatorEditRoleName, trigger: 'blur'}],
        comment: [{required: true, validator: validatorParams, trigger: 'blur'}]
      },
      updatePreName: '',
      openNewPageDialog: false,
      groupId: null,
    }
  },
  watch: {
    getRoles: function() {
      this.total = this.getRoles.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getRoles'])
  },
  methods: {
    ...mapActions(['readRoles', 'addRole', 'updateRole', 'deleteRole', 'readRoleAboutUserAndPermissionMessage', 'validateRoleName']),
    Navigation (row, event) {
      this.groupId = row.id;
      this.openNewPageDialog = true;
    },
    NavigationToGroupPermissionsPage () {
      window.location.href = '/RBAC/administrator/group/' + this.groupId + '/permissions';
    },
    NavigationToGroupUsersPage() {
      window.location.href = '/RBAC/administrator/group/' + this.groupId + '/users';
    },
    getMessageDetails() {
      const obj = {};
      for (var i in this.queryObj) {
        if (this.queryObj[i] !== '') {
          obj[i] = this.queryObj[i];
        }
      }
      obj.orderBy = this.orderBy;
      this.readRoles(obj);
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
    showRoleUsersAndRolesMessage(row) {
      this.roleName = row.name;
      this.readRoleAboutUserAndPermissionMessage(row).then((res) => {
        this.userStr = res.data.users.map((user) => { return user.name }).join(',');
        this.permissionStr = res.data.permissions.map((permissions) => { return permissions.name }).join(',');
        this.rolesAssignmentDetailsDialog = true;
      }, (err) => {
        console.log(err);
      })
    },
    showAddRoleDialog() {
      this.role.name = '';
      this.role.comment = '';
      this.newRoleDialog = true;
    },
    submitRole(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            name: this.role.name,
            comment: this.role.comment
          };
          this.addRole(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
          this.newRoleDialog = false;
        } else {
          return false;
        }
      });
    },
    showEditRoleDialog(row) {
      this.updatePreName = row.name;
      this.editRole.id = row.id;
      this.editRole.name = row.name;
      this.editRole.comment = row.comment;
      this.editRoleDialog = true;
    },
    submitEditRole(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            id: this.editRole.id,
            name: this.editRole.name,
            comment: this.editRole.comment
          };
          this.updateRole(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
          this.editRoleDialog = false;
        } else {
          return false;
        }
      });
    },
    removeRole(row) {
      this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning',
        dangerouslyUseHTMLString: true
      }).then(() => {
        this.deleteRole(row).then((res) => {
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
    this.roleRule = message.permissions;
    this.lang = message.lang;
  },
  mounted() {
    this.getMessageDetails();
  }
};
</script>