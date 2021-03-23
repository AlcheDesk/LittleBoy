<template>
  <div>
    <project-tool-bar :messageInfo="runListMessage" status="true">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/RunState/RunList'>{{ lang.breadcrumb.run_list_status }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.list_detail }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="execute">
        {{ lang.table.has_executed }}: {{runListMessage.doneTestCaseNumber}}/{{runListMessage.activeTestCaseNumber}}
      </div>
      <div slot="progress">
        <el-progress :text-inside="true" :stroke-width="18" :percentage='runListMessage.completedPercent'></el-progress>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getRunCaseStatus.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="navigateTestCaseRunResult">
          <el-table-column
            :label="lang.table.id"
            :resizable="true"
            align="left"
            prop="id"
            show-overflow-tooltip
            width="100"
            sortable="custom">
          </el-table-column>
          <el-table-column
            :label="lang.table.name"
            :resizable="true"
            align="left"
            prop="name"
            show-overflow-tooltip
            sortable="custom">
            <template slot-scope="scope">
              <i class="icon_t"></i>
              {{scope.row.name}}
            </template>
          </el-table-column>
          <!-- <el-table-column
            label="创建者"
            :resizable="true"
            prop="creator"
            show-overflow-tooltip
            align="left">
          </el-table-column> -->
          <el-table-column
            :label="lang.table.create_at"
            :resizable="true"
            align="left"
            width="250"
            show-overflow-tooltip
            prop="createdAt"
            sortable="custom">
          </el-table-column>
          <el-table-column
            :label="lang.table.operating_environment"
            :resizable="true"
            show-overflow-tooltip
            prop="operatingEnvironment"
            align="left">
          </el-table-column>
          <el-table-column
            :label="lang.table.progress"
            :resizable="true"
            align="left">
            <template slot-scope="scope">
              <el-progress :text-inside="true" :stroke-width="18" :percentage='scope.row.instructionCompletedPrecent'></el-progress>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>
  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        runListId: null,
        queryObj: {
          ids: '',
          name: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        runListMessage: {},
        orderBy: 'createdAt desc'
      }
    },
    computed: {
      ...mapGetters(['getRunCaseStatus'])
    },
    watch: {
      getRunCaseStatus: function() {
        this.total = this.getRunCaseStatus.metadata ? this.getRunCaseStatus.metadata.count : this.getRunCaseStatus.data.length;
      }
    },
    methods: {
      ...mapActions(['readRunCaseStatus', 'readRunListForMessage', 'readProjectForTestCase']),
      getMessageDetails() {
        const obj = {
          runsetId: this.runListId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = this.orderBy;
        this.readRunCaseStatus(obj);
      },
      navigateTestCaseRunResult(row) {
        const obj = {};
        obj.id = row.id;
        this.readProjectForTestCase(obj).then((res) => {
          window.location.href = '/atm/RunResult/Project/' + res.data[0].id + '/TestCase/' + row.id + '/Runs?page=1+25';
        }, (err) => {
          console.log(err);
        })
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
      this.runListId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
      const runList = {
        id: this.runListId
      }
      this.readRunListForMessage(runList).then((res) => {
        this.runListMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
  
</script>

