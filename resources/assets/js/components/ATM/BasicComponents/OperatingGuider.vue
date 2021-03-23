<template>
  <div class="carousel-background">
    <template v-if="carousel_button_statu">
      <el-link :underline="false" type="primary" @click="showCarousel" icon="el-icon-info">{{ message }}</el-link>
    </template>
    <template v-if="carousel_statu">
      <div class="carousel__wrapper" style="z-index: 3000;">
       <el-button type="info" style="z-index: 3001;" class="el-message-box__headerbtn el-message-box__close" @click="hideCarousel" icon="el-icon-close" circle></el-button>
        <div>
          <el-carousel arrow="always" :autoplay="false">
            <el-carousel-item v-for="(item, index) in carousel_img_srcs" :key="index">
              <img class="carousel_img" :src="item.imgSrc">
            </el-carousel-item>
          </el-carousel>
        </div>
      </div>
    </template>
  </div>
</template>


<script>
  import moment from 'moment'

  export default {
    props: {
      message: ''
    },
    data() {
      return {
        carousel_button_statu: false,
        carousel_statu: false,
        carousel_img_lists: {
          Project: [{
            imgSrc: '/img/Project/step1.png',
          }, {
            imgSrc: '/img/Project/step2.png',
          }, {
            imgSrc: '/img/Project/step3.png',
          }, {
            imgSrc: '/img/Project/step4.png',
          }, {
            imgSrc: '/img/Project/step5.png',
          }],
          ProjectTestCase: [{
            imgSrc: '/img/ProjectTestCase/step1.png',
          }, {
            imgSrc: '/img/ProjectTestCase/step2.png',
          }, {
            imgSrc: '/img/ProjectTestCase/step3.png',
          }, {
            imgSrc: '/img/ProjectTestCase/step4.png',
          }],
          TestCaseInstruction: [{
            imgSrc: '/img/TestCaseInstruction/step1.png',
          }, {
            imgSrc: '/img/TestCaseInstruction/step2.png',
          }, {
            imgSrc: '/img/TestCaseInstruction/step3.png',
          }, {
            imgSrc: '/img/TestCaseInstruction/step4.png',
          }, {
            imgSrc: '/img/TestCaseInstruction/step5.png',
          }],
          TestCase: [{
            imgSrc: '/img/TestCase/step1.png',
          }],
          RunList: [{
            imgSrc: '/img/RunList/step1.png',
          }],
          RunListTestCase: [{
            imgSrc: '/img/RunListTestCase/step1.png',
          }, {
            imgSrc: '/img/RunListTestCase/step2.png',
          }],
          Folder: [{
            imgSrc: '/img/Folder/step1.png',
          }],
          FolderTestCase: [{
            imgSrc: '/img/FolderTestCase/step1.png',
          }],
          EngineSetting: [{
            imgSrc: '/img/EngineSetting/step1.png',
          }],
          DriverPacks: [{
            imgSrc: '/img/DriverPacks/step1.png',
          }],
          DriverPacksPacksEngines: [{
            imgSrc: '/img/DriverPacksPacksEngines/step1.png',
          }],
          ProjectApiElementAdd: [{
            imgSrc: '/img/ProjectApiElementAdd/step1.png',
          }, {
            imgSrc: '/img/ProjectApiElementAdd/step2.png',
          }, {
            imgSrc: '/img/ProjectApiElementAdd/step3.png',
          }, {
            imgSrc: '/img/ProjectApiElementAdd/step4.png',
          }],
          ProjectApiElementEdit: [{
            imgSrc: '/img/ProjectApiElementEdit/step1.png',
          }, {
            imgSrc: '/img/ProjectApiElementEdit/step2.png',
          }, {
            imgSrc: '/img/ProjectApiElementEdit/step3.png',
          }, {
            imgSrc: '/img/ProjectApiElementEdit/step4.png',
          }],
          ProjectApplication: [{
            imgSrc: '/img/ProjectApplication/step1.png',
          }],
          ApplicationSection: [{
            imgSrc: '/img/ApplicationSection/step1.png',
          }],
          SectionElement: [{
            imgSrc: '/img/SectionElement/step1.png',
          }],
        }
      };
    },
    computed: {
      carousel_img_srcs: function() {
        const title = window.location.pathname.split('/');
        var item = '';
        if (title.length > 4) {
          item = title[title.length - 3] + title[title.length - 1];
        } else {
          item = title[title.length - 1];
        }
        return this.carousel_img_lists[item];
      }
    },
    methods: {
      showCarousel() {
        this.carousel_statu = true;
        document.body.classList.add('el-popup-parent--hidden');
      },
      hideCarousel() {
        this.carousel_statu = false;
        document.body.classList.remove('el-popup-parent--hidden');
        console.log(this.carousel_statu)
      },
    },
    mounted() {
      const title = window.location.pathname.split('/');
      var item = '';
      if (title.length > 4) {
        item = title[title.length - 3] + title[title.length - 1];
      } else {
        item = title[title.length - 1];
      }
      if (this.carousel_img_lists.hasOwnProperty(item)) {
        this.carousel_button_statu = true;
      } else {
        this.carousel_button_statu = false;
      }
    },
  };
</script>

<style>
.carousel-background {
  float: right;
  line-height: 40px;
  padding: 0px 20px;
}
.el-link.el-link--primary {
  color:  #409eff !important;
}
.carousel__wrapper {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: #000
}
.el-carousel__container {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
  background: #fff;
  height: 100%;
}
.carousel_img {
  width: 90%;
  height: 90%;
  margin: 2.5% 2.5%;
}
.el-carousel__indicators--horizontal {
  position: fixed;
}
.el-carousel__indicators {
  z-index: 3022;
}
.el-carousel__button {
  background-color: #330606;
}
</style>