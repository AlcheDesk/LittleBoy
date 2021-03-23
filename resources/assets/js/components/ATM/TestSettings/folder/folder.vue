<template>
  <project-container>
    <div slot="toolbar">
      <project-tool-bar>
        <div slot="breadcrumb">
          {{ lang.breadcrumb.folder }}
        </div>
        <div slot="name">
          {{ lang.breadcrumb.folder_list }}
        </div>
        <div slot="operation">
          <template v-if="permissionRule.add_folder">
            <add :lang="lang" @folderAddDone="getMessageDetails"></add>
          </template>
        </div>
      </project-tool-bar>
    </div>
    <div slot="container">
      <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
        <template v-slot:table>
          <el-table
            :data="getFolders.data"
            row-class-name="row_css"
            :default-sort="{prop: 'createdAt', order: 'descending'}"
            @sort-change="sortChange"
            @row-dblclick="Navigation"
            style="width: auto">
            <el-table-column
              :label="lang.table.id"
              :resizable="true"
              align="left"
              prop="id"
              sortable="custom"
              width="120"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              :label="lang.table.name"
              :resizable="true"
              align="left"
              prop="name"
              sortable="custom"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <i class="icon_f"></i>
                {{scope.row.name}}
              </template>
            </el-table-column>
           <!--  <el-table-column
              label="创建者"
              :resizable="true"
              align="left"
              prop="creator"
              show-overflow-tooltip>
            </el-table-column> -->
            <el-table-column
              :label="lang.table.create_at"
              :resizable="true"
              sortable="custom"
              align="left"
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
            <template v-if="permissionRule.delete_folder || permissionRule.edit_folder">
              <el-table-column
                :label="lang.table.operating"
                :resizable="true"
                width="120"
                align="left">
                <template slot-scope="scope">
                  <template v-if="permissionRule.edit_folder">
                    <edit
                      :lang="lang"
                      :row="scope.row"
                      @folderEditDone="getMessageDetails">
                    </edit>
                  </template>
                  <template v-if="permissionRule.delete_folder">
                    <el-button class="button_text_table" @click="removeFolder(scope)">{{lang.operator.delete}}</el-button>
                  </template>
                </template>
              </el-table-column>
            </template>
          </el-table>
        </template>
      </search-pagination>
    </div>
  </project-container>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import Add from './Add.vue'
import Edit from './Edit.vue'

export default {
  props: ['message'],
  data() {
    return {
      orderBy: 'createdAt desc',
      queryObj: {
        ids: '',
        name: '',
        comment: '',
        startDate: '',
        endDate: '',
        pageNumber: 1,
        pageSize: 25
      },
      total: 0
    }
  },
  watch: {
    getFolders: function() {
      this.total = this.getFolders.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getFolders'])
  },
  components: { Add, Edit },
  methods: {
    ...mapActions(['readFolders', 'deleteFolder']),
    getMessageDetails() {
      const obj = {};
      for (var i in this.queryObj) {
        if (this.queryObj[i] != '') {
          obj[i] = this.queryObj[i];
        }
      }
      obj.orderBy = this.orderBy;
      this.readFolders(obj);
    },
    Navigation (row) {
      window.location.href = '/atm/TestSetting/Folder/' + row.id + '/TestCase?page=1+25';
    },
    removeFolder(scope) {
      this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
        confirmButtonText: this.lang.operator.confirm,
        cancelButtonText: this.lang.operator.cancel,
        type: 'warning',
        dangerouslyUseHTMLString: true
      }).then(() => {
        const obj = scope.row;
        this.deleteFolder(obj).then((res) => {
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
        this.orderBy = 'id desc';
      }
      this.getMessageDetails();
    },
    getSearchPaginationModel(val) {
      this.queryObj = val;
      this.getMessageDetails();
    }
  },
  created() {
    var message =  JSON.parse(this.message);
    this.permissionRule = message.permissions;
    this.lang = message.lang;
    this.getMessageDetails();
  }
};
</script>
