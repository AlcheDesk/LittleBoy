<template>
  <div class="rbac_content">
    <panel-pagination :lang="lang" :total="total" @search="getSearchPaginationModel">
      <template v-slot:title>{{ lang.breadcrumb.group_user }}</template>
      <template v-slot:operation>
        <template v-if="userRule.add_group_users">
          <el-button plain class="button_text_table" @click="showAddGroupUserDialog" size="mini">{{ lang.operator.new }}</el-button>
        </template>
      </template>
      <template v-slot:table>
        <el-table
          :data="getGroupUsers.data"
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
            :label="lang.table.group_user_name">
          </el-table-column>
          <el-table-column
            prop="email"
            align="left"
            show-overflow-tooltip
            :label="lang.table.email">
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
              <template v-if="userRule.delete_group_users">
                <el-button class="button_text_table" @click="removeUser(scope.row)" size="mini">{{ lang.operator.delete }}</el-button>
              </template>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </panel-pagination>

    <el-dialog  :title="lang.dialog.title.add" :close-on-click-modal="false"  :visible.sync="newGroupUserDialog">
      <el-form :model="groupUser" :rules="paramValidation" ref="groupUser" label-width="150px"  label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.label.group_user_name" prop="name">
          <el-select v-model="groupUser.name" clearable multiple value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select_name">
            <el-option
              v-for="item in getSelectUsers"
              :key="item.label"
              :label="item.label"
              :value="item.value">
              </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="newGroupUserDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitGroupUser('groupUser')">{{ lang.operator.confirm }}</el-button>
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
      userRule: {},
      lang: {},
      total: 0,
      queryObj: {
        name: '',
        pageSize: 25,
        pageNumber: 1
      },
      orderBy: 'id desc',
      newGroupUserDialog: false,
      groupUser: {
        name: []
      },
      paramValidation: {
        name: [{ required: true }, {type: 'regexp', pattern: '/^[a-zA-Z0-9]+/', trigger: 'blur'}]
      }
    }
  },
  watch: {
    getGroupUsers: function() {
      this.total = this.getGroupUsers.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getGroupUsers', 'getSelectUsers'])
  },
  methods: {
    ...mapActions(['readGroupUsers', 'associateGroupAndUsers', 'deleteGroupUserAssociate', 'readUsers']),
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
      this.readGroupUsers(obj);
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
    showAddGroupUserDialog() {
      this.groupUser.name = [];
      const obj = {
        id: window.location.pathname.split('/')[4]
      };
      this.readUsers(obj);
      this.newGroupUserDialog = true;
    },
    submitGroupUser(formname) {
      this.$refs[formname].validate((valid) => {
        if (valid) {
          const groupUserIds = this.groupUser.name.map((item) => { return item.id });
          const obj = {
            id: window.location.pathname.split('/')[4]
          };
          obj.data = {
            ids: groupUserIds
          }
          this.associateGroupAndUsers(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
          this.newGroupUserDialog = false;
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
        const obj = {
          gid: window.location.pathname.split('/')[4],
          uid: row.id
        }
        this.deleteGroupUserAssociate(obj).then((res) => {
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
    this.userRule = message.permissions;
    this.lang = message.lang;
  },
  mounted() {
    this.getMessageDetails();
  }
};
</script>