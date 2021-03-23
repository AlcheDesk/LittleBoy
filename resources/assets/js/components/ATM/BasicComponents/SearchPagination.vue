<template>
  <div>
    <template v-if="layout">
      <div class="search_bar">
        <template v-if="items.includes('id')">
          <div class="search_item">
            <div class="search_label">
              {{lang.table.id}}：
            </div>
            <div class="search_content">
              <el-input type="number" :min="0" @keyup.native="searchClick" :placeholder="lang.dialog.placeholder.enter_id" v-model.trim="searchObj.ids" size="mini"></el-input>
            </div>
          </div>
        </template>
        <template v-if="items.includes('orderIndex')">
          <div class="search_item">
            <div class="search_label">
              {{lang.table.id}}：
            </div>
            <div class="search_content">
              <el-input type="number" :min="0" @keyup.native="searchClick" :placeholder="lang.dialog.placeholder.enter_id" v-model.trim="searchObj.orderIndex" size="mini"></el-input>
            </div>
          </div>
        </template>
        <template v-if="items.includes('name')">
          <template v-if="items.length == 1">
            <div class="search_item_name">
              <el-input @keyup.native="searchClick" :placeholder="lang.dialog.placeholder.enter_name" suffix-icon="el-icon-search" v-model.trim="searchObj.name" clearable @clear="searchClick" @blur="searchClick" size="mini"></el-input>
            </div>
          </template>
          <template v-else>
            <div class="search_item">
              <div class="search_label">
                {{lang.table.name}}：
              </div>
              <div class="search_content">
                <el-input :placeholder="lang.dialog.placeholder.enter_name" @keyup.native="searchClick" v-model.trim="searchObj.name" size="mini"></el-input>
              </div>
            </div>
          </template>
        </template>
        <template v-if="items.includes('comment')">
          <div class="search_item">
            <div class="search_label">
              {{lang.table.comment}}：
            </div>
            <div class="search_content">
              <el-input :placeholder="lang.dialog.placeholder.enter_comment" @keyup.native="searchClick" v-model.trim="searchObj.comment" size="mini"></el-input>
            </div>
          </div>
        </template>
        <template v-if="items.includes('value')">
          <div class="search_item">
            <div class="search_label">
              value：
            </div>
            <div class="search_content">
              <el-input @keyup.native="searchClick" v-model.trim="searchObj.value" size="mini"></el-input>
            </div>
          </div>
        </template>
        <template v-if="items.includes('overwrite')">
          <div class="search_item">
            <div class="search_label">
              {{lang.table.overwrite}}：
            </div>
            <div class="search_content">
              <el-input @keyup.native="searchClick" :placeholder="lang.dialog.placeholder.enter_name" v-model.trim="searchObj.testCaseOverwriteName" size="mini"></el-input>
            </div>
          </div>
        </template>
        <template v-if="items.includes('driver')">
          <div class="search_item">
            <div class="search_label">
              {{lang.table.operating_environment}}：
            </div>
            <div class="search_content">
              <el-input @keyup.native="searchClick" :placeholder="lang.dialog.placeholder.enter_name" v-model.trim="searchObj.driverPackName" size="mini"></el-input>
            </div>
          </div>
        </template>
        <template v-if="items.includes('startDate')">
          <div class="search_item">
            <div class="search_label">
              {{lang.table.start_date}}：
            </div>
            <div class="search_content">
              <el-date-picker
                size="mini"
                v-model="searchObj.startDate"
                type="datetime"
                @change="searchClick"
                :placeholder="lang.dialog.placeholder.select_date">
              </el-date-picker>
            </div>
          </div>
        </template>
        <template v-if="items.includes('endDate')">
          <div class="search_item">
            <div class="search_label">
              {{lang.table.end_date}}：
            </div>
            <div class="search_content">
              <el-date-picker
                size="mini"
                v-model="searchObj.endDate"
                @change="searchClick"
                type="datetime"
                :placeholder="lang.dialog.placeholder.select_date">
              </el-date-picker>
            </div>
          </div>
        </template>
        <template v-if="items.includes('operation')">
          <div class="search_item">
            <!-- <el-button size="mini" @click="searchClick" class="search_button">{{lang.operator.searching}}</el-button> -->
            <el-button size="mini" @click="resetSearch" class="search_button">{{lang.operator.reset}}</el-button>
          </div>
        </template>
      </div>
    </template>
    <slot name="table"></slot>
    <template v-if="paginationStatus">
      <el-pagination
        @size-change="handleSizeChange"
        @current-change="handleCurrentChange"
        :current-page="searchObj.pageNumber"
        :page-sizes="[25, 50, 100]"
        :page-size="searchObj.pageSize"
        :layout="pagination"
        :total="total"
        style="background-color: rgb(233, 235, 236);">
      </el-pagination>
    </template>
  </div>

</template>

<script>
  import moment from 'moment'

  export default {
    props: {
      lang: {
        default: {},
      },
      layout: {
        default: 'id, name, comment, startDate, endDate, operation'
      },
      pagination: {
        default: "total, sizes, prev, pager, next, jumper"
      },
      total: {
        default: 0,
      },
      paginationStatus: {
        default: true,
      },
      pageNumberPre: {
        default: 1,
      },
      changePageToUrl: {
        default: true,
      }
    },
    data() {
      return {
        searchObj: {
          ids: '',
          orderIndex: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageSize: 25,
          pageNumber: 1,
          value: '',
          testCaseOverwriteName: '',
          driverPackName: '',
        },
        items: [],
        page: null,
      };
    },
    watch: {
      pageNumberPre: function() {
        this.$set(this.searchObj, 'pageNumber', this.pageNumberPre);
      }
    },
    methods: {
      resetSearch() {
        this.searchObj = {
          ids: '',
          orderIndex: '',
          name: '',
          comment: '',
          startDate: '',
          endDate: '',
          pageSize: 25,
          pageNumber: 1,
          value: '',
          testCaseOverwriteName: '',
          driverPackName: '',

        };
        this.$emit('search', this.searchObj, 'reset');
      },
      searchClick() {
        var obj = {};
        for (var i in this.searchObj) {
          if (this.searchObj[i] !== '') {
            obj[i] = this.searchObj[i];
            if (['ids', 'orderIndex', 'name', 'comment', 'startDate', 'endDate', 'value', 'testCaseOverwriteName', 'driverPackName'].includes(i)) {
              obj.location = true;
            }
          }
        }
        if (!!obj.location) {
          obj.pageNumber = 1;
          this.$set(this.searchObj, 'pageNumber', 1);
        } else {
          this.$set(this.searchObj, 'pageNumber', this.page);
          obj.pageNumber = this.searchObj.pageNumber;
        }
        if (this.searchObj.startDate) {
          obj.startDate = moment(this.searchObj.startDate).format('x');
        }
        if (this.searchObj.endDate) {
          obj.endDate = moment(this.searchObj.endDate).format('x');
        }
        if (!this.paginationStatus) {
          delete obj.pageNumber;
          delete obj.pageSize;
        }
        this.$emit('search', obj);
      },
      handleSizeChange(val) {
        this.searchObj.pageSize = val;
        if (this.changePageToUrl) {
          window.location.search = '?page=' + this.searchObj.pageNumber + '+' + val;
          let str = window.location.pathname;
          if (str.includes('TestSetting') && str.includes('Project') && str.includes('TestCase')) {
            localStorage.setItem('caseCurrentSize', this.searchObj.pageSize);
          }
          if (str.includes('TestSetting') && str.includes('Application') && str.includes('Element')) {
            localStorage.setItem('elementCurrentSize', this.queryObj.pageSize);
          }
        }
        this.searchClick();
      },
      handleCurrentChange(val) {
        this.searchObj.pageNumber = val;
        if (this.changePageToUrl) {
          window.location.search = '?page=' + val + '+' + this.searchObj.pageSize;
          let str = window.location.pathname;
          if (str.includes('TestSetting') && str.includes('Project') && str.includes('TestCase')) {
            localStorage.setItem('caseCurrentPage', this.searchObj.pageNumber);
          }
          if (str.includes('TestSetting') && str.includes('Application') && str.includes('Element')) {
            localStorage.setItem('elementCurrentPage', this.queryObj.pageNumber);
          }
        }
        this.searchClick();
      },
    },
    created() {
      this.page = parseInt(window.location.href.split('?')[1] && window.location.href.split('?')[1].split('&')[0] && window.location.href.split('?')[1].split('&')[0].split('=')[1].split('+')[0]);
      let pageSize = parseInt(window.location.href.split('?')[1] && window.location.href.split('?')[1].split('&')[0] && window.location.href.split('?')[1].split('&')[0].split('=')[1].split('+')[1]);
      this.items = this.layout.split(',').map((item) => item.trim());
      if (!this.page) {
        window.location.search = '?page=' + this.searchObj.pageNumber + '+' + this.searchObj.pageSize;
      }
      this.$set(this.searchObj, 'pageNumber', this.page);
      this.$set(this.searchObj, 'pageSize', pageSize);
    },
  };
</script>
