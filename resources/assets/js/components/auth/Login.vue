<template>
  <div class="login">
    <div class="login_img">
      <img src="../../../img/logo.png">
    </div>
    <div class="login_form">
      <div class="form">
        <div class="form_header">
          用户登录
        </div>
        <div class="form_body">
          <el-form :show-message="false" label-suffix=":" :status-icon="true" label-position="left" label-width="80px" :model="loginMessage" @click.submit.prevent :rules="paramValidation" ref="loginMessage" class="demo-ruleForm">
            <el-form-item label="邮箱" prop="email">
              <el-input size="small" @keyup.enter.native="submitUserMessage('loginMessage')" v-model.trim="loginMessage.email"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password" style="text-align: left">
              <el-input size="small" type="password" @keyup.enter.native="submitUserMessage('loginMessage')" v-model.trim="loginMessage.password"></el-input>
              <el-checkbox v-model="loginMessage.rememberMe">记住我</el-checkbox>
            </el-form-item>
            <el-form-item>
              <div style="text-align: right;">
                <el-button plain size="small" style="padding-left: 30px; padding-right: 30px;" >注册</el-button>
                <el-button plain size="small" style="background-color: #4e5c6c; color: white; padding-left: 30px; padding-right: 30px;" @click="submitUserMessage('loginMessage')">登录</el-button>
              </div>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
  import { mapActions, mapMutations } from 'vuex'
  export default {
    data() {
      return {
        loginMessage: {
          email: '',
          password: '',
          rememberMe: false
        },
        paramValidation: {
          email: [{type: 'email', required: true, message: '请输入正确的邮箱地址', trigger: 'blur'}],
          password: [{required: true, message: '请输入密码', trigger: 'blur'}]
        },
      }
    },
    methods: {
      ...mapMutations(['READ_USER_MESSGE']),
      ...mapActions(['login']),
      submitUserMessage(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              email: this.loginMessage.email,
              password: this.loginMessage.password,
              rememberMe: this.loginMessage.rememberMe
            };
            this.login(obj).then((res) => {
              console.log(res, 'pppppp')
            }, (err) => {
              console.log(err, '....');
            })
          }
        })
      }
    },
    mounted() {
      console.log('aaaaaaa');
    }
  };
  
</script>

<style scoped>
.login {
  position: absolute;
  top:  0px;
  bottom: 0px;
  left:  0px;
  right: 0px;
  padding: 0px;
  margin: 0px;
  background-color: #7F8B99;
}
.login_img {
  display: flex;
  justify-content: center;
  align-items: flex-end;
  height: 30%;
}
.login_form {
  display: flex;
  justify-content: center;
  height: 70%;
}
.form {
  width: 50%;
  background-color: #fff;
  height: 80%;
}
.form_header {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 15%;
  background-color: #aaa;
  font-size: 18px;
  font-weight: 600;
}
.form_body {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 85%;
  background-color: #ccc;
  font-size: 18px;
  font-weight: 600;
}
.el-form-item {
  margin-bottom: 10px !important;
}
</style>
