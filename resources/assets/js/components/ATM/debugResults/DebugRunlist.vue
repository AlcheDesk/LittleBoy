<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.list_result }}
      </div>
    </project-tool-bar>
    
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getRunListResults.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          :cell-class-name="cellStyle"
          @row-dblclick="NavigationToRunCase">
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.id"
            prop="id"
            sortable="custom"
            width="150">
            <template slot-scope="scope">
              NO.{{ scope.row.id }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.name"
            prop="name"
            sortable="custom">
            <template slot-scope="scope">
              <i class="icon_l"></i>
              {{scope.row.name}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.status"
            prop="status"
            width="150">
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.priority"
            prop="priority"
            width="150">
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.create_at"
            prop="createdAt"
            sortable="custom">
            <template slot-scope="scope">
              {{ new Date(scope.row.createdAt).toLocaleString() }}
            </template>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import moment from 'moment'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        queryObj: {
          ids: '',
          name: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        orderBy: 'createdAt desc'
      }
    },
    computed: {
      ...mapGetters(['getRunListResults'])
    },
    watch: {
      getRunListResults: function() {
        this.total = this.getRunListResults.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readRunListResults']),
      NavigationToRunCase(row) {
        window.location.href = '/atm/DebugResult/RunList/' + row.id + '/TestCase?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        obj.mode = 'DEVELOPMENT';
        this.readRunListResults(obj);
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
      cellStyle({row, column, rowIndex, columnIndex}) {
        if (row.status == 'PASS' && columnIndex == 2) {
          return 'pass_css'
        }
        if (row.status == 'ERROR' || row.status == 'FAIL') {
          if (columnIndex == 2) {
            return 'fail_css';
          }
        }
        if (row.status == 'NEW' && columnIndex == 2) {
          return 'new_css'
        }
        if (row.status == 'WIP' && columnIndex == 2) {
          return 'wip_css'
        }
        if (row.status == 'TERMINATED' && columnIndex == 2) {
          return 'terminated_css'
        }
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



