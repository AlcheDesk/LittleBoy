<template>
  <div>
    <project-tool-bar :messageInfo="instructionBundleEntryMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a href='/atm/TestSetting/InstructionBundle'>{{ lang.breadcrumb.instruction_bundle }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.bundle_entry }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_instruction_bundle_entry">
          <add :lang="lang" @entryAddDone="getMessageDetails" :orderIndexAdd="orderIndex"></add>
        </template>
      </div>
    </project-tool-bar>


    <search-pagination :total="total" layout="id, comment, operation" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getInstructionBundleEntry.data"
          row-class-name="row_css"
          :row-key="setRowKey"
          style="width: 100%">
          <el-table-column
            :label="lang.table.id"
            align="left"
            width="150">
              <template slot-scope="scope">
                {{scope.row.orderIndex}}
              </template>
          </el-table-column>
          <el-table-column
            :label="lang.table.instruction_type"
            align="left"
            prop="instructionType"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.table.element_type"
            align="left"
            prop="elementType"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :label="lang.table.instruction_action"
            align="left"
            prop="instructionAction"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            align="left"
            :label="lang.table.comment"
            prop="comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_instruction_bundle_entry || permissionRule.edit_instruction_bundle_entry">
            <el-table-column
              :label="lang.table.operating"
              align="left"
              width="150">
              <template slot-scope="scope">
                <template v-if="permissionRule.delete_instruction_bundle_entry">
                  <el-button class="button_text_table" @click="deleteInstructionBundleEntry(scope)">{{lang.operator.delete}}</el-button>
                </template>
                <template v-if="permissionRule.edit_instruction_bundle_entry">
                  <edit
                    :lang="lang"
                    @entryEditDone="getMessageDetails"
                    :row="scope.row">
                  </edit>
                </template>
              </template>
            </el-table-column>
          </template>
        </el-table>
      </template>
    </search-pagination>

  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import Sortable from 'sortablejs'
  import Add from './Add.vue'
  import Edit from './Edit.vue'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        bundleId: null,
        instructionBundleEntryMessage: {},
        list: [],
        sortable: null,
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
        orderIndex: 0,
      }
    },
    computed: {
      ...mapGetters(['getInstructionBundleEntry'])
    },
    components: { Add, Edit },
    watch: {
      getInstructionBundleEntry: function() {
        this.total = this.getInstructionBundleEntry.metadata.count;
        this.orderIndex = this.getInstructionBundleEntry.metadata.count;
        this.list = [];
        this.list = this.getInstructionBundleEntry.data.slice(0);
        if (this.permissionRule.edit_instruction_bundle_entry) {
          this.$nextTick(() => {
            this.setSort()
          })
        }
      }
    },
    methods: {
      ...mapActions(['readInstructionBundleEntry', 'removeInstructionBundleEntry', 'readInstructionBundleForMessage', 'editInstructionBundleEntry']),
      getMessageDetails() {
        const obj = {
          id: this.bundleId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = 'orderIndex asc';
        this.readInstructionBundleEntry(obj);
      },
      deleteInstructionBundleEntry(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.instructionType + '</i>' + '<i style="color: green;">' + (scope.row.instructionAction || '') + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = {
            id: scope.row.id
          };
          this.removeInstructionBundleEntry(obj).then((res) => {
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
      setSort() {
        const el = document.querySelectorAll('.el-table__body-wrapper > table > tbody')[0];
        this.sortable = Sortable.create(el, {
          ghostClass: 'sortable-ghost',
          dataIdAttr: 'orderIndex',
          setData: function(dataTransfer) {
            dataTransfer.setData('Text', '')
          },
          onEnd: evt => {
            const targetRow = this.list.splice(evt.oldIndex, 1)[0];
            const obj = {
              id: targetRow.id,
              // orderIndex: targetRow.orderIndex + (evt.newIndex - evt.oldIndex)
              orderIndex: targetRow.orderIndex + ((evt.newIndex - evt.oldIndex) > 0 ? (evt.newIndex - evt.oldIndex) + 1 : (evt.newIndex - evt.oldIndex))
            };
            this.list.splice(evt.newIndex, 0, targetRow);
            this.editInstructionBundleEntry([obj]).then((res) => {
              this.getMessageDetails();
            }, (err) => {
              console.log(err);
            });
          }
        })
      },
      setRowKey(row) {
        return row.instructionType + row.id;
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
      this.bundleId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
      this.setSort();
      const param = {
        id: this.bundleId
      };
      this.readInstructionBundleForMessage(param).then((res) => {
        this.instructionBundleEntryMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>


