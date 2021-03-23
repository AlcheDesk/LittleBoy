<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.engine }}
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_drivers">
          <add :lang="lang" @engineAddDone="getMessageDetails"></add>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getEngines.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="navigationEngineProperties">
          <el-table-column
            :label="lang.table.id"
            align="left"
            :resizable="true"
            prop="id"
            width='120'
            sortable="custom">
          </el-table-column>
          <el-table-column
            sortable="custom"
            :label="lang.table.engine_name"
            align="left"
            :resizable="true"
            prop="name"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="type"
            align="left"
            :label="lang.table.type"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="vendorName"
            align="left"
            :label="lang.table.vendor"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="version"
            align="left"
            :label="lang.table.version"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.default"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{scope.isDefault ? 'YES' : 'NO' }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="createdAt"
            align="left"
            sortable="custom"
            :label="lang.table.create_at"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="comment"
            align="left"
            :label="lang.table.comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_drivers">
            <el-table-column
              :resizable="true"
              :label="lang.table.operating"
              width='120'>
              <template slot-scope="scope">
                <el-button class="button_text_table" @click="removeEngines(scope)">{{lang.operator.delete}}</el-button>
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
      ...mapGetters(['getEngines'])
    },
    watch: {
      getEngines: function() {
        this.total = this.getEngines.metadata ? this.getEngines.metadata.count : this.getEngines.data.length;
      }
    },
    components: { Add },
    methods: {
      ...mapActions(['readEngines', 'deleteEngines', 'validateDriversName']),
      navigationEngineProperties(row) {
        window.location.href = '/atm/ModulePro/EngineSetting/' + row.id + '/Properties?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.readEngines(obj);
      },
      removeEngines(scope) {
        this.driver = scope.row.name;
        const obj = {
          driverId: scope.row.id
        };
        this.validateDriversName(obj).then((res) => {
          if (res.metadata.count == 0) {
            this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
              confirmButtonText: this.lang.operator.confirm,
              cancelButtonText: this.lang.operator.cancel,
              type: 'warning',
              dangerouslyUseHTMLString: true
            }).then(() => {
              const obj = {};
              obj.id = scope.row.id;
              this.deleteEngines(obj).then((res) => {
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
          } else {
            var str = '';
            res.data.forEach(item => {
              str += item.driverPackName;
            })
            this.$confirm(this.lang.dialog.title.delete_driver_message_1 + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_driver_message_2 + '<i style="color: green;">' + str + '</i>' + this.lang.dialog.title.delete_driver_message_3, this.lang.dialog.title.delete, {
              cancelButtonText: this.lang.operator.cancel,
              type: 'info',
              showConfirmButton: false,
              dangerouslyUseHTMLString: true
            }).catch(() => {
              this.$message({
                type:'info',
                message: this.lang.operator.undelete
              });
            });
          }
        })
      },
      sortChange(column) {
        if (column && column.order === 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order === 'ascending') {
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


