<template>
  <div class="ems_content">
    <div class="control_container container_height">
      <div class="container_panel display_flex">
        <div class="panel_left flex_5">
          <div class="panel_left_icon">
            <i class="fa fa-briefcase fa-2x" aria-hidden="true"></i>
          </div>
          <div class="panel_left_text">
            {{ this.lang.menu.exec_overview }}
          </div>
          <div class="panel_left_button">
            <el-button type="primary" class="panel_buttom">{{ tableData.length }}</el-button>
          </div>
        </div>
        <div class="panel_right flex_4">
          <div class="square_div new_text"></div>
          <div class="text_info">
          {{ this.lang.text.new }}</div>
          <div class="square_div executing_text"></div>
          <div class="text_info">
          {{ this.lang.text.executing }}</div>
          <div class="square_div pass_text"></div>
          <div class="text_info">
          {{ this.lang.text.pass }}</div>
          <div class="square_div fail_text"></div>
          <div class="text_info">
          {{ this.lang.text.fail }}</div>
        </div>
      </div>
      <div class="table_container container_top_1">
        <div class="table_block">
          <el-table
            :data="tableData"
            row-class-name="row_css"
            height="100%"
            stripe>
            <el-table-column
              fixed
              prop="id"
              :label="lang.table.id"
              align="left"
              width="70"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="priority"
              :label="lang.table.priority"
              sortable
              align="left"
              min-width="100"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="name"
              :label="lang.table.work_name"
              align="left"
              sortable
              min-width="130"
              show-overflow-tooltip>
            </el-table-column>
            <!-- <el-table-column
              prop="environment"
              label="执行环境"
              align="left"
              min-width="130"
              show-overflow-tooltip>
            </el-table-column> -->
            <el-table-column
              prop="remoteIp"
              :label="lang.table.creator_ip"
              align="left"
              min-width="120"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="updatedAt"
              :label="lang.table.update_at"
              align="left"
              sortable
              min-width="170"
              show-overflow-tooltip>
            </el-table-column>
            <!-- <el-table-column
              prop="createdAt"
              :formatter="formatDate"
              label="创建时间"
              align="left"
              min-width="160"
              show-overflow-tooltip>
            </el-table-column> -->
            <el-table-column
              prop="status"
              :label="lang.table.status"
              align="left"
              sortable
              min-width="90"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
            :label="lang.table.task"
            min-width="400">
              <template slot-scope="scope">
                <progress-bar :tasks="scope.row.tasks"></progress-bar>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </div>
    <div class="control_footer">
      <div class="footer_panel">
        <div class="footer_left">
          <div class="panel_left_icon">
            <i class="fa fa-user fa-2x" aria-hidden="true"></i>
          </div>
          <div class="panel_left_text">
            {{ this.lang.text.exec_unit_status }}
          </div>
        </div>
        <div class="panel_right">
          <div class="square_div pass_text"></div>
          <div class="text_info">
          {{ this.lang.text.empty }}</div>
          <div class="square_div executing_text"></div>
          <div class="text_info">
          {{ this.lang.text.executing }}</div>
          <div class="square_div hang_text"></div>
          <div class="text_info">
          {{ this.lang.text.hang }}</div>
          <div class="square_div fail_text"></div>
          <div class="text_info">
          {{ this.lang.text.off_line }}</div>
        </div>
      </div>
      <div class="work-wrapper">
        <template  v-for="(work, index) in workData">
          <el-tooltip placement="top" :key="work.hostname + work.createdAt">
            <div slot="content">{{work.hostname}}</div>
            <div v-if="work.status == 'FREE'" class="square_status pass_text">
              <span>{{index + 1}}</span>
              <!-- <p>{{work.hostname | subStr}}</p> -->
            </div>
          </el-tooltip>
        </template>
        <template  v-for="(work, index) in workData">
          <el-tooltip placement="top" :key="index + work.createdAt">
            <div slot="content">{{work.hostname}}</div>
            <div v-if="work.status == 'WORKING'" class="square_status executing_text">
                <span>{{index + 1}}</span>
                <!-- <p>{{work.hostname | subStr}}</p> -->
            </div>
          </el-tooltip>
        </template>
        <template  v-for="(work, index) in workData">
          <el-tooltip placement="top" :key="index + work.hostname + work.createdAt">
            <div slot="content">{{work.hostname}}</div>
            <div v-if="work.status == 'DOWN'" class="square_status hang_text">
                <span>{{index + 1}}</span>
                <!-- <p>{{work.hostname | subStr}}</p> -->
            </div>
          </el-tooltip>
        </template>
        <template  v-for="(work, index) in workData">
          <el-tooltip placement="top" :key="work.hostname + index + work.createdAt">
            <div slot="content">{{work.hostname}}</div>
            <div v-if="work.status == 'HOLD'" class="square_status fail_text">
                <span>{{index + 1}}</span>
                <!-- <p>{{work.hostname | subStr}}</p> -->
            </div>
          </el-tooltip>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import progressBar from './progressBar.vue'
  import moment from 'moment'
  export default {
    props: ['message'],
    data() {
      return {
        requestParam: {
          pageNumber: 1,
          pageSize: 15,
          orderBy: 'createdAt desc',
          ref: true
        },
        tableData: [],
        workData: [],
        lang: []
      }
    },
    computed: {
      ...mapGetters(['controlCenter', 'workers'])
    },
    watch: {
      controlCenter: function () {
        this.tableData = this.controlCenter
      },
      workers: function () {
        this.workData = this.workers
      }
    },
    mounted() {
      this.getControlCenter(this.requestParam)
      this.getWorkers()
      setInterval(() => {
        this.getControlCenter(this.requestParam)
        this.getWorkers()
      }, 30000)
    },
    created: function () {
      var message =  JSON.parse(this.message);
      // this.permissionRule = message.permissions;
      this.lang = message.lang;
    },
    methods: {
      ...mapActions(['getControlCenter', 'getWorkers']),
    },
    components: {
      progressBar
    }
  };
</script>
