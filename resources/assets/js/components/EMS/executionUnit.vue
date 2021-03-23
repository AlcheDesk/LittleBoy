<template>
  <div class="ems_content">
    <div class="control_container container_bottom">
      <div class="container_panel display_flex">
        <div class="panel_left flex_3">
          <div class="panel_left_icon">
            <i class="fa fa-briefcase fa-2x" aria-hidden="true"></i>
          </div>
          <div class="panel_left_text">
            {{ this.lang.menu.exec_unit }}
          </div>
          <div class="panel_left_button">
            <el-button type="primary" class="panel_buttom">{{ unitData.length }}</el-button>
          </div>
        </div>
        <div class="panel_right">
          <el-pagination
             @size-change="handleSizeChange"
             @current-change="handleCurrentChange"
             :current-page="currentPage"
             :page-sizes="[10, 20, 50, 100]"
             :page-size="requestParamObject.pageSize"
             layout="total, sizes, prev, pager, next, jumper"
             :total="unitTotal">
          </el-pagination>
        </div>
      </div>
      <div class="table_container container_top_1">
        <div class="table_block">
          <el-table
            :data="unitData"
            :default-sort="{prop: 'updatedAt', order: 'descending'}"
            @sort-change="sortChange"
            row-class-name="row_css"
            height="100%"
            stripe>
            <el-table-column
              type="index"
              fixed
              :label="lang.table.id"
              align="left"
              width="70"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="group"
              :label="lang.table.group"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="name"
              :label="lang.table.name"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <!-- <el-table-column
              prop="hostname"
              label="计算机名字"
              align="left"
              min-width="120"
              show-overflow-tooltip>
            </el-table-column> -->
            <el-table-column
              prop="status"
              :label="lang.table.status"
              align="left"
              min-width="90"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="tasks"
              :label="lang.table.current_task"
              align="left"
              min-width="100"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="ipAddress"
              :label="lang.table.ip"
              align="left"
              min-width="120"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="port"
              :label="lang.table.port"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="macAddress"
              :label="lang.table.mac"
              align="left"
              min-width="90"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="architecture"
              :label="lang.table.cpu_arch"
              align="left"
              min-width="80"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="cpuCore"
              :label="lang.table.cpu_core_number"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="ram"
              :label="lang.table.memory"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="operatingSystem"
              :label="lang.table.system"
              align="left"
              min-width="120"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="updatedAt"
              :label="lang.table.update_at"
              sortable='custom'
              align="left"
              min-width="130"
              show-overflow-tooltip>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  // import { extendCopy } from '../../utils/tools'
  import moment from 'moment'
  export default {
    props: ['message'],
    data() {
      return {
        searchObject: {
          id: '',
          name: '',
          priority: '',
          status: '',
        },
        currentPage: 1,
        unitData: [],
        unitTotal: 0,
        requestParamObject: {
          pageNumber: 1,
          pageSize: 20,
        },
        lang: {}
      }
    },
    created: function () {
      var message =  JSON.parse(this.message);
      // this.permissionRule = message.permissions;
      this.lang = message.lang;
    },
    mounted () {
      this.getWorkers(this.extendCopy(this.requestParamObject, this.searchObject))
    },
    computed: {
      ...mapGetters(['workers', 'workCount'])
    },
    watch: {
      workers: function () {
        this.unitData = this.workers
        this.unitTotal = this.workCount
      }
    },
    methods: {
      ...mapActions(['getWorkers']),
      handleSizeChange(val) {
        this.requestParamObject.pageSize = val
        this.getWorkers(this.extendCopy(this.requestParamObject, this.searchObject))
      },
      handleCurrentChange(val) {
        this.requestParamObject.pageNumber = val
        this.getWorkers(this.extendCopy(this.requestParamObject, this.searchObject))
      },
      sortChange(column) {
        if (column && column.order === 'descending') {
          this.requestParamObject.orderBy = column.prop + ' desc';
        } else if (column.order === 'ascending') {
          this.requestParamObject.orderBy = column.prop + ' asc';
        } else {
          this.requestParamObject.orderBy = 'updatedAt desc';
        }
        this.getWorkers(this.extendCopy(this.requestParamObject, this.searchObject))
      },
      // 将src的非空对象属性拷贝到obj
      extendCopy(obj, src) {
        if (typeof obj === 'object' && typeof src === 'object') {
          for (const prop in src) {
            if (src.hasOwnProperty(prop) && src[prop]) {
              obj[prop] = src[prop]
              if (!obj[prop]) {
                delete obj[prop]
              }
            }
          }
          for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
              if (!obj[key]){
                delete obj[key]
              }
            }
          }
          return obj
        }
        for (const key in obj) {
          if (obj.hasOwnProperty(key)) {
            if (!obj[key]) {
              delete obj[key]
            }
          }
        }
        return obj
      }
    }
  };
</script>

<style scoped>
  .constainer {
    background-color: white;
    position: absolute;
    text-align: left;
  }
  .el-date-editor.el-input {
    width: 100% !important;
  }
</style>
