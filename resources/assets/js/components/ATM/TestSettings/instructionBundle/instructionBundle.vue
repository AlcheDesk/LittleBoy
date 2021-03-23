<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.instruction_bundle }}
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_instruction_bundle">
          <add :lang="lang" @bundleAddDone="getMessageDetails"></add>
        </template>
      </div>
    </project-tool-bar>

    <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getInstructionBundle.data"
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
              <i class="icon_b"></i>
              {{scope.row.name}}
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
            :resizable="true"
            align="left"
            :label="lang.table.comment"
            prop="comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_instruction_bundle || permissionRule.edit_instruction_bundle">
            <el-table-column
              :label="lang.table.operating"
              :resizable="true"
              align="left"
              width="150">
              <template slot-scope="scope">
                <template v-if="permissionRule.delete_instruction_bundle">
                  <el-button class="button_text_table" @click="deleteInstructionBundle(scope)">{{lang.operator.delete}}</el-button>
                </template>
                <template v-if="permissionRule.edit_instruction_bundle">
                  <edit
                    :lang="lang"
                    :row="scope.row"
                    @bundleEditDone="getMessageDetails">
                  </edit>
                </template>
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </search-pagination>

  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import Add from './Add.vue'
  import Edit from './Edit.vue'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
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
    computed: {
      ...mapGetters(['getInstructionBundle'])
    },
    watch: {
      getInstructionBundle: function() {
        this.total = this.getInstructionBundle.metadata.count;
      }
    },
    components: { Add, Edit },
    methods: {
      ...mapActions(['readInstructionBundle', 'removeInstructionBundle']),
      navigationToRunListTestCases(row) {
          window.location.href = '/atm/TestSetting/InstructionBundle/' + row.id + '/InstructionBundleEntry';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.readInstructionBundle(obj);
      },
      deleteInstructionBundle(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = scope.row;
          this.removeInstructionBundle(obj).then((res) => {
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


