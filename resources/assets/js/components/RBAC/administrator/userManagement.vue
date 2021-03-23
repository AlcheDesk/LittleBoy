<template>
  <div class="rbac_content">
    <panel-pagination :lang="lang" :total="total" @search="getSearchPaginationModel">
      <template v-slot:title>{{ lang.breadcrumb.user_manage }}</template>
      <template v-slot:operation>
        <template v-if="userRule.add_users">
          <el-button plain class="button_text_table" @click="showAddUserDialog" size="mini">{{ lang.operator.new }}</el-button>
        </template>
      </template>
      <template v-slot:table>
        <el-table
          :data="getUsers.data"
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
            :label="lang.table.user_name">
          </el-table-column>
          <el-table-column
            prop="email"
            align="left"
            show-overflow-tooltip
            :label="lang.table.email">
          </el-table-column>
          <el-table-column
            align="left"
            show-overflow-tooltip
            :label="lang.table.distribution_details">
            <template slot-scope="scope">
              <template v-if="scope.row.account_active">
                <el-button size="mini" @click="showUserUsersAndUsersMessage(scope.row)" type="text">{{ lang.table.click_for_detail }}</el-button>
              </template>
            </template>
          </el-table-column>
          <el-table-column
            prop="created_at"
            align="left"
            show-overflow-tooltip
            :label="lang.table.create_at">
          </el-table-column>
          <template v-if="userRule.edit_users || userRule.delete_users">
            <el-table-column
              align="left"
              show-overflow-tooltip
              width="130"
              :label="lang.table.operating">
              <template slot-scope="scope">
                <template v-if="scope.row.account_active">
                  <template v-if="userRule.edit_users">
                    <el-button class="button_text_table" @click="jumpOperationRecord(scope.row)" size="mini">{{lang.operator.record}}</el-button>
                  </template>
                  <template v-if="userRule.delete_users">
                    <el-button class="button_text_table" @click="removeUser(scope.row)" size="mini">{{lang.operator.delete}}</el-button>
                  </template>
                </template>
                <template v-else>
                  <el-button class="button_text_table" @click="passUserApply(scope.row)" size="mini">{{lang.operator.pass}}</el-button>
                  <el-button class="button_text_table" @click="refuseUserApply(scope.row)" size="mini">{{lang.operator.refuse}}</el-button>
                </template>

                
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </panel-pagination>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false"  :visible.sync="newUserDialog">
      <el-form :model="user" :rules="paramValidation" ref="user" label-width="150px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.label.user_name" prop="name">
          <el-input size="small" clearable v-model.trim="user.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.label.email" prop="email">
          <el-input size="small" clearable v-model.trim="user.email" :placeholder="lang.dialog.placeholder.enter_email"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.label.password" prop="password">
          <el-input size="small" minlength="6" clearable v-model.trim="user.password" type="password" :placeholder="lang.dialog.placeholder.enter_password"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="newUserDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitUser('user')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :title="lang.dialog.title.user_details" :close-on-click-modal="false" :visible.sync="usersAssignmentDetailsDialog">
      <div class="infoBody">
        <div class="infoContent">{{ lang.dialog.title.have_user }} <i style="color: #463927;">{{ userName }}</i> {{ lang.dialog.title.details_of_user }}:
        </div>
        <el-row :gutter="30">
          <el-col :span="4" class="infoLabel">{{ lang.dialog.label.group }}:</el-col>
          <el-col :span="18" class="infoContent">
            <i style="color: teal;">{{ roleStr }}</i>
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
        <el-button @click="usersAssignmentDetailsDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  props: ['message'],
  data() {
    var validatorUserName = (rule, value, callback) => {
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      const obj = {
        name: value
      }
      if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        this.validateUserNameOrEmail(obj).then((res) => {
          if (parseInt(res.metadata.count) === 0) {
            return callback();
          } else {
            return callback(new Error(this.lang.validator.name.exist));
          }
        }, (err) => {
          console.log(err)
        });
      } else  {
        return callback(new Error(this.lang.validator.name.consists));
      }
    };
    var validatorUserEmail = (rule, value, callback) => {
      if (!value) {
        return callback(new Error(this.lang.validator.name.required));
      }
      const obj = {
        email: value
      };

      if (/^([.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
        this.validateUserNameOrEmail(obj).then((res) => {
          if (parseInt(res.metadata.count) === 0) {
            return callback();
          } else {
            return callback(new Error(this.lang.validator.name.exist));
          }
        }, (err) => {
          console.log(err)
        });
      } else  {
        return callback(new Error(this.lang.validator.email));
      }
    };
    var validatorPassword = (rule, value, callback) => {
      if (rule.required && !value) {
        return callback(new Error(this.lang.dialog.placeholder.enter_password));
      }

      if (value && value.length <= 6) {
        return callback(new Error(this.lang.validator.password));
      }

      return callback()
    };
    return {
      userRule: {},
      lang: {},
      total: 0,
      queryObj: {
        name: '',
        pageSize: 25,
        pageNumber: 1
      },
      orderBy: 'id desc',
      newUserDialog: false,
      user: {
        name: '',
        email: '',
        password: ''
      },
      paramValidation: {
        name: [{required: true, validator: validatorUserName, trigger: 'blur'}],
        email: [{type: 'email', required: true, validator: validatorUserEmail, trigger: 'blur'}],
        password: [{required: true, validator: validatorPassword, trigger: 'blur'}]
      },
      userName: '',
      roleStr: '',
      permissionStr: '',
      usersAssignmentDetailsDialog: false
    }
  },
  watch: {
    getUsers: function() {
      this.total = this.getUsers.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getUsers'])
  },
  methods: {
    ...mapActions(['readUsers', 'addUser', 'deleteUser', 'getUserAboutRolesAndPermissionsMessage', 'validateUserNameOrEmail', 'activateAccountUserByUserId']),
    getMessageDetails() {
      const obj = {};
      for (var i in this.queryObj) {
        if (this.queryObj[i] !== '') {
          obj[i] = this.queryObj[i];
        }
      }
      obj.orderBy = this.orderBy;
      this.readUsers(obj);
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
    showUserUsersAndUsersMessage(row) {
      this.userName = row.name;
      this.getUserAboutRolesAndPermissionsMessage(row).then((res) => {
        this.roleStr = res.data.roles.map((role) => { return role.name }).join(',');
        this.permissionStr = res.data.permissions.map((permissions) => { return permissions.name }).join(',');
        this.usersAssignmentDetailsDialog = true;
      }, (err) => {
        console.log(err);
      })
    },
    showAddUserDialog() {
      this.user.name = '';
      this.user.email = '';
      this.user.password = '';
      this.newUserDialog = true;
    },
    submitUser(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const obj = {
            name: this.user.name,
            email: this.user.email,
            password: this.user.password
          };
          this.addUser(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
          this.newUserDialog = false;
        } else {
          return false;
        }
      });
    },
    removeUser(row) {
      this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning',
        dangerouslyUseHTMLString: true
      }).then(() => {
        this.deleteUser(row).then((res) => {
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
    jumpOperationRecord(row) {
      window.location.href = '/RBAC/administrator/user/' + row.id + '/logs';
    },
    getSearchPaginationModel(val) {
      this.queryObj = val;
      this.getMessageDetails();
    },
    passUserApply(row) {
      const obj = {
        user_id: row.id,
        active: 1
      };
      this.activateAccountUserByUserId(obj).then((res) => {
        this.getMessageDetails();
      });
    },
    refuseUserApply(row) {
      const obj = {
        user_id: row.id,
        active: 0
      };
      this.activateAccountUserByUserId(obj).then((res) => {
        this.getMessageDetails();
      });
    },
  },
  created: function () {
    var message =  JSON.parse(this.message);
    this.userRule = message.permissions;
    this.lang = message.lang;
  },
  mounted() {
    this.getMessageDetails();
  }
};
</script>
