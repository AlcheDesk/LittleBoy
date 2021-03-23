<template>
  <div>
    <project-tool-bar>
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/TestSetting/RunList/?page=1+25'>{{ lang.breadcrumb.run_list }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.list_detail }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="name" class="text_ellipsis">
        {{ runSettingMessage.name }}
      </div>
      <div slot="creator" class="text_ellipsis">
        {{ runSettingMessage.createdAt }}
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_run_sets_test_cases">
          <add :lang="lang" @testCaseAddDone="getMessageDetails"></add>
        </template>
        <template v-if="permissionRule.run_set_reference_run_set">
          <el-button class="button_text_table el_button_open" @click="showRefRunContainerDialog">{{ lang.operator.reference }}</el-button>
        </template>
        <template v-if="permissionRule.run_set_run">
          <notification :lang="lang"></notification>
          <el-button class="button_text_table el_button_open" @click="readRunDriverMessage">{{ lang.operator.view_drive }}</el-button>
          <el-button class="button_text_table" @click="showSetGroupDialog">{{ lang.operator.run }}</el-button>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getTestCaseContainer.data"
          style="width: 100%"
          :default-sort="{prop: 'id', order: 'descending'}"
          :row-class-name="setRowClassName"
          :span-method="arraySpanMethod"
          @sort-change="sortChange">
          <el-table-column
            :label="lang.table.id"
            prop="id"
            align="left"
            sortable="custom"
            :resizable="true"
            width="150">
            <template slot-scope="scope">
              <template v-if="scope.row.testCase">
                {{scope.row.testCase.id}}
              </template>
              <template v-else>
                {{scope.row.refRunSet.id}}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.testcase_name"
            align="left"
            prop="name"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="scope.row.testCase">
                <i class="icon_t"></i>
                {{scope.row.testCase.name}}
              </template>
              <template v-else>
                <i class="icon_l"></i>
                <span style="color: #129a92;">{{lang.table.reference_message}}</span> <span style="color: #5780a9; font-size: 20px; font-weight: 600;">{{scope.row.refRunSet.name}}</span>
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.project"
            :resizable="true"
            align="left"
            sortable="custom"
            prop="name"
            show-overflow-tooltip>
            <template slot-scope="scope">
              <template v-if="scope.row.testCase">
                <i class="icon_p"></i>
                {{scope.row.testCase.projectName}}
              </template>
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.create_at"
            prop="createdAt"
            show-overflow-tooltip>
              <template slot-scope="scope" v-if="scope.row.testCase">
                {{scope.row.testCase.createdAt}}
              </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.overwrite_name"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{scope.row.testCaseOverwrite ? scope.row.testCaseOverwrite.name : ''}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.driver_name"
            show-overflow-tooltip>
            <template slot-scope="scope">
              {{scope.row.driverPack ? scope.row.driverPack.name : ''}}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            align="left"
            :label="lang.table.testcase_comment"
            prop="comment"
            show-overflow-tooltip>
              <template slot-scope="scope" v-if="scope.row.testCase">
                {{scope.row.testCase.comment}}
              </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.operating"
            :resizable="true"
            align="left"
            width="250">
            <template slot-scope="scope">
              <template v-if="scope.row.testCase">
                <set-param :lang="lang" :permissionRule="permissionRule" :row="scope.row" @setParamDone="getMessageDetails"></set-param>
              </template>
              <template v-if="permissionRule.delete_run_sets_test_cases">
                <el-button class="button_text_table" @click="removeTestCaseContainer(scope)">{{lang.operator.delete}}</el-button>
              </template>
              <template v-if="permissionRule.add_run_sets_test_cases">
                <el-button class="button_text_table" @click="copyTestCaseContainer(scope)">{{lang.operator.copy}}</el-button>
              </template>
            </template>
          </el-table-column>
        </el-table>
      </template>
    </search-pagination>

    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.set_cluster"  :visible.sync="setGroupDialog">
      <el-form :model="group" :rules="paramValidationGroup" ref="group" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.execution_cluster" prop="group">
          <el-select v-model="group.group" @change="changeGroup" value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectGroups"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
          <el-switch
            v-model="debug"
            :active-text="lang.dialog.title.debug"
            :inactive-text="lang.dialog.title.prod">
          </el-switch>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.once_alarm">
          <el-row :gutter="20">
            <el-col :span="20">
              <el-date-picker
                v-model="group.onceTime"
                size="small"
                :disabled="onceAlarmStatu"
                :picker-options="pickerOptions"
                type="datetime"
                placeholder="Select date and time">
              </el-date-picker>
            </el-col>
            <el-col :span="4">
              <el-switch
                @change="changeOnceAlarmStatus"
                v-model="group.onceStatus">
              </el-switch>
            </el-col>
          </el-row>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.cycling_alarm">
          <el-row :gutter="20">
            <el-col :span="10">
              <el-time-picker
                v-model="group.cyclingTime"
                size="small" 
                :disabled="cycleAlarmStatu"
                placeholder="Any time">
              </el-time-picker>
            </el-col>
            <el-col :span="10">
              <el-select  :disabled="cycleAlarmStatu" v-model.trim="group.cyclingDates" clearable multiple required filterable value-key="label" size="small" :placeholder="lang.dialog.placeholder.select">
                <el-option 
                  v-for="obj in alarmSetSelect"
                  :key="obj.value"
                  :label="obj.value"
                  :value="obj.value">
                </el-option>
              </el-select>
            </el-col>
            <el-col :span="4">
              <el-switch
                @change="changeCycleAlarmStatus"
                v-model="group.cyclingStatus">
              </el-switch>
            </el-col>
          </el-row>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="setGroupDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="runTestCase('group')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog  :close-on-click-modal="false" :title="lang.dialog.title.refrence_list"  :visible.sync="refRunContainerDialog">
      <el-form :model="refRunContainer" ref="refRunContainer" :rules="paramValidationRefRunContainer" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="refRunSet">
          <el-select v-model.trim="refRunContainer.refRunSet" clearable required filterable value-key="name" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option 
              v-for="obj in getSelectRefRunContainer"
              :key="obj.label"
              :label="obj.label"
              :value="obj.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="refRunContainerDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="commitRefRunContainer('refRunContainer')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'
  import moment from 'moment'
  import Add from './Add'
  import SetParam from './SetParam'
  import Notification from './Notification'

  export default {
    props: ['message'],
    data() {
      var validatorParams = (rule, value, callback) => {
        if (rule.required && !value) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        pickerOptions: {
          disabledDate(time) {
            return time.getTime() < Date.now() - 8.64e7;
          }
        },
        permissionRule: {},
        lang: {},
        runListId: null,
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        runSettingMessage: {},
        orderBy: 'id desc',
        setGroupDialog: false,
        group: {
          group: '',
          onceTime: null,
          onceStatus: false,
          cyclingTime: null,
          cyclingDates: [],
          cyclingStatus: false
        },
        cycleAlarmStatu: true,
        onceAlarmStatu: true,
        paramValidationGroup: {
          group: [{required: true, validator: validatorParams }]
        },
        debug: false,


        refRunContainerDialog: false,
        refRunContainer: {
          refRunSet: ''
        },
        paramValidationRefRunContainer: {
          refRunSet: [{required: true, type: 'object', validator: validatorParams }]
        },
        alarmSetSelect: [{
          label: '星期一',
          value: 'MON'
        }, {
          label: '星期二',
          value: 'TUE'
        }, {
          label: '星期三',
          value: 'WED'
        }, {
          label: '星期四',
          value: 'THU'
        }, {
          label: '星期五',
          value: 'FRI'
        }, {
          label: '星期六',
          value: 'SAT'
        }, {
          label: '星期天',
          value: 'SUN'
        }],
      }
    },
    computed: {
      ...mapGetters(['getTestCaseContainer', 'getSelectGroups', 'getSelectRefRunContainer'])
    },
    watch: {
      getTestCaseContainer: function() {
        this.total = this.getTestCaseContainer.metadata.count;
      },
      getSelectGroups: function() {
        this.group.group = '';
        const groupRunSet = localStorage.getItem('groupRunSet');
        const groupRunSetId = localStorage.getItem('groupRunSetId');
        if (groupRunSetId == this.runListId) {
          this.getSelectGroups.forEach((item) => {
            if (item.label === groupRunSet) {
              this.group.group = groupRunSet;
            }
          });
        } else {
          this.group.group = this.getSelectGroups[0].value || '';
        }
      },
    },
    components: { Add, SetParam, Notification },
    methods: {
      ...mapActions(['readTestCaseContainer', 'addTestCaseContainer', 'deleteTestCaseContainer', 'runRunSetTestCases', 'readRunSettingForMessage', 'readGroups', 'readRunSetDriverMaps', 'readRefRunContainer', 'readCountRefRunContainer', 'readRunSetAlarmSet', 'addOrUpdateRunSetAlarmSet', 'deleteRunSetAlarmSet']),
      getMessageDetails() {
        const obj = {
          runSetId: this.runListId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.orderBy ? obj.data.orderBy = this.orderBy : null;
        this.readTestCaseContainer(obj);
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'id desc';
        }
        this.getMessageDetails();
      },
      removeTestCaseContainer(scope) {
        const str = scope.row.testCase ? (this.lang.dialog.title.delete_testcase_from_list + ' ' + '<i style="color: red;">' + scope.row.testCase.name + '</i>' + ' ' + this.lang.dialog.title.delete_from_list_continue) : (this.lang.dialog.title.delete_referen_list_from_list + ' ' + '<i style="color: red;">' + scope.row.refRunSet.name + '</i>' + ' ' + this.lang.dialog.title.delete_from_list_continue);

        this.$confirm(str, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = {
            id: scope.row.id
          };
          this.deleteTestCaseContainer(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err.response.data);
          })
        }).catch(() => {
          this.$message({
            type:'info',
            message: this.lang.operator.undelete
          });
        });
      },
      copyTestCaseContainer(scope) {
        const str = this.lang.dialog.title.copy + ' ' + '<i style="color: red;">' + scope.row.testCase.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue;

        this.$confirm(str, this.lang.dialog.title.copy, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = { runSetId: this.runListId, testCaseId: scope.row.testCaseId };
          this.addTestCaseContainer([obj]).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err.response.data);
          })
        }).catch(() => {
          this.$message({
            type:'info',
            message: this.lang.operator.uncopy
          });
        });
      },
      showSetGroupDialog() {
        let str = '';
        let testCaseArr = new Set();
        this.getTestCaseContainer.data.forEach((item) => {
          if (!item.hasOwnProperty('driverPackId')) {
            if (item.hasOwnProperty('testCase')) {
              testCaseArr.add(item.testCase.name)
            }
          }
        })
        str = [...testCaseArr].join(',');
        if (this.getTestCaseContainer.metadata.count > 0 && this.getTestCaseContainer.data.length > 0) {
          if (testCaseArr.size && testCaseArr.size > 0) {
            this.$notify.error({
              title: this.lang.dialog.title.lack_driver_pack,
              dangerouslyUseHTMLString: true,
              message: this.lang.dialog.title.test_case + '<i style="color: teal;">' + str + '</i>' + this.lang.dialog.title.lack_driver_pack,
              position: 'bottom-right'
            });
            return false;
          } else {
            this.setGroupDialog = true;
          }
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.run_fail,
            message: this.lang.dialog.title.fail_message,
            position: 'bottom-right'
          });
        }
        const obj = {
          pageSize: 'all'
        }
        this.readGroups(obj);
        this.group.group = '';
        this.debug = false;
        this.group.onceTime = '';
        this.group.onceStatus = false;
        this.group.cyclingTime = '';
        this.group.cyclingStatus = false;
        this.group.cyclingDates = [];
        const param = {
          id: this.runListId
        }
        this.readRunSetAlarmSet(param).then((res) => {
          var cycle = null;
          var once = null;
          if (!res.data.length) {
            this.group.onceTime = '';
            this.group.onceStatus = false;
            this.group.cyclingTime = '';
            this.group.cyclingStatus = false;
            this.group.cyclingDates = [];
            return false;
          }
          for (let i = 0; i < res.data.length; i++) {
            if (res.data[i].cronDetails) {
              cycle = res.data[i];
            } else {
              once = res.data[i];
            }
          }

          if (cycle && cycle.cronDetails) {
            const Time = [cycle.cronDetails.hours, cycle.cronDetails.minutes, cycle.cronDetails.seconds];
            this.group.cyclingTime = moment(Time, 'HH:mm:ss');
            this.group.cyclingDates = cycle.cronDetails.dayOfWeek.split(',');
            this.group.cyclingName = cycle.name;
            if (cycle.status == 'SCHEDULED') {
              this.group.cyclingStatus = true;
              this.cycleAlarmStatu = false;
            } else {
              this.group.cyclingStatus = false;
              this.cycleAlarmStatu = true;
            }
          }

          if (once && once.name) {
            this.group.onceTime = once.nextFireTime;
            this.group.onceName = once.name;
            if (once.status == 'SCHEDULED') {
              this.group.onceStatus = true;
              this.onceAlarmStatu = false;
            } else {
              this.group.onceStatus = false;
              this.onceAlarmStatu = true;
            }
          }
        }, (err) => {
          console.log(err)
        })
      },
      runTestCase(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              runSetId: this.runListId
            };
            const param = {};
            if (this.debug) {
              param.type = 'DEVELOPMENT';
            } else {
              param.type = 'PRODUCTION';
            }
            param.group = this.group.group;
            obj.data = [param];
            this.setGroupDialog = false;
            if (!this.group.cyclingStatus && !this.group.onceStatus) {
              this.runRunSetTestCases(obj).then((res) => {
                if (res) {
                  if (this.debug) {
                    this.$notify.success({
                      title: this.lang.dialog.title.debug_start,
                      message: this.lang.dialog.title.debug_message,
                      position: 'bottom-right'
                    });
                  } else {
                    this.$notify.success({
                      title: this.lang.dialog.title.prod_start,
                      message: this.lang.dialog.title.prod_message,
                      position: 'bottom-right'
                    });
                  }
                }
              }, (err) => {
                console.log(err);
              });
            } else {
              const onceAlarm = {};
              const cyclingAlarm = {};
              if (this.group.onceStatus) {
                onceAlarm.startTimeTimestamp = moment(this.group.onceTime).format('x');
                onceAlarm.status = 'SCHEDULED';
                const once = {
                  id: this.runListId,
                  data: [onceAlarm]
                };
                this.addOrUpdateRunSetAlarmSet(once).then((res) =>{
                  this.$notify.success({
                    title: this.lang.dialog.title.set_once_success,
                    message: this.lang.dialog.title.set_once_message,
                    position: 'bottom-right'
                  });
                }, (err) => {
                  console.log(err);
                })
              }
              if (this.group.cyclingStatus) {
                cyclingAlarm.cronDetails = {};
                cyclingAlarm.cronDetails.dayOfWeek = this.group.cyclingDates.join(',');
                cyclingAlarm.cronDetails.hours = moment(this.group.cyclingTime).hours();
                cyclingAlarm.cronDetails.minutes = moment(this.group.cyclingTime).minutes();
                cyclingAlarm.cronDetails.seconds = moment(this.group.cyclingTime).seconds();
                const cycling = {
                  id: this.runListId,
                  data: [cyclingAlarm]
                };
                this.addOrUpdateRunSetAlarmSet(cycling).then((res) =>{
                  this.$notify.success({
                    title: this.lang.dialog.title.set_cycling_success,
                    message: this.lang.dialog.title.set_ocycling_message,
                    position: 'bottom-right'
                  });
                }, (err) => {
                  console.log(err);
                })
              }
            }
          }
        })
      },
      readRunDriverMessage() {
        const param = {
          runSetId: this.runListId
        };
        this.readRunSetDriverMaps(param).then((res) => {
          this.driverStr = '';
          res.data.forEach((item) => {
            this.driverStr = this.driverStr + item.name + ',';
          });
          const str = this.driverStr;
          this.$confirm(this.lang.dialog.title.drive_need + ' ' + '<i style="color: red;">' + str + '</i>', this.lang.dialog.title.drive_dep, {
            confirmButtonText: this.lang.operator.confirm,
            cancelButtonText: this.lang.operator.cancel,
            type: 'warning',
            dangerouslyUseHTMLString: true
          }).then(() => {
            console.log('')
          }).catch(() => {
            console.log('')
          });
        }, (err) => {
          console.log('')
        })
      },
      changeGroup(obj) {
        localStorage.setItem('groupRunSet', obj);
        localStorage.setItem('groupRunSetId', this.runListId);
      },
      showRefRunContainerDialog() {
        this.refRunContainer.refRunSet = '';
        const param = {
          runSetId: this.runListId
        };
        this.readCountRefRunContainer(param).then((res) => {
          if (res.metadata.count) {
            this.$notify.error({
              title: this.lang.dialog.title.operation_error,
              message: this.lang.dialog.title.error_message_run_list,
              position: 'bottom-right'
            });
          } else {
            const obj = {
              runSetId: this.runListId,
              pageSize: 'all',
              pageNumber: 1
            };
            this.readRefRunContainer(obj);
            this.refRunContainerDialog = true;
          }
        }, (err) => {
          console.log(err);
        })
      },
      commitRefRunContainer(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              runSetId: this.runListId,
              refRunSetId:this.refRunContainer.refRunSet.id
            };
            this.addTestCaseContainer([obj]).then((res) => {
              this.getMessageDetails();
            }, (err) => {
              console.log(err);
            });
            this.refRunContainerDialog = false;
          }
        })
      },
      setRowClassName({row, rowIndex}) {
        if (row.hasOwnProperty('refRunSet')) {
          return 'row_refRunSet row_css'
        } else {
          return 'row_css';
        }
      },
      arraySpanMethod({row, column, rowIndex, columnIndex}) {
        if (row.hasOwnProperty('refRunSet')) {
          if (columnIndex === 1) {
            return {
              rowspan: 1,
              colspan: 6
            };
          } else if (columnIndex === 0 || columnIndex === 7) {
            return {
              rowspan: 1,
              colspan: 1
            }
          } else {
            return {
              rowspan: 0,
              colspan: 0
            };
          }
        }
      },
      changeOnceAlarmStatus(status) {
        if (status) {
          this.onceAlarmStatu = false;
        } else {
          this.onceAlarmStatu = true;
        }
        if (!status && this.group.onceName) {
          const obj = {
            id: this.runListId,
            uuid: this.group.onceName
          };
          this.deleteRunSetAlarmSet(obj).then((res) => {
            this.group.onceTime = '';
            this.group.onceName = '';
            this.$notify.success({
              title: this.lang.operator.cancel_once_success,
              message: this.lang.operator.cancel_once_message,
              position: 'bottom-right'
            });
          })
        }
      },
      changeCycleAlarmStatus(status) {
        if (status) {
          this.cycleAlarmStatu = false;
        } else {
          this.cycleAlarmStatu = true;
        }
        if (!status && this.group.cyclingName) {
          const obj = {
            id: this.runListId,
            uuid: this.group.cyclingName
          }
          this.deleteRunSetAlarmSet(obj).then((res) => {
            this.group.cyclingTime = '';
            this.group.cyclingDates = [];
            this.group.cyclingName = '';
            this.$notify.success({
              title: this.lang.operator.cancel_cycling_success,
              message: this.lang.operator.cancel_ocycling_message,
              position: 'bottom-right'
            });
          })
        }
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
      const param = {
        id: this.runListId
      };
      this.readRunSettingForMessage(param).then((res) => {
        this.runSettingMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>
