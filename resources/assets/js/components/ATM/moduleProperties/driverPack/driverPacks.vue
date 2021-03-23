<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.engine_package }}
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_drivers_packs">
          <add :lang="lang" @driverPackAddDone="getMessageDetails"></add>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getDriverPacks.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="navigationToDriver">
          <el-table-column
            :label="lang.table.id"
            :resizable="true"
            prop="id"
            width='120'
            sortable="custom"
            align="left">
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.name"
            prop="name"
            sortable="custom"
            align="left">
          </el-table-column>
          <el-table-column
            :resizable="true"
            show-overflow-tooltip
            prop="createdAt"
            sortable="custom"
            :label="lang.table.create_at"
            align="left">
            <template slot-scope="scope">
              {{ new Date(scope.row.createdAt).toLocaleString() }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.comment"
            prop="comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_drivers_packs">
            <el-table-column
              :resizable="true"
              :label="lang.table.operating"
              width='120'>
              <template slot-scope="scope">
                <el-button class="button_text_table" @click="removeDriverPacks(scope)">{{lang.operator.delete}}</el-button>
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
      ...mapGetters(['getDriverPacks'])
    },
    components: { Add },
    watch: {
      getDriverPacks: function() {
        this.total = this.getDriverPacks.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readDriverPacks', 'deleteDriverPack']),
      navigationToDriver(row) {
        window.location.href = '/atm/ModulePro/DriverPacks/' + row.id + '/PacksEngines?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.readDriverPacks(obj);
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
      removeDriverPacks(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = scope.row;
          this.deleteDriverPack(obj).then((res) => {
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


