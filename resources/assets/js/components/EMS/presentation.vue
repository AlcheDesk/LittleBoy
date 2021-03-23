<template>
  <div style="display: block; position: absolute; top: 0px; bottom: 0px; left: 0px; right: 0px; padding: 20px; background-color: A7A9AC;">
    <div style="background-color: #E2E2E2; display: inline-block; position: absolute; left: 20px; right: 20px; top: 20px; bottom: 20px;">
      <div style="height: 75px; padding-top: 10px; padding-left: 20px; display: block;">
        <div style="float: left; width: 30%; text-align: left; font-size: 18px;display: inline-block; padding: 15px 0px;">
          <div style="float: left; display: inline-block; padding: 5px 5px 0px;">
            <i class="fa fa-clipboard fa-2x" aria-hidden="true"></i>
          </div>
          <div style="float: left; display: inline-block; transform: translate(0, 8px); margin-left: 20px;">
            {{$route.name}}
          </div>
          <div style="float: left; display: inline-block;">
            <el-button type="primary" style="padding: 3px 7px; transform: translate(0, 8px); margin-left: 20px; border-radius: 10px;">{{ tableData.length }}</el-button>
          </div>
        </div>
        <div style="float: right; text-align: left; font-size: 15px; padding: 15px 20px; margin-right: 20px; display: inline-block;">
          <div></div>
          <div>
            <el-pagination
              @size-change="handleSizeChange"
              @current-change="handleCurrentChange"
              :current-page="currentPage4"
              :page-sizes="[10, 50, 100, 200]"
              :page-size="100"
              layout="total, sizes, prev, pager, next, jumper"
              :total="400">
          </el-pagination>
        </div>
        </div>
      </div>
      <div style="height: 55px; padding-top: 10px; padding-left: 20px; display: block; padding-right: 20px;">
        <el-row :gutter="10" style="width: 100%; height: 100%;">
          <el-col :span="3">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <el-tooltip placement="top">
                  <div slot="content">筛选状态：</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">筛选状态：</div>
                </el-tooltip>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-select v-model="searchObject.status" size="mini" placeholder="请选择">
                  <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                  </el-option>
                </el-select>
              </div>
            </div>
          </el-col>
          <el-col :span="3">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <el-tooltip placement="top">
                  <div slot="content">编号：</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">编号：</div>
                </el-tooltip>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-input v-model="searchObject.id" size="mini"></el-input>
              </div>
            </div>
          </el-col>
          <el-col :span="4">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <el-tooltip placement="top">
                  <div slot="content">名字：</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">名字：</div>
                </el-tooltip>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-input v-model="searchObject.name" size="mini"></el-input>
              </div>
            </div>
          </el-col>
          <el-col :span="4">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <el-tooltip placement="top">
                  <div slot="content">执行环境：</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">执行环境：</div>
                </el-tooltip>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-input v-model="searchObject.name" size="mini"></el-input>
              </div>
            </div>
          </el-col>
          <el-col :span="4">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <el-tooltip placement="top">
                  <div slot="content">开始执行日期：</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">开始执行日期：</div>
                </el-tooltip>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-date-picker
                size="mini"
                v-model="searchObject.startAt"
                type="date"
                placeholder="选择日期">
              </el-date-picker>
            </div>
            </div>
          </el-col>
          <el-col :span="4">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <div style="display: inline-block; float: left; width: 40%; padding: 0px; margin: 0px;">
                <el-tooltip placement="top">
                  <div slot="content">结束执行日期：</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">结束执行日期：</div>
                </el-tooltip>
              </div>
              <div style="display: inline-block; float: left; width: 60%; padding: 0px; margin: 0px;">
                <el-date-picker
                size="mini"
                v-model="searchObject.endAt"
                type="date"
                placeholder="选择日期">
              </el-date-picker>
              </div>
            </div>
          </el-col>
          <el-col :span="2">
            <div style="display: block; height: auto; padding: 18px 5px 0px;">
              <el-button size="mini" style="padding: 4px 5px; float: left;">过滤</el-button>
            </div>
          </el-col>
        </el-row>
      </div>
      <div style="top: 160px; bottom: 10px; left: 20px; position: absolute; right: 20px; display: block;">
        <div style="position: absolute; bottom: 0px; left: 0px; right: 0px; top: 0px; overflow: auto; display: block;">
          <el-table
            :data="tableData"
            stripe>
            <el-table-column
              prop="id"
              label="编号"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="name"
              label="名字"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="environment"
              label="执行环境"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="status"
              label="状态"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="remoteIp"
              label="创建者IP"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="task"
              label="程序"
              align="left"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <el-tooltip placement="top">
                  <div slot="content">View Applications</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <a href="#">View Applications</a>
                  </div>
                </el-tooltip>
              </template>
            </el-table-column>
            <el-table-column
              prop="log"
              label="报告"
              align="left"
              show-overflow-tooltip>
              <template slot-scope="scope">
                <el-tooltip placement="top"  >
                  <div slot="content">View Log</div>
                  <div style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <a href="#">View Log</a>
                  </div>
                </el-tooltip>
              </template>
            </el-table-column>
            <el-table-column
              prop="all"
              label="总结报告"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
            <el-table-column
              prop="createAt"
              label="创建于"
              align="left"
              show-overflow-tooltip>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        searchObject: {
          statue: null,
          id: null,
          name: '',
          startAt: '',
          endAt: ''
        },
        options: [{
          label: '你大爷',
          value: 1
        }, {
          label: '你二爷',
          value: 2
        }],
        currentPage4: 4,
        tableData: [{
          id: 0,
          priority: 0,
          name: 'AlcheDesk',
          environment: null,
          remoteIp: '111.111.111.111',
          createAt: '2017-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 15,
            WIP: 15,
            DONE: 20,
            ERROR: 12
          }
        }, {
          id: 1,
          priority: 1,
          name: 'AlcheDesk_1',
          environment: null,
          remoteIp: '1.1.1.11',
          createAt: '2012-09-19 22:12:21',
          status: 'DOWN',
          viewSummary: {
            NEW: 35,
            WIP: 24,
            DONE: 35,
            ERROR: 23
          }
        }, {
          id: 2,
          priority: 2,
          name: 'AlcheDesk_2',
          environment: null,
          remoteIp: '1.21.21.1',
          createAt: '2317-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 35,
            WIP: 14,
            DONE: 50,
            ERROR: 12
          }
        }, {
          id: 0,
          priority: 0,
          name: 'AlcheDesk',
          environment: null,
          remoteIp: '1.1.1.1',
          createAt: '2017-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 15,
            WIP: 15,
            DONE: 20,
            ERROR: 12
          }
        }, {
          id: 1,
          priority: 1,
          name: 'AlcheDesk_1',
          environment: null,
          remoteIp: '1.1.1.11',
          createAt: '2012-09-19 22:12:21',
          status: 'DOWN',
          viewSummary: {
            NEW: 35,
            WIP: 24,
            DONE: 35,
            ERROR: 23
          }
        }, {
          id: 2,
          priority: 2,
          name: 'AlcheDesk_2',
          environment: null,
          remoteIp: '1.21.21.1',
          createAt: '2317-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 35,
            WIP: 14,
            DONE: 50,
            ERROR: 12
          }
        }, {
          id: 0,
          priority: 0,
          name: 'AlcheDesk',
          environment: null,
          remoteIp: '1.1.1.1',
          createAt: '2017-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 15,
            WIP: 15,
            DONE: 20,
            ERROR: 12
          }
        }, {
          id: 1,
          priority: 1,
          name: 'AlcheDesk_1',
          environment: null,
          remoteIp: '1.1.1.11',
          createAt: '2012-09-19 22:12:21',
          status: 'DOWN',
          viewSummary: {
            NEW: 35,
            WIP: 24,
            DONE: 35,
            ERROR: 23
          }
        }, {
          id: 2,
          priority: 2,
          name: 'AlcheDesk_2',
          environment: null,
          remoteIp: '1.21.21.1',
          createAt: '2317-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 35,
            WIP: 14,
            DONE: 50,
            ERROR: 12
          }
        }, {
          id: 0,
          priority: 0,
          name: 'AlcheDesk',
          environment: null,
          remoteIp: '1.1.1.1',
          createAt: '2017-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 15,
            WIP: 15,
            DONE: 20,
            ERROR: 12
          }
        }, {
          id: 1,
          priority: 1,
          name: 'AlcheDesk_1',
          environment: null,
          remoteIp: '1.1.1.11',
          createAt: '2012-09-19 22:12:21',
          status: 'DOWN',
          viewSummary: {
            NEW: 35,
            WIP: 24,
            DONE: 35,
            ERROR: 23
          }
        }, {
          id: 2,
          priority: 2,
          name: 'AlcheDesk_2',
          environment: null,
          remoteIp: '1.21.21.1',
          createAt: '2317-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 35,
            WIP: 14,
            DONE: 50,
            ERROR: 12
          }
        }, {
          id: 0,
          priority: 0,
          name: 'AlcheDesk',
          environment: null,
          remoteIp: '1.1.1.1',
          createAt: '2017-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 15,
            WIP: 15,
            DONE: 20,
            ERROR: 12
          }
        }, {
          id: 1,
          priority: 1,
          name: 'AlcheDesk_1',
          environment: null,
          remoteIp: '1.1.1.11',
          createAt: '2012-09-19 22:12:21',
          status: 'DOWN',
          viewSummary: {
            NEW: 35,
            WIP: 24,
            DONE: 35,
            ERROR: 23
          }
        }, {
          id: 2,
          priority: 2,
          name: 'AlcheDesk_2',
          environment: null,
          remoteIp: '1.21.21.1',
          createAt: '2317-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 35,
            WIP: 14,
            DONE: 50,
            ERROR: 12
          }
        }, {
          id: 0,
          priority: 0,
          name: 'AlcheDesk',
          environment: null,
          remoteIp: '1.1.1.1',
          createAt: '2017-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 15,
            WIP: 15,
            DONE: 20,
            ERROR: 12
          }
        }, {
          id: 1,
          priority: 1,
          name: 'AlcheDesk_1',
          environment: null,
          remoteIp: '1.1.1.11',
          createAt: '2012-09-19 22:12:21',
          status: 'DOWN',
          viewSummary: {
            NEW: 35,
            WIP: 24,
            DONE: 35,
            ERROR: 23
          }
        }, {
          id: 2,
          priority: 2,
          name: 'AlcheDesk_2',
          environment: null,
          remoteIp: '1.21.21.1',
          createAt: '2317-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 35,
            WIP: 14,
            DONE: 50,
            ERROR: 12
          }
        }, {
          id: 0,
          priority: 0,
          name: 'AlcheDesk',
          environment: null,
          remoteIp: '1.1.1.1',
          createAt: '2017-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 15,
            WIP: 15,
            DONE: 20,
            ERROR: 12
          }
        }, {
          id: 1,
          priority: 1,
          name: 'AlcheDesk_1',
          environment: null,
          remoteIp: '1.1.1.11',
          createAt: '2012-09-19 22:12:21',
          status: 'DOWN',
          viewSummary: {
            NEW: 35,
            WIP: 24,
            DONE: 35,
            ERROR: 23
          }
        }, {
          id: 2,
          priority: 2,
          name: 'AlcheDesk_2',
          environment: null,
          remoteIp: '1.21.21.1',
          createAt: '2317-09-19 20:12:21',
          status: 'ERROR',
          viewSummary: {
            NEW: 35,
            WIP: 14,
            DONE: 50,
            ERROR: 12
          }
        }]
      }
    },
    methods: {
      handleSizeChange (val) {
        console.log(val)
      },
      handleCurrentChange (val) {
        console.log(val)
      }
    }
  };
</script>

<style scope>
  .constainer {
    background-color: white;
    position: absolute;
    text-align: left;
  }
  .el-date-editor.el-input {
    width: 100% !important;
  }
</style>
