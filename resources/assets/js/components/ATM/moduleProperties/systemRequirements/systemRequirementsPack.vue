<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        {{ lang.breadcrumb.system_requirements_packs }}
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_system_requirements_packs">
          <add :lang="lang" @systemRequirementsPackAddDone="getMessageDetails"></add>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination :total="total" :lang="lang" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getSystemRequirementPacks.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'createdAt', order: 'descending'}"
          @sort-change="sortChange"
          @row-dblclick="navigationToDriver">
          <el-table-column
            :label="lang.table.id"
            :resizable="true"
            prop="id"
            width='120'
            sortable="custom"
            align="left">
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.name"
            prop="name"
            sortable="custom"
            align="left">
          </el-table-column>
          <el-table-column
            :resizable="true"
            show-overflow-tooltip
            prop="createdAt"
            sortable="custom"
            :label="lang.table.create_at"
            align="left">
            <template slot-scope="scope">
              {{ new Date(scope.row.createdAt).toLocaleString() }}
            </template>
          </el-table-column>
          <el-table-column
            :resizable="true"
            :label="lang.table.comment"
            prop="comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_system_requirements_packs">
            <el-table-column
              :resizable="true"
              :label="lang.table.operating"
              width='120'>
              <template slot-scope="scope">
                <el-button class="button_text_table" @click="removeSystemRequirementsPack(scope)">{{lang.operator.delete}}</el-button>
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
  import Add from './Add.vue'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        orderBy: 'createdAt desc',
        queryObj: {
          ids: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0
      }
    },
    computed: {
      ...mapGetters(['getSystemRequirementPacks'])
    },
    components: { Add },
    watch: {
      getSystemRequirementPacks: function() {
        this.total = this.getSystemRequirementPacks.metadata.count;
      }
    },
    methods: {
      ...mapActions(['readSystemRequirementPacks', 'deleteSystemRequirementPack']),
      navigationToDriver(row) {
        window.location.href = '/atm/ModulePro/SystemRequirementsPacks/' + row.id + '/SystemRequirements?page=1+25';
      },
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        obj.orderBy = this.orderBy;
        this.readSystemRequirementPacks(obj);
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
      removeSystemRequirementsPack(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = scope.row;
          this.deleteSystemRequirementPack(obj).then((res) => {
            this.getMessageDetails();
          }, (err) => {
            console.log(err);
          });
        }).catch(() => {
          this.$message({
            type:'info',
            message: this.lang.operator.undelete
          });
        });
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


