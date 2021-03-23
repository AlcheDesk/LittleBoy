<template>
  <div>
    <project-tool-bar>
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a style="font-weight: 500;" href='/atm/ModulePro/EngineSetting/?page=1+25'>{{ lang.breadcrumb.engine }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.engine_property }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="name" class="text_ellipsis">
        {{ engineMessage.name }}
      </div>
      <div slot="creator" class="text_ellipsis">
        {{ engineMessage.createdAt }}
      </div>
      <div slot="operation">
        <template v-if="permissionRule.add_drivers_properties">
          <add :lang="lang" @propertiesAddDone="getMessageDetails"></add>
        </template>
      </div>
    </project-tool-bar>
    <search-pagination layout="name, value, operation" :lang="lang" @search="getSearchPaginationModel" :paginationStatus="false">
      <template v-slot:table>
        <el-table
          :data="properties"
          style="width: 100%"
          row-class-name="row_css"
          :default-sort="{prop: 'name', order: 'descending'}"
          @sort-change="sortChange"
          border>
          <el-table-column
            :resizable="true"
            prop="name"
            label="name"
            sortable="custom"
            header-align="center">
          </el-table-column>
          <el-table-column
            :resizable="true"
            label="value"
            prop="value"
            sortable="custom"
            header-align="center"
            show-overflow-tooltip>
          </el-table-column>
          <template v-if="permissionRule.delete_drivers_properties">
            <el-table-column
              :resizable="true"
              width='100'
              :label="lang.table.operating"
              header-align="center">
              <template slot-scope="scope">
                <el-button class="button_text_table" @click="removeEngineProperties(scope)">{{lang.operator.delete}}</el-button>
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
        engineId: null,
        engineMessage: {},
        orderBy: 'name desc',
        properties: [],
        queryObj: {
          name: '',
          value: '',
        },
      }
    },
    computed: {
      ...mapGetters(['getEngines'])
    },
    components: { Add },
    watch: {
      getEngines: function() {
        const data = (this.getEngines.data[0] && this.getEngines.data[0].property) || [];
        const arr = [];
        for (let [key, value] of Object.entries(data)) {
          const obj = {};
          obj.name = key;
          obj.value = String(value);
          arr.push(obj);
        }
        this.properties = arr;
      },
    },
    methods: {
      ...mapActions(['readEngineForMessage', 'readEngines', 'addEngines']),
      getMessageDetails() {
        const obj = {
          engineId: this.engineId
        };
        obj.data = {};
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        obj.data.orderBy = this.orderBy;
        this.readEngines(obj);
      },
      removeEngineProperties(scope) {
        this.$confirm(this.lang.dialog.title.delete_info + ' ' + '<i style="color: red;">' + scope.row.name + '</i>' + ' ' + this.lang.dialog.title.delete_continue, this.lang.dialog.title.delete, {
          confirmButtonText: this.lang.operator.confirm,
          cancelButtonText: this.lang.operator.cancel,
          type: 'warning',
          dangerouslyUseHTMLString: true
        }).then(() => {
          const obj = {
            id: this.engineId
          };
          const param = {};
          for (let [key, value] of Object.entries(this.getEngines.data[0].property)) {
            param[key] = value;
          }
          delete param[scope.row.name];
          obj.property = param;
          this.addEngines(obj).then((res) => {
            this.getMessageDetails()
          }, (err) => {
            console.log(err);
          })
        }).catch(() => {
          this.$message({
            type:'info',
            message: '取消删除'
          });
        });
      },
      sortChange(column) {
        if (column && column.order == 'descending') {
          this.orderBy = column.prop + ' desc';
        } else if (column.order == 'ascending') {
          this.orderBy = column.prop + ' asc';
        } else {
          this.orderBy = 'name desc';
        }
        this.getMessageDetails()
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
      this.engineId = window.location.pathname.split('/')[4];
      this.getMessageDetails()
      const engine = {
        id: this.engineId
      };
      this.readEngineForMessage(engine).then((res) => {
        this.engineMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>


