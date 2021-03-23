<template>
  <div>
    <project-container>
      <div slot="toolbar">
        <project-tool-bar>
          <div slot="breadcrumb">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item>
                <a href='/atm/TestSetting/Project/?page=1+25'>{{ lang.breadcrumb.project_lib }}</a>
              </el-breadcrumb-item>
              <el-breadcrumb-item >
                <a :href="'/atm/TestSetting/Project/' + projectId + '/TestCase/?page=1+25'">{{ lang.breadcrumb.test_case }}</a>
              </el-breadcrumb-item>
              <el-breadcrumb-item>{{ lang.breadcrumb.instruction }}</el-breadcrumb-item>
            </el-breadcrumb>
          </div>
          <div slot="name" class="text_ellipsis">
            {{ testCaseMessage.projectName + '/' + testCaseMessage.name}}
          </div>
          <div slot="creator" class="text_ellipsis">
            {{testCaseMessage.createdAt}}
            <el-tag
              :key="tag.name"
              size="small"
              style="margin-right: 8px;"
              v-for="tag in testCaseMessage.tags">
              {{tag.name}}
            </el-tag>
          </div>
          <div slot="operation">
            <!-- <template v-if="permissionRule.add_instruction_bundle_entry">
              <instruction-insert-bundle :lang="lang"></instruction-insert-bundle>
            </template> -->
            <template v-if="permissionRule.run_test_case">
              <el-button class="button_text_table el_button_open" @click="readRunDriverMessage">{{ lang.operator.view_drive }}</el-button>
              <el-button class="button_text_table" @click="showSetGroupDialog">{{ lang.operator.run }}</el-button>
            </template>
          </div>
        </project-tool-bar>
      </div>
      <div slot="container">
        <el-row>
          <el-col :span="5" class="left_menu_table">
            <div class="search_bar search_item_name">
              <el-input @keyup.native="getMessageDetails" :placeholder="lang.dialog.placeholder.enter_name" v-model.trim="queryObj.name" clearable @clear="getMessageDetails" @blur="getMessageDetails" size="mini"></el-input>
            </div>
            <el-table
              ref="singleTable"
              :data="getProjectTestCase.data"
              :show-header="false"
              highlight-current-row
              @row-click="navigationToProjectCaseInstructions"
              row-class-name="row_css"
              style="margin-top: -5px;">
              <el-table-column
                :resizable="true"
                prop="name"
                align="left"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <i class="icon_t"></i>
                  {{scope.row.name}}
                </template>
              </el-table-column>
            </el-table>
            <el-pagination
              @current-change="handleCurrentChange"
              layout="total, prev, next, jumper"
              :total="total"
              :current-page="parseInt(queryObj.pageNumber)"
              :page-size="parseInt(queryObj.pageSize)"
              style="text-align: left;">
            </el-pagination>
          </el-col>
          <el-col :span="19">
            <testCaseInstruction :testCaseName="testCaseMessage.name" :message="message"></testCaseInstruction>
          </el-col>
        </el-row>
      </div>
    </project-container>

    <el-dialog  :title="lang.dialog.title.set_cluster" :close-on-click-modal="false" :visible.sync="setGroupDialog" :show-close="false">
      <el-form :model="group" :rules="paramValidationGroup" ref="group" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.execution_cluster" prop="group">
          <el-select v-model="group.group" value-key="name" @change="changeGroup" clearable size="small" filterable :placeholder="lang.dialog.placeholder.select">
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
        <el-form-item :label="lang.dialog.title.overwrite_name">
          <el-select v-model="group.config" clearable value-key="name" size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectTestCaseOverwrites"
                :key="item.label"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.drive_pack" prop="packsDrivers">
          <el-select v-model="group.packsDrivers" value-key="name" clearable size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="(item, index) in getSelectTestCaseDriverPacks"
              :key="item.label + index"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="setGroupDialog = false">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="runTestCase('group')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { mapGetters, mapActions, mapMutations} from 'vuex'
  import testCaseInstruction from './testCaseInstruction'
  import instructionInsertBundle from './instructionInsertBundle'

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
        projectId: null,
        testCaseId: null,
        permissionRule: {},
        lang: {},
        hiddenInstructions: [],
        testCaseMessage: {},
        paramValidationGroup: {
          group: [{required: true, type: 'object', validator: validatorParams }],
          packsDrivers: [{required: true, type: 'object', validator: validatorParams }]
        },
        setGroupDialog: false,
        group: {
          group: '',
          packsDrivers: '',
          config: {}
        },
        debug: false,
        packs: [],
        driverStr: '',
        orderBy: 'id desc',
        queryObj: {
          name: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0,
        pageNumberSave: 1
      }
    },
    watch: {
      getProjectTestCase: function() {
        this.total = this.getProjectTestCase.metadata.count;
        this.pageNumberSave = this.queryObj.pageNumber;
        var data = {};
        for (let i = 0; i < this.getProjectTestCase.data.length; i++) {
          if (this.getProjectTestCase.data[i].id == this.testCaseId) {
            data = this.getProjectTestCase.data[i];
            this.$nextTick(() => {
              this.$refs.singleTable.setCurrentRow(data);
            })
          }
        }
      },
      getSelectGroups: function() {
        this.group.group = '';
        const group = localStorage.getItem('group');
        const groupTestCaseId = localStorage.getItem('groupTestCaseId');
        if (groupTestCaseId == this.testCaseId) {
          this.getSelectGroups.forEach((item) => {
            if (item.label === group) {
              this.group.group = group;
            }
          });
        } else {
          this.group.group = this.getSelectGroups[0].value || '';
        }
      },
      getSelectTestCaseDriverMaps: function() {
        this.driverStr = '';
        this.getSelectTestCaseDriverMaps.forEach((item) => {
          this.driverStr = this.driverStr + item.label + ',';
        });
      }
    },
    computed:{
      ...mapGetters(['getProjectTestCase', 'getSelectGroups', 'getTestCaseInstructions', 'getDriverType', 'getSelectTestCaseDriverMaps', 'getSelectTestCaseDriverPacks', 'getSelectTestCaseOverwrites']),
    },
    components: { testCaseInstruction, instructionInsertBundle },
    methods: {
      ...mapActions(['readProjectTestCases', 'readTestCaseInstructions', 'runTestCases', 'readTestCaseForMessage', 'readGroups', 'readTestCaseDriverMaps', 'readTestCaseDriverPacks', 'readTestCaseOverWrites']),
      navigationToProjectCaseInstructions(row, event, column) {
        this.testCaseMessage = row;
        let obj = {};
        obj.testCaseId = row.id;
        obj.data = {
          pageNumber: 1,
          pageSize: 25
        };
        this.readTestCaseInstructions(obj);
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase/' + row.id + '/Instruction/?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        obj.projectId = this.projectId;
        obj.data = {
          name: this.queryObj.name,
          pageNumber: this.queryObj.pageNumber,
          pageSize: this.queryObj.pageSize,
          location: true,
        };
        obj.data.orderBy = this.orderBy;
        this.readProjectTestCases(obj);
      },
      readRunDriverMessage() {
        const param = {
          testCaseId: this.testCaseId
        };
        this.readTestCaseDriverMaps(param).then((res) => {
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
      showSetGroupDialog() {
        if (this.getTestCaseInstructions.metadata.count > 0 && this.getTestCaseInstructions.data.length > 0) {
          this.setGroupDialog = true;
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
        this.group.config = '';
        this.group.packsDrivers = '';
        this.debug = false;
        const param = {
          testCaseId: this.testCaseId,
          type: 'forTestCaseOverwrite',
          data: {
            pageNumber: 1,
            pageSize: 'all',
            orderBy: 'id desc'
          }
        };
        this.readTestCaseOverWrites(param);
        this.readTestCaseDriverPacks(param);
      },
      runTestCase(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              testCaseId: this.testCaseId
            };
            const param = {};
            if (this.debug) {
              param.type = 'DEVELOPMENT';
            } else {
              param.type = 'PRODUCTION';
            }
            param.group = this.group.group;
            param.driverPackId = this.group.packsDrivers.id;
            param.testCaseOverwriteId = this.group.config.id;
            obj.data = [param];
            this.setGroupDialog = false;
            this.runTestCases(obj).then((res) => {
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
            })
          }
        })
      },
      changeGroup(obj) {
        localStorage.setItem('group', obj);
        localStorage.setItem('groupTestCaseId', this.testCaseId);
      },
      handleCurrentChange(val) {
        this.queryObj.pageNumber = val;
        localStorage.setItem('caseCurrentPage', val);
        this.getMessageDetails();
      },
    },
    created: function () {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
      console.log("hiddenInstructions:" + message.hiddenInstructions);
      this.hiddenInstructions = message.hiddenInstructions || [];
      console.log("hiddenInstructions to Vue:" + this.hiddenInstructions);
      this.projectId = window.location.pathname.split('/')[4];
      this.testCaseId = window.location.pathname.split('/')[6];
      this.$set(this.queryObj, 'pageNumber', localStorage.getItem('caseCurrentPage') || 1);
      this.$set(this.queryObj, 'pageSize', localStorage.getItem('caseCurrentSize') || 25);
      this.orderBy = localStorage.getItem('caseOrderBy') || 'id desc';
    },
    mounted() {
      this.getMessageDetails();
      const testCase = {
        id: this.testCaseId
      };
      this.readTestCaseForMessage(testCase).then((res) => {
        this.testCaseMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>

