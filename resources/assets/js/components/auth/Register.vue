<template>
  <div class="register">
    <div class="register_form">
      <div class="form">
        <div class="form_header">
          用户注册
        </div>
        <div class="form_body">
          <div style="flex: 1;"></div>
          <el-form style="flex: 4;" :show-message="false" label-suffix=":" :status-icon="true" label-position="right" label-width="100px" :model="registerMessage" @click.submit.prevent :rules="paramValidation" ref="registerMessage" class="demo-ruleForm">
            <el-form-item label="邮箱" prop="email">
              <el-input size="small" v-model.trim="registerMessage.email"></el-input>
            </el-form-item>
            <el-form-item label="用户名" prop="name">
              <el-input size="small" v-model.trim="registerMessage.name"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
              <el-input size="small" type="password" v-model.trim="registerMessage.password"></el-input>
            </el-form-item>
            <el-form-item label="确认密码" prop="ensurePass">
              <el-input size="small" type="password" v-model.trim="registerMessage.ensurePass"></el-input>
            </el-form-item>
            <el-form-item>
              <div style="text-align: right;">
                <el-button plain size="small" style="background-color: #4e5c6c; color: white; padding-left: 30px; padding-right: 30px;" @click="registerUserMessage('registerMessage')">注册</el-button>
              </div>
            </el-form-item>
          </el-form>
          <div style="flex: 1;"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
  import { mapActions, mapMutations } from 'vuex'
  export default {
    data() {
      var validateEnsurePass = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'));
        } else if (value !== this.registerMessage.password) {
          callback(new Error('两次输入密码不一致!'));
        } else {
          callback();
        }
      };
      return {
        registerMessage: {
          email: '',
          name: '',
          password: '',
          ensurePass: ''
        },
        paramValidation: {
          email: [{type: 'email', required: true, message: '请输入正确的邮箱地址', trigger: 'blur'}],
          name: [{required: true, message: '请输入用户名', trigger: 'blur'}],
          password: [{required: true, message: '请输入密码', trigger: 'blur'}],
          ensurePass: [{required: true, validator: validateEnsurePass, trigger: 'blur'}]
        },
      }
    },
    methods: {
      ...mapMutations(['READ_USER_MESSGE']),
      ...mapActions(['register']),
      registerUserMessage(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              email: this.registerMessage.email,
              password: this.registerMessage.password,
              name: this.registerMessage.name
            };
            console.log(obj, 'pppppppp')
            this.register(obj).then((res) => {
              console.log(res, 'pppppp')
              // if (res.metadata.count) {
              //   this.$store.commit('READ_USER_MESSGE', res.data[0]);
              //   localStorage.setItem('user', JSON.stringify(res.data[0]));
              //   this.$router.push({path:'/TestSettings/Projectlib'});
              // } else {
              //   this.$notify.error({
              //     title: '登录失败',
              //     message: res.metadata.message
              //   });
              // }
            }, (err) => {
              console.log(err);
            })
          }
        })
      }
    }
  };
  
</script>

<style scoped>
.register {
  position: absolute;
  top:  0px;
  bottom: 0px;
  left:  0px;
  right: 0px;
  padding: 0px;
  margin: 0px;
  background-color: #7F8B99;
}
.register_form {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
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
