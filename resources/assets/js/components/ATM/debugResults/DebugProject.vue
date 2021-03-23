<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.project_result }}
      </div>
      <div slot="operation">
        <el-button class="button_text_table el_button_result" @click="NavigationRunProject">{{ lang.operator.run_result }}</el-button>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getRunResultProjects.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'projectCreatedAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="NavigationToTestCasesResults">
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.id"
            prop="projectId"
            sortable="custom"
            width="150">
            <template slot-scope="scope">
              NO.{{ scope.row.projectId }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.name"
            prop="projectName"
            sortable="custom">
            <template slot-scope="scope">
              <i class="icon_p"></i>
              {{scope.row.projectName}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.testcase_quantity"
            prop="activeTestCaseNumber"
            class-name="column_color_1"
            width="150">
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.total_executed"
            prop="executedTestCaseNumber"
            class-name="column_color_2"
            width="120">
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.create_at"
            show-overflow-tooltip
            prop="projectCreatedAt"
            sortable="custom">
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
        queryObj: {
          ids: '',
          name: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        orderBy: 'projectCreatedAt desc'
      }
    },
    computed: {
      ...mapGetters(['getRunResultProjects'])
    },
    watch: {
      getRunResultProjects: function() {
        this.total = this.getRunResultProjects.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readRunResultProjects']),
      NavigationToTestCasesResults(row) {
        window.location.href = '/atm/DebugResult/Project/' + row.projectId + '/TestCase?page=1+25';
      },
      NavigationRunProject() {
        window.location.href = '/atm/RunResult/Project?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        obj.projectType = 'DEVELOPMENT';
        this.readRunResultProjects(obj);
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'projectCreatedAt desc';
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


