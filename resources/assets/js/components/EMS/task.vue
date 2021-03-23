<template>
  <div class="ems_content">
    <div class="control_container container_bottom">
      <div class="container_panel display_flex">
        <div class="panel_left flex_3">
          <div class="panel_left_icon">
            <i class="fa fa-calendar-check-o fa-2x" aria-hidden="true"></i>
          </div>
          <div class="panel_left_text">
            {{ this.lang.menu.testcase_detail }}
          </div>
          <div class="panel_left_button">
            <el-button type="primary" class="panel_buttom">{{ taskData.length }}</el-button>
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
            :total="taskTotal">
          </el-pagination>
        </div>
      </div>
      <el-row :gutter="10" class="search_bar">
        <el-col :span="4" class="search_item">
          <div class="search_label">{{ this.lang.table.status }}：</div>
          <div class="search_content">
            <el-select v-model="requestParamObject.status" clearable size="mini">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.value"
                :value="item.value">
              </el-option>
            </el-select>
          </div>
        </el-col>
      <!--   <el-col :span="3" class="search_item">
          <div class="search_label">{{ this.lang.table.id }}：</div>
          <div class="search_content">
            <el-input v-model="requestParamObject.id" size="mini"></el-input>
          </div>
        </el-col> -->
        <el-col :span="4" class="search_item">
          <div class="search_label">{{ this.lang.table.name }}：</div>
          <div class="search_content">
            <el-input v-model="searchObject.name" size="mini"></el-input>
          </div>
        </el-col>
        <el-col :span="4" class="search_item">
          <div class="search_label">{{ this.lang.table.work_id }}：</div>
          <div class="search_content">
            <el-input v-model="searchObject.workerId" size="mini"></el-input>
          </div>
        </el-col>
        <el-col :span="5" class="search_item">
          <div class="search_label">{{ this.lang.table.start_date }}：</div>
          <div class="search_content">
            <el-date-picker
              size="mini"
              type="datetime"
              format="yyyy-MM-dd HH:mm:ss"
              @change="startDateChange"
              v-model="startDate">
            </el-date-picker>
          </div>
        </el-col>
        <el-col :span="5" class="search_item">
          <div class="search_label">{{ this.lang.table.end_date }}：</div>
          <div class="search_content">
            <el-date-picker
              size="mini"
              type="datetime"
              format="yyyy-MM-dd HH:mm:ss"
              @change="endDateChange"
              v-model="endDate">
            </el-date-picker>
          </div>
        </el-col>
        <el-col :span="2" class="search_item">
          <el-button size="mini" class="search_button" @click="searchBtn">{{ this.lang.table.search }}</el-button>
        </el-col>
      </el-row>
      <div class="table_container container_top_2">
        <div class="table_block">
          <el-table
            :data="taskData"
            :default-sort="{prop: 'updatedAt', order: 'descending'}"
            @sort-change="sortChange"
            row-class-name="row_css"
            height="100%"
            stripe>
            <el-table-column
              :label="lang.table.id"
              fixed
              prop="id"
              align="left"
              width="90"
              sortable
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="name"
              :label="lang.table.name"
              align="left"
              sortable='custom'
              min-width="120"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="jobId"
              :label="lang.table.work_id"
              align="left"
              sortable='custom'
              min-width="140"
              show-overflow-tooltip>
            </el-table-column>
            <!-- <el-table-column
              prop="instruction"
              label="指令"
              align="left"
              show-overflow-tooltip>
            </el-table-column> -->
            <el-table-column
              prop="priority"
              :label="lang.table.priority"
              align="left"
              min-width="100"
              sortable='custom'
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="type"
              :label="lang.table.type"
              align="left"
              min-width="120"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="operatingSystem"
              :label="lang.table.exec_system"
              align="left"
              min-width="120"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="status"
              :label="lang.table.status"
              align="left"
              min-width="90"
              show-overflow-tooltip>
            </el-table-column>
            <!-- <el-table-column
              prop="unitId"
              label="执行单元编号"
              align="left"
              min-width="90"
              show-overflow-tooltip>
            </el-table-column> -->
            <!-- <el-table-column
              prop="exitNum"
              label="退出码"
              align="left"
              show-overflow-tooltip>
            </el-table-column> -->
            <el-table-column
              prop="log"
              :label="lang.table.log"
              align="left"
              width="100"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <el-popover
                  ref="name"
                  placement="top"
                  trigger="click">
                  <div>
                    <div v-if="!scope.row.logs.length">none</div>
                    <template v-for="(log, index) in scope.row.logs">
                      <div :key="index">
                        <span>{{ lang.table.time }} : {{ new Date(log.createdAt).toLocaleString() + ', '}}</span>
                        <span>{{ lang.table.log }}：{{log.log + '\n'}}</span>
                      </div>
                    </template>
                  </div>
                </el-popover>
                <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;cursor: pointer;">
                  <span class="text" style="color: #aaa;" v-popover:name>View Log</span>
                </div>
              </template>
            </el-table-column>
            <el-table-column
              prop="createdAt"
              :label="lang.table.start_exec_at"
              align="left"
              sortable='custom'
              min-width="170"
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
          workerId: '',
        },
        startDate: '',
        endDate: '',
        options: [{
          label: '新建',
          value: 'NEW'
        }, {
          label: '执行中',
          value: 'WIP'
        }, {
          label: '完成',
          value: 'DONE'
        }, {
          label: '错误',
          value: 'ERROR'
        }],
        currentPage: 1,
        taskData: [],
        taskTotal: 0,
        requestParamObject: {
          pageNumber: 1,
          pageSize: 20,
          ref: true
        },
        disabled: true,
        lang: {}
      }
    },
    computed: {
      ...mapGetters(['tasks', 'taskCount'])
    },
    created: function () {
      var message =  JSON.parse(this.message);
      // this.permissionRule = message.permissions;
      this.lang = message.lang;
    },
    mounted() {
      this.requestFunc()
    },
    watch: {
      tasks: function () {
        this.taskData = this.tasks
        this.taskTotal = this.taskCount
      },
      $route() {
        window.location.reload()
      }
    },
    methods: {
      ...mapActions(['getTasks', 'getTaskByJobId']),
      handleSizeChange(val) {
        this.requestParamObject.pageSize = val
        this.requestFunc()
      },
      handleCurrentChange(val) {
        this.requestParamObject.pageNumber = val
        this.requestFunc()
      },
      searchBtn() {
        // 将非空搜索参数复制到请求参数对象
        this.requestFunc()
      },
      startDateChange() {
        console.log(this.startDate)
        let time = Date.parse(new Date(Date.parse(this.startDate)))
        this.requestParamObject.startDate = time
      },
      endDateChange() {
        let time = Date.parse(new Date(Date.parse(this.endDate)))
        this.requestParamObject.endDate = time
      },
      sortChange(column) {
        if (column && column.order === 'descending') {
          this.requestParamObject.orderBy = column.prop + ' desc';
        } else if (column.order === 'ascending') {
          this.requestParamObject.orderBy = column.prop + ' asc';
        } else {
          this.requestParamObject.orderBy = 'updatedAt desc';
        }
        this.requestFunc()
      },
      requestFunc() {
        let uuid = window.location.search.split('=')[1];
        if (uuid && uuid.includes('task')) {
          uuid = uuid.split('&')[0];
          let obj = {}
          obj.uuid = uuid
          obj.data = {};
          obj.data.ref = true;
          this.getTasks(obj)
        } else if (uuid) {
          let obj = {}
          obj.uuid = uuid
          obj.param = this.extendCopy(this.requestParamObject, this.searchObject)
          this.getTaskByJobId(obj)
        } else {
          this.getTasks(this.extendCopy(this.requestParamObject, this.searchObject))
        }
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
