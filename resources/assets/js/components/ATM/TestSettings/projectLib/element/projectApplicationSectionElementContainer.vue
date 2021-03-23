<template>
  <div>
    <project-container>
      <div slot="toolbar">
        <project-tool-bar>
          <div slot="breadcrumb">                 
            <el-breadcrumb separator="/">
              <el-breadcrumb-item>
                <a style="font-weight: 500;" href='/atm/TestSetting/Project/?page=1+25'>{{ lang.breadcrumb.project_lib }}</a>
              </el-breadcrumb-item>
              <el-breadcrumb-item>
                <a style="font-weight: 500;" :href="'/atm/TestSetting/Project/' + projectId + '/Application/?page=1+25'">{{ lang.breadcrumb.application }}</a>
              </el-breadcrumb-item>
              <el-breadcrumb-item>
                <a style="font-weight: 500;" :href="'/atm/TestSetting/Project/' + projectId + '/Application/' + this.applicationId + '/Section/?page=1+25'">{{ lang.breadcrumb.section }}</a>
              </el-breadcrumb-item>
              <el-breadcrumb-item>{{ lang.breadcrumb.element }}</el-breadcrumb-item>
            </el-breadcrumb>        
          </div>
          <div slot="name" class="text_ellipsis">
            {{ sectionMessage.name }}
          </div>
          <div slot="creator" class="text_ellipsis">
            {{ sectionMessage.createdAt }}
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
              row-class-name="row_css"
              @row-click="navigationToProjectApplicationSectionElements"
              :data="getApplicationSections.data"
              :show-header="false"
              highlight-current-row
              style="margin-top: -5px;">
              <el-table-column
                :resizable="true"
                prop="name"
                align="left"
                show-overflow-tooltip>
                <template slot-scope="scope">
                  <i class="icon_s"></i>
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

           <!--  <search-pagination
              :total="total"
              :pageNumberPre="pageNumberSave"
              :lang="lang"
              @search="getSearchPaginationModel"
              pagination="total, prev, next, jumper"
              layout="name">
              <template v-slot:table>
                <el-table
                  ref="singleTable"
                  row-class-name="row_css"
                  @row-click="navigationToProjectApplicationSectionElements"
                  :data="getApplicationSections.data"
                  :show-header="false"
                  highlight-current-row
                  style="margin-top: -5px;">
                  <el-table-column
                    :resizable="true"
                    prop="name"
                    align="left"
                    show-overflow-tooltip>
                    <template slot-scope="scope">
                      <i class="icon_s"></i>
                      {{scope.row.name}}
                    </template>
                  </el-table-column>
                </el-table>
              </template>
            </search-pagination> -->
          </el-col>
          <el-col :span="19" style="background-color: #E4EBF2;">
            <sectionElement :message="message"></sectionElement>
          </el-col>
        </el-row>
      </div>
    </project-container>

    

  </div>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'
  import sectionElement from './sectionElement'
  
  export default {
    props: ['message'],
    data() {
      return {
        projectId: null,
        applicationId: null,
        sectionId: null,
        permissionRule: {},
        lang: {},
        sectionMessage: {},
        orderBy: 'id desc',
        queryObj: {
          name: '',
          pageNumber: 1,
          pageSize: 25
        },
        total: 0
      }
    },
    computed:{
      ...mapGetters(['getApplicationSections'])
    },
    components: { sectionElement },
    watch: {
      getApplicationSections: function() {
        this.total = this.getApplicationSections.metadata.count;
        for (let i = 0; i < this.getApplicationSections.data.length; i++) {
          if (this.getApplicationSections.data[i].id == this.sectionId) {
            this.$refs.singleTable.setCurrentRow(this.getApplicationSections.data[i]);
          }
        }
      }
    },
    methods: {
      ...mapActions(['readApplicationSections', 'readSectionForMessage', 'readSectionElements']),
      navigationToProjectApplicationSectionElements(row, event, column) {
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/Application/' + this.applicationId + '/Section/' + row.id + '/Element/?page=1+25';
        localStorage.setItem('elementCurrentPage', this.queryObj.pageNumber);
        localStorage.setItem('elementCurrentSize', this.queryObj.pageSize);
        this.sectionMessage = row;
        const param = {
          sectionId: this.sectionId
        };
        param.data = {
          pageNumber: 1,
          pageSize: 25,
          orderBy: 'id desc',
          isDriver: false
        };
        this.readSectionElements(param);
      },
      getMessageDetails() {
        const obj = {};
        obj.applicationId = this.applicationId;
        obj.data = {
          location: true,
        };
        for (var i in this.queryObj) {
          if (this.queryObj[i] !== '') {
            obj.data[i] = this.queryObj[i];
          }
        }
        this.orderBy ? obj.data.orderBy = this.orderBy : null;
        this.readApplicationSections(obj);
      },
      handleCurrentChange(val) {
        this.queryObj.pageNumber = val;
        localStorage.setItem('elementCurrentPage', val);
        this.getMessageDetails();
      },
    },
    created() {
      const obj = {
        applicationId: window.location.pathname.split('/')[6]
      };
      obj.data = {
        pageNumber: 1,
        pageSize: this.queryObj.pageSize
      };
      this.readApplicationSections(obj);
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
      this.$set(this.queryObj, 'pageNumber', localStorage.getItem('elementCurrentPage') || 1);
      this.$set(this.queryObj, 'pageSize', localStorage.getItem('elementCurrentSize') || 25);
      this.orderBy = localStorage.getItem('elementOrderBy') || 'id desc';
    },
    mounted() {
      this.projectId = window.location.pathname.split('/')[4];
      this.applicationId = window.location.pathname.split('/')[6];
      this.sectionId = window.location.pathname.split('/')[8];
      this.getMessageDetails();
      const section = {
        id: this.sectionId
      };
      this.readSectionForMessage(section).then((res) => {
        this.sectionMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>

