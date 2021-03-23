<template>
  <div>
    <project-tool-bar :name="false">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/ModulePro/SystemRequirementsPacks/?page=1+25'>{{ lang.breadcrumb.system_requirements_packs }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.packs_system_requirements }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_system_requirements">
          <add :lang="lang" @packDriverAddDone="getMessageDetails"></add>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination :lang="lang" layout="id, name, comment, operation" @search="getSearchPaginationModel">
      <template v-slot:table>
        <el-table
          :data="getPackSystemRequirements.data"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'id', order: 'descending'}"
          @sort-change="sortChange">
          <el-table-column
            :label="lang.table.id"
            align="left"
            :resizable="true"
            prop="id"
            width='120'
            sortable="custom">
          </el-table-column>
          <el-table-column
            sortable="custom"
            :label="lang.table.name"
            align="left"
            :resizable="true"
            prop="name"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="type"
            align="left"
            :label="lang.table.type"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="value"
            align="left"
            :label="lang.dialog.title.value"
            show-overflow-tooltip>
          </el-table-column>
          <el-table-column
            :resizable="true"
            prop="comment"
            align="left"
            :label="lang.table.comment"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_system_requirements">
            <el-table-column
              :resizable="true"
              :label="lang.table.operating"
              width='120'>
              <template slot-scope="scope">
                <el-button class="button_text_table" @click="removePackSystemRequirements(scope)">{{lang.operator.delete}}</el-button>
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
        packId: null,
        orderBy: 'id desc',
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
      ...mapGetters(['getPackSystemRequirements'])
    },
    components: { Add },
    watch: {
      getPackSystemRequirements: function() {
        this.total = this.getPackSystemRequirements.metadata ? this.getPackSystemRequirements.metadata.count : this.getPackSystemRequirements.data.length;
      }
    },
    methods: {
      ...mapActions(['readPackSystemRequirements', 'deletePackSystemRequirement']),
      getMessageDetails() {
        const obj = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] != '') {
            obj[i] = this.queryObj[i];
          }
        }
        // obj.orderBy = this.orderBy;
        const param = {
          packId: this.packId,
          data: obj
        };
        this.readPackSystemRequirements(param);
      },
      removePackSystemRequirements(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = {};
          obj.id = scope.row.id;
          obj.packId = this.packId;
          this.deletePackSystemRequirement(obj).then((res) => {
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
      getSearchPaginationModel(val) {
        this.queryObj = val;
        this.getMessageDetails();
      }
    },
    created: function () {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
      console.log(message, 'message////')
    },
    mounted() {
      this.packId = window.location.pathname.split('/')[4];
      this.getMessageDetails();
    }
  };
</script>


