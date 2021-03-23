<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.project_status }}
      </div>
    </project-tool-bar>
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getProjectRunStatus.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="NavigationToCaseStatus">
          <el-table-column
            :resizable="true"
            align="left"
            width='120'
            prop="id"
            :label="lang.table.id"
            show-overflow-tooltip
            sortable="custom">
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            prop="name"
            :label="lang.table.name"
            sortable="custom">
            <template slot-scope="scope">
              <i class="icon_p"></i>
              {{scope.row.name}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.run_status">
            <template slot-scope="scope">
              {{ lang.table.has_executed }} : {{ scope.row.doneTestCaseNumber }}/{{ scope.row.activeTestCaseNumber }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            width="250"
            :label="lang.table.progress">
            <template slot-scope="scope">
              <el-progress :text-inside="true" :stroke-width="18" :percentage='scope.row.completedPercent'></el-progress>
            </template>
          </el-table-column>
         <!--  <el-table-column
            :resizable="true"
            align="left"
            show-overflow-tooltip
            prop="creator"
            label="创建者">
          </el-table-column> -->
          <el-table-column
            :resizable="true"
            align="left"
            show-overflow-tooltip
            prop="createdAt"
            :label="lang.table.create_at"
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
        orderBy: 'createdAt desc'
      }
    },
    computed: {
      ...mapGetters(['getProjectRunStatus'])
    },
    watch: {
      getProjectRunStatus: function() {
        this.total = this.getProjectRunStatus.metadata ? this.getProjectRunStatus.metadata.count : this.getProjectRunStatus.data.length;
      }
    },
    methods: {
      ...mapActions(['readProjectRunStatus']),
      NavigationToCaseStatus(row) {
        window.location.href = '/atm/RunState/Project/' + row.id + '/TestCase?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.readProjectRunStatus(obj);
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

