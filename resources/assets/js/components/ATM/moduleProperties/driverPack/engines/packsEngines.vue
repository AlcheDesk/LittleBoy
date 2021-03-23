<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/ModulePro/DriverPacks/?page=1+25'>{{ lang.breadcrumb.engine_package }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.engine }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_drivers_pack_drivers">
          <add :lang="lang" @packDriverAddDone="getMessageDetails"></add>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getPacksEngines.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange">
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
          <template v-if="permissionRule.delete_drivers_pack_drivers">
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
        packId: null,
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
      ...mapGetters(['getPacksEngines'])
    },
    components: { Add },
    watch: {
      getPacksEngines: function() {
        this.total = this.getPacksEngines.metadata ? this.getPacksEngines.metadata.count : this.getPacksEngines.data.length;
      }
    },
    methods: {
      ...mapActions(['readPacksEngines', 'addPacksEngines', 'deletePacksEngines', 'readEngines']),
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        const param = {
          packId: this.packId,
          data: obj
        };
        this.readPacksEngines(param);
      },
      removeEngines(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = {};
          obj.id = scope.row.id;
          obj.packId = this.packId;
          this.deletePacksEngines(obj).then((res) => {
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
      this.packId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
    }
  };
</script>


