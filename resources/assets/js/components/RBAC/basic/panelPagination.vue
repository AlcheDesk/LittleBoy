<template>
  <div>
    <el-row :gutter="20" class="rbac_panel">
      <el-col :span="16" class="panel_title display_flex">
        <slot name="title"></slot>
      </el-col>
      <el-col :span="6" class="panel_search_input display_flex">
        <el-input @keyup.native="searchClick" size="mini" :placeholder="lang.dialog.placeholder.enter_name" v-model.trim="searchObj.name">
          <el-button @click="searchClick" size="mini" slot="append" icon="el-icon-search"></el-button>
        </el-input>
      </el-col>
        <el-col :span="2" class="panel_operation display_flex">
          <slot name="operation"></slot>
        </el-col>
    </el-row>
    <slot name="table"></slot>
    <el-pagination
      @size-change="handleSizeChange"
      @current-change="handleCurrentChange"
      :current-page="parseInt(searchObj.pageNumber)"
      :page-sizes="[25, 50, 100]"
      :page-size="searchObj.pageSize"
      :layout="pagination"
      :total="total"
      style="background-color: rgb(233, 235, 236);">
    </el-pagination>
  </div>

</template>

<script>
  import moment from 'moment'

  export default {
    props: {
      lang: {
        default: {},
      },
      pagination: {
        default: "total, sizes, prev, pager, next, jumper"
      },
      total: {
        default: 0,
      },
    },
    data() {
      return {
        searchObj: {
          name: '',
          pageSize: 25,
          pageNumber: 1
        },
        items: [],
      };
    },
    methods: {
      searchClick() {
        var obj = {};
        for (var i in this.searchObj) {
          if (this.searchObj[i] !== '') {
            obj[i] = this.searchObj[i];
          }
        }
        this.$emit('search', obj);
      },
      handleSizeChange(val) {
        this.searchObj.pageSize = val;
        this.searchClick();
      },
      handleCurrentChange(val) {
        this.searchObj.pageNumber = val;
        this.searchClick();
      },
    },
    mounted() {
      this.searchObj = {
        name: '',
        pageSize: 25,
        pageNumber: 1
      };
    },
  };
</script>
