<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.testcase_result }}
      </div>
    </project-tool-bar>

    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getTestCaseResult.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'latestDevRunUpdatedAt', order: 'descending'}"
          @sort-change="sortChange"
          :cell-class-name="changeColumnColor"
          @row-dblclick="NavigationToCaseInstructionsResults">
          <el-table-column
            :resizable="true"
            :label="lang.table.id"
            align="left"
            width="120"
            prop="testCaseId"
            show-overflow-tooltip
            sortable="custom">
            <template slot-scope="scope">
              NO.{{ scope.row.testCaseId }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.name"
            show-overflow-tooltip
            sortable="custom"
            prop="testCaseName"
            align="left">
            <template slot-scope="scope">
              <i class="icon_t"></i>
              {{scope.row.testCaseName}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.run_date"
            sortable="custom"
            prop="latestDevRunUpdatedAt"
            show-overflow-tooltip>
              <template slot-scope="scope">
                {{ scope.row.latestDevRunUpdatedAt ? scope.row.latestDevRunUpdatedAt : '未运行'}}
              </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.success_total"
            width="100"
            class-name="column_color_1"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{ scope.row.latestDevRunInstructionPassCount }} / {{ scope.row.latestDevRunInstructionExecutedCount }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.error"
            width="80"
            class-name="column_color_2"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{ scope.row.latestDevRunInstructionExecutedCount - scope.row.latestDevRunInstructionPassCount }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.number_of_run"
            width="100"
            prop="totalDevRunCount"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.create_at"
            align="left"
            prop="latestDevRunCreatedAt"
            sortable="custom"
            show-overflow-tooltip>
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
        lang: {},
        queryObj: {
          ids: '',
          name: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        orderBy: 'latestDevRunUpdatedAt desc'
      }
    },
    computed: {
      ...mapGetters(['getTestCaseResult'])
    },
    watch: {
      getTestCaseResult: function() {
        this.total = this.getTestCaseResult.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readTestCaseResults', 'readProjectForTestCase']),
      NavigationToCaseInstructionsResults(row) {
        const obj = {};
        obj.id = row.testCaseId;
        this.readProjectForTestCase(obj).then((res) => {
        window.location.href = '/atm/DebugResult/Project/' + res.data[0].id + '/TestCase/' + row.testCaseId + '/Runs?page=1+25';
        }, (err) => {
          console.log(err);
        })
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            if (i == 'ids') {
              obj.testCaseIds = this.queryObj[i];
            } else if (i == 'name') {
              obj.testCaseName = this.queryObj[i];
            } else {
              obj[i] = this.queryObj[i];
            }
          }
        }
        obj.orderBy = this.orderBy;
        obj.latestDevRunId = 'not null';
        this.readTestCaseResults(obj);
      },
      handleSizeChange(val) {
        this.pagination.sizePage = val;
        this.getMessageDetails();
      },
      handleCurrentChange(val) {
        this.pagination.currentPage = val;
        this.getMessageDetails();
      },
      searchIconClick() {
        this.pagination.currentPage = 1;
        this.getMessageDetails();
      },
      resetSearch() {
        this.searchObj = {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          status: ''
        };
        this.pagination.currentPage = 1;
        this.getMessageDetails();
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'latestDevRunUpdatedAt desc';
        }
        this.getMessageDetails();
      },
      changeColumnColor({row, column, rowIndex, columnIndex}) {
        if (columnIndex === 4) {
          if (row.fail > 0) {
            return 'fail_css';
          } else {
            return 'column_color_2'
          }
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

