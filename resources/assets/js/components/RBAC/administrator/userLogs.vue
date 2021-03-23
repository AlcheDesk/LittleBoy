<template>
  <div class="rbac_content">
    <panel-pagination :lang="lang" :total="total" @search="getSearchPaginationModel">
      <template v-slot:title>{{ lang.breadcrumb.user_record }}</template>
      <template v-slot:table>
        <el-table
          :data="getUserLogs.data"
          row-class-name="row_css"
          :default-sort="{prop: 'id', order: 'descending'}"
          @sort-change="sortChange"
          style="width: 100%; margin: 10px 0px 5px;">
          <el-table-column
            prop="id"
            align="left"
            :label="lang.table.id"
            sortable="custom"
            show-overflow-tooltip
            width="100">
          </el-table-column>
          <el-table-column
            prop="targetModel"
            align="left"
            show-overflow-tooltip
            :label="lang.table.operating_object">
          </el-table-column>
          <el-table-column
            prop="actionName"
            align="left"
            show-overflow-tooltip
            :label="lang.table.action">
          </el-table-column>
          <el-table-column
            align="left"
            prop="input"
            show-overflow-tooltip
            :label="lang.table.modify_content">
          </el-table-column>
          <el-table-column
            prop="createdAt"
            align="left"
            sortable="custom"
            show-overflow-tooltip
            :label="lang.table.create_at">
          </el-table-column>
        </el-table>
      </template>
    </panel-pagination>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  props: ['message'],
  data() {
    return {
      lang: {},
      total: 0,
      queryObj: {
        name: '',
        pageSize: 25,
        pageNumber: 1
      },
      orderBy: 'id desc',
    }
  },
  watch: {
    getUserLogs: function() {
      this.total = this.getUserLogs.metadata.count;
    }
  },
  computed: {
    ...mapGetters(['getUserLogs'])
  },
  methods: {
    ...mapActions(['readUserLogs']),
    getMessageDetails() {
      const obj = {
        id: window.location.pathname.split('/')[4]
      };
      for (var i in this.queryObj) {
        if (this.queryObj[i] !== '') {
          obj[i] = this.queryObj[i];
        }
      }
      obj.orderBy = this.orderBy;
      this.readUserLogs(obj);
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
    getSearchPaginationModel(val) {
      this.queryObj = val;
      this.getMessageDetails();
    }
  },
  created: function () {
    var message =  JSON.parse(this.message);
    this.lang = message.lang;
  },
  mounted() {
    this.getMessageDetails();
  }
};
</script>
