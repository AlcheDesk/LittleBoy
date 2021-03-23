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
         <!--  <el-table-column
            :resizable="true"
            align="left"
            label="是否完成">
            <template slot-scope="scope">
              <template v-if="scope.row.finished">
                运行完成
              </template>
              <template v-else>
                未完成
              </template>
            </template>
          </el-table-column> -->
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
          <el-table-column
            :label="lang.table.operating"
            align="left"
            width="150">
            <template slot-scope="scope">
              <el-button class="button_text_table el_button_open" @click='showListReportDetailsDialog(scope)'>{{ lang.operator.view_report }}</el-button>
              <template v-if="!scope.row.finished && scope.row.status != 'TERMINATED'">
                <el-button class="button_text_table" @click='terminateRunListRunById(scope.row)'>{{ lang.operator.terminate_operation }}</el-button>
              </template>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>

    <run-list-report
      layout=""
      pagination="total, sizes, prev, pager, next, jumper"
      runType="runList"
      :lang="lang"
      :reportDetails="listReportDetails"
      @closeDialog="cancelReportDetailData">
    </run-list-report>

    <!-- <el-dialog class="dialog"  :title="lang.dialog.title.view_report_details" :close-on-click-modal="false" :visible.sync="listReportDetailsDialog">
      <report :lang="lang" :reportDetails="listReportDetails"></report>
      <div slot="footer" class="dialog-footer">
        <el-button @click="listReportDetailsDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog> -->

  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  // import report from './runListReport/report.vue'
  import runListReport from './runListReport/runListReport.vue'

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
        orderBy: 'createdAt desc',
        listReportDetailsDialog: false,
        listReportDetails: {}
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
    components: { runListReport },
    methods: {
      ...mapActions(['readRunListResults', 'readListReportDetails', 'terminateRunListRun']),
      NavigationToRunCase(row) {
        window.location.href = '/atm/RunResult/RunList/' + row.id + '/TestCase?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        obj.mode = 'PRODUCTION';
        this.readRunListResults(obj);
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
      showListReportDetailsDialog(scope) {
        const obj = {
          runSetId: scope.row.id
        };
        this.readListReportDetails(obj).then((res) => {
          this.listReportDetails = {};
          this.listReportDetails = res.data[0];
        });
        // this.listReportDetailsDialog = true;
      },
      terminateRunListRunById(row) {
        this.terminateRunListRun(row).then((res) => {
          this.$notify({
            title: this.lang.dialog.title.success,
            message: this.lang.dialog.title.testcase_stop_success,
            type: 'success'
          });
          this.getMessageDetails();
        }, (err) => {
          console.log(err);
        });
      },
      getSearchPaginationModel(val) {
        this.queryObj = val;
        this.getMessageDetails();
      },
      cancelReportDetailData() {
        this.listReportDetails = {};
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



