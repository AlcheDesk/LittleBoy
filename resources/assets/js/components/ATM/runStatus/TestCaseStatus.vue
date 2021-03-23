<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.testcase_status }}
      </div>
    </project-tool-bar>
    <search-pagination :total="total" layout="id, name, startDate, endDate, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getTestCaseStatus.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="NavigationToCaseStatus">
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
            show-overflow-tooltip
            prop="createdAt"
            sortable="custom">
          </el-table-column>
          <!-- <el-table-column
            label="运行环境"
            :resizable="true"
            show-overflow-tooltip
            prop="operatingEnvironment"
            align="left">
          </el-table-column> -->
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
      ...mapGetters(['getTestCaseStatus'])
    },
    watch: {
      getTestCaseStatus: function() {
        this.total = this.getTestCaseStatus.metadata ? this.getTestCaseStatus.metadata.count : this.getTestCaseStatus.data.length;
      }
    },
    methods: {
      ...mapActions(['readTestCaseStatus', 'readProjectForTestCase']),
      NavigationToCaseStatus(row) {
        const obj = {};
        obj.id = row.id;
        this.readProjectForTestCase(obj).then((res) => {
          window.location.href = '/atm/RunResult/Project/' + res.data[0].id + '/TestCase/' + row.id + '/Runs/';
        }, (err) => {
          console.log(err);
        })
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.readTestCaseStatus(obj);
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

