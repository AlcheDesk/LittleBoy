<template>
  <div>
    <project-tool-bar :messageInfo="projectStatusMessage" status="true">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/RunState/Project'>{{ lang.breadcrumb.project_status }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.testcase_status }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="execute">
        {{ lang.table.has_executed }}:  {{projectStatusMessage.doneTestCaseNumber}}/{{projectStatusMessage.activeTestCaseNumber}}
      </div>
      <div slot="progress">
        <el-progress :text-inside="true" :stroke-width="18" :percentage='projectStatusMessage.completedPercent'></el-progress>
      </div>
    </project-tool-bar>
    
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getProjectTestCaseStatus.data"
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
        projectId: null,
        queryObj: {
          ids: '',
          name: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        projectStatusMessage: {},
        orderBy: 'createdAt desc'
      }
    },
    computed: {
      ...mapGetters(['getProjectTestCaseStatus'])
    },
    watch: {
      getProjectTestCaseStatus: function() {
        this.total = this.getProjectTestCaseStatus.metadata ? this.getProjectTestCaseStatus.metadata.count : this.getProjectTestCaseStatus.data.length;
      }
    },
    methods: {
      ...mapActions(['readProjectTestCaseStatus', 'readProjectStatusForMessage']),
      getMessageDetails() {
        const obj = {
          projectId: this.projectId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = this.orderBy;
        this.readProjectTestCaseStatus(obj);
      },
      navigateTestCaseRunResult(row) {
        window.location.href = '/atm/RunResult/Project/' + this.projectId + '/TestCase/' + row.id + '/Runs?page=1+25';
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
      this.projectId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
      const project = {
        id: this.projectId
      }
      this.readProjectStatusForMessage(project).then((res) => {
        this.projectStatusMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
  
</script>

