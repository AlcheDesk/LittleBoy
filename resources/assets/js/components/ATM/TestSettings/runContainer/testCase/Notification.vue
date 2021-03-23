<template>
  <div class="component_button">
    <el-button class="button_text_table el_button_open" @click="showRunSetNotificationDialog">{{ lang.operator.notification_setting }}</el-button>

    <el-dialog :close-on-click-modal="false" :visible.sync="setRunSetNotificationDialog" :show-close="false" :append-to-body="true">
      <div slot="title">
        {{lang.dialog.title.set_run_list}}
        <el-button class="button_text_table el_button_open el_button_right" @click="showNotificationManageDialog">{{ lang.dialog.title.notification_manage }}</el-button>
      </div>
      <el-form :model="RunSetNotification" ref="RunSetNotification" label-width="150px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.add_notification">
          <div style="display: flex;">
            <div style="flex: 8">
              <el-select v-model="RunSetNotification.notification" multiple clearable required filterable value-key="id" size="small" :placeholder="lang.dialog.placeholder.select">
                <el-option
                  v-for="item in getSelectNotifications"
                    :key="item.label"
                    :label="item.label"
                    :value="item.value">
                </el-option>
              </el-select>
            </div>
            <div style="flex: 2; text-align: center;">
              <el-button class="button_text_table el_button_open" @click="addRunSetNotificationLink">{{lang.operator.add_to_notification_list}}</el-button>
            </div>
          </div>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.notification_list">
          <template v-for="(item, index) in getRunSetNotifications.data">
            <el-card class="box-card" shadow="hover">
              <div style="display: flex;">
                <el-popover
                  :ref="'name' + index"
                  placement="top"
                  trigger="click">
                  <div>{{item.emailNotificationTargets.length && item.emailNotificationTargets.map((item) => { return item.name }).join(',') || ''}}</div>
                </el-popover>
                <div style="flex: 2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" v-popover:name="'name' + index">
                  <span>{{item.emailNotificationTargets.length && item.emailNotificationTargets.map((item) => { return item.name }).join(',') || ''}}</span>
                </div>
                <el-popover
                  :ref="'subject' + index"
                  placement="top"
                  trigger="click">
                  <div>{{item.subject}}</div>
                </el-popover>
                <div style="flex: 6; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" v-popover:subject="'subject' + index">
                  <span>{{item.subject}}</span>
                </div>
                <div style="flex: 4;">
                  <el-button class="el-icon-error" @click="deleteRunSetNotificationLink(item)" size="small" type="text"></el-button>
                  <el-button size="small" type="text" @click="showUpdateNotificationOperationDialog(item)">{{ lang.dialog.title.see_detail }}</el-button>
                </div>
              </div>
            </el-card>
          </template>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="setRunSetNotificationDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :visible.sync="notificationManageDialog" :show-close="false" :append-to-body="true">
      <div slot="title">
        {{lang.dialog.title.notification_manage}}
        <el-button class="el_button_open el_button_right" size="mini" @click="showNotificationOperationDialog">{{ lang.dialog.title.add_notification }}</el-button>
      </div>
      <el-form label-width="0px" label-position="right" label-suffix=":">
        <el-form-item>
          <template v-for="(item, i) in getSelectNotifications">
            <el-card class="box-card" shadow="hover">
              <div style="display: flex;">
                <el-popover
                  :ref="'name2' + i"
                  placement="top"
                  trigger="click">
                  <div>{{item.value.emailNotificationTargets.length && item.value.emailNotificationTargets.map(item => { return item.name }).join(',') || ''}}</div>
                </el-popover>
                <div style="flex: 2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" v-popover:name="'name2' + i">
                  <span>{{item.value.emailNotificationTargets.length && item.value.emailNotificationTargets.map(item => { return item.name }).join(',') || ''}}</span>
                </div>
                <el-popover
                  :ref="'subject2' + i"
                  placement="top"
                  trigger="click">
                  <div>{{item.value.subject}}</div>
                </el-popover>
                <div style="flex: 6; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" v-popover:subject="'subject2' + i">
                  <span>{{item.value.subject}}</span>
                </div>
                <div style="flex: 4;">
                  <el-button class="el-icon-error" @click="removeNotification(item.value)" size="small" type="text"></el-button>
                  <el-button size="small" @click="showUpdateNotificationOperationDialog(item.value)" type="text">{{ lang.dialog.title.see_detail }}</el-button>
                </div>
              </div>
            </el-card>
          </template>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="notificationManageDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :visible.sync="newNotificationOperationDialog" :show-close="false" :append-to-body="true">
      <div slot="title">
        {{lang.dialog.title.set_notification}}
        <el-button class="button_text_table el_button_open el_button_right" @click="showRecipientManageDialog">{{ lang.dialog.title.recipient_manage }}</el-button>
      </div>
      <el-form :model="notification" ref="notification" :rules="paramValidationNotification" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.dialog.title.recipient" prop="recipient">
          <el-select v-model.trim="notification.recipient" multiple clearable required filterable value-key="id" size="small" :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectRecipients"
                :key="item.label + item.value.id"
                :label="item.label"
                :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.theme" prop="subject">
          <el-input size="small" :maxlength="32" v-model.trim="notification.subject" :placeholder="lang.dialog.placeholder.enter"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.input" prop="messages">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter" v-model.trim="notification.messages"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('notification')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitNotification('notification')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :visible.sync="recipientManageDialog" :show-close="false" :append-to-body="true">
      <div slot="title">
        {{lang.dialog.title.recipient_manage}}
        <el-button class="el_button_open el_button_right" size="mini" @click="showAddRecipientDialog">{{ lang.dialog.title.add_recipient }}</el-button>
      </div>
      <el-form label-width="0px" label-position="right" label-suffix=":">
        <el-form-item>
          <el-table
            :data="getRecipients.data"
            row-class-name="row_css"
            style="width: 100%">
            <el-table-column
            align="left"
            prop="name"
            show-overflow-tooltip
            :label="lang.table.name">
            </el-table-column>
            <el-table-column
              prop="emailAddress"
              align="left"
              show-overflow-tooltip
              :label="lang.dialog.title.email">
            </el-table-column>
            <el-table-column
              align="right"
              show-overflow-tooltip
              :label="lang.table.operating">
              <template slot-scope="scope">
                <el-button class="el-icon-edit" @click="showupdateRecipientDialog(scope.row)" size="small" type="text"></el-button>
                <el-button class="el-icon-error" @click="sremoveRecipientDialog(scope.row)" size="small" type="text"></el-button>
              </template>
            </el-table-column>
          </el-table>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="recipientManageDialog = false">{{ lang.operator.cancel }}</el-button>
      </div>
    </el-dialog>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.set_recipient" :visible.sync="addRecipientDialog" :show-close="false" :append-to-body="true">
      <el-form :model="recipient" ref="recipient" :rules="paramValidationRecipient" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input size="small" :maxlength="32" v-model.trim="recipient.name" :placeholder="lang.dialog.placeholder.enter_name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.dialog.title.email" prop="emailAddress">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_email" v-model.trim="recipient.emailAddress"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('recipient')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="submitRecipient('recipient')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: {
      lang: {
        default: {},
      },
    },
    data() {
      var validateEmailAddress = (rule, value, callback) => {
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        const obj = {
          emailAddress: value
        };
        if (this.recipientType === 'add') {
          var reg = /^((([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6}\;))*(([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})))$/;
          if (!reg.test(value)) {
            callback(new Error(this.lang.validator.email))
          } else {
            this.countEmailsAddress(obj).then((res) => {
              if (!res.metadata.count) {
                callback();
              } else {
                callback(new Error(this.lang.validator.name.exist))
              }
            })
          }
        };
        if (this.recipientType ==='edit') {
          if (value != this.updateEmailAdress) {
            this.countEmailsAddress(obj).then((res) => {
              if (parseInt(res.metadata.count) === 0) {
                return callback();
              } else {
                return callback(new Error(this.lang.validator.name.exist));
              }
            }, (err) => {
              console.log(err)
            });
          } else {
            return callback();
          }
        }
      };
      var validatorParams = (rule, value, callback) => {
        if (rule.required && !value) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        runListId: null,
        setRunSetNotificationDialog: false,
        RunSetNotification: {
          notification: ''
        },
        notificationManageDialog: false,
        newNotificationOperationDialog: false,
        notificationType: '',
        recipientManageDialog: false,
        addRecipientDialog: false,
        paramValidationNotification: {
          subject: [{required: true, validator: validatorParams }],
          recipient: [{required: true, type: 'array', validator: validatorParams }],
          messages: [{required: true, validator: validatorParams }]
        },
        notification: {
          subject: '',
          recipient: [],
          messages: ''
        },
        recipient: {
          name: '',
          emailAddress: ''
        },
        recipientType: '',
        paramValidationRecipient: {
          name: [{required: true, validator: validatorParams }],
          emailAddress: [{required: true, validator: validateEmailAddress }],
        },
        updateEmailAdress: '',
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
      };
    },
    computed: {
      ...mapGetters(['getRunSetNotifications', 'getSelectNotifications', 'getSelectRecipients', 'getRecipients'])
    },
    methods: {
      ...mapActions(['readRunSetNotification', 'addRunSetNotification', 'deleteRunSetNotification', 'readNotification', 'addNotification', 'updateNotification', 'deleteNotification', 'readRecipient', 'addRecipient', 'updateRecipient', 'deleteRecipient', 'countEmailsAddress']),
      cancel(formname) {
        this.addRecipientDialog = false;
        this.newNotificationOperationDialog = false;
        this.$refs[formname].resetFields();
      },
      showRunSetNotificationDialog() {
        this.setRunSetNotificationDialog = true;
        this.RunSetNotification.notification = '';
        const obj = {
          runSetId: this.runListId
        };
        this.readRunSetNotification(obj);
        this.readNotification();
      },
      addRunSetNotificationLink() {
        if (this.RunSetNotification.notification.length) {
          const obj = {
            runSetId: this.runListId
          };
          obj.data = [];
          this.RunSetNotification.notification.forEach((item) => {
            obj.data.push({ id: item.id }) 
          });
          this.addRunSetNotification(obj).then((res) => {
            const param = {
              runSetId: this.runListId
            };
            this.readRunSetNotification(param);
            this.RunSetNotification.notification = '';
          })
        } else {
          this.$notify.error({
            title: this.lang.dialog.title.operation_error,
            message: this.lang.dialog.title.please_select_notification,
            position: 'bottom-right'
          });
        }
      },
      deleteRunSetNotificationLink(row) {
        const obj = {
          runSetId: this.runListId,
          id: row.id
        };
        this.$confirm(this.lang.dialog.title.delete_notification_from_list + row.subject, this.lang.dialog.title.delete_list_notification, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning'
        }).then(() => {
          this.deleteRunSetNotification(obj).then((res) => {
            const param = {
              runSetId: this.runListId
            };
            this.readRunSetNotification(param);
          })
        }).catch((err) => {
          this.$message({
            type:'info',
            message: this.lang.dialog.title.unedit
          });
        });
      },
      showNotificationManageDialog() {
        this.notificationManageDialog = true;
      },
      showNotificationOperationDialog() {
        this.notificationType = 'add';
        this.newNotificationOperationDialog = true;
        this.notification.recipient = [];
        this.notification.subject = '';
        this.notification.messages = '';
        this.readRecipient();
      },
      showUpdateNotificationOperationDialog(row) {
        this.notificationType = 'edit';
        this.newNotificationOperationDialog = true;
        this.notification.recipient = row.emailNotificationTargets;
        this.notification.id = row.id;
        this.notification.subject = row.subject;
        this.notification.messages = row.messages;
        this.readRecipient();
      },
      submitNotification(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              subject: this.notification.subject,
              messages: this.notification.messages
            };
            this.notification.id ? obj.id = this.notification.id : null;
            obj.emailNotificationTargets = this.notification.recipient.map(item => { return { id: item.id } });
            if (this.notificationType == 'add') {
              this.addNotification([obj]).then((res) => {
                this.readNotification();
                const param = {
                  runSetId: this.runListId
                };
                this.readRunSetNotification(param);
              });
            }
            if (this.notificationType == 'edit') {
              this.updateNotification([obj]).then((res) => {
                this.readNotification();
                const param = {
                  runSetId: this.runListId
                };
                this.readRunSetNotification(param);
              });
            }
            this.newNotificationOperationDialog = false;
          }
        })
      },
      removeNotification(row) {
        const obj = {
          id: row.id
        };
        this.$confirm(this.lang.dialog.title.delete_notification_message + row.subject, this.lang.dialog.title.delete_notification, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning'
        }).then(() => {
          this.deleteNotification(obj).then((res) => {
            this.readNotification();
          })
        }).catch((err) => {
          this.$message({
            type:'info',
            message: this.lang.dialog.title.unedit
          });
        });
      },
      showRecipientManageDialog() {
        this.recipientManageDialog = true;
      },
      showAddRecipientDialog() {
        this.addRecipientDialog = true;
        this.recipient.name = '';
        this.recipient.emailAddress = '';
        this.recipientType = 'add';
      },
      showupdateRecipientDialog(row) {
        this.addRecipientDialog = true;
        this.recipient.emailAddress = row.emailAddress;
        this.updateEmailAdress = row.emailAddress;
        this.recipient.name = row.name;
        this.recipientType = 'edit';
        this.recipient.id = row.id;
      },
      submitRecipient(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.recipient.name,
              emailAddress: this.recipient.emailAddress
            };
            if (this.recipientType === 'add') {
              this.addRecipient([obj]).then((res) => {
                this.readRecipient();
                this.addRecipientDialog = false;
              });
            }
            if (this.recipientType === 'edit') {
              obj.id = this.recipient.id;
              this.updateRecipient([obj]).then((res) => {
                this.readRecipient();
                this.addRecipientDialog = false;
              });
            }
            this.addRecipientDialog = false;
          }
        })
      },
      sremoveRecipientDialog(row) {
        const obj = {
          id: row.id
        };
        this.$confirm(this.lang.dialog.title.delete_recipient_message + row.name, this.lang.dialog.title.delete_recipient, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning'
        }).then(() => {
          this.deleteRecipient(obj).then((res) => {
            this.readRecipient();
          })
        }).catch((err) => {
          this.$message({
            type:'info',
            message: this.lang.dialog.title.unedit
          });
        });
      },
    },
    mounted() {
      this.runListId = window.location.pathname.split('/')[4];
    }
  };
</script>
