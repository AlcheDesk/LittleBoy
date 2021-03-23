<template>
    <el-form :model="forgetPasswordForm" :rules="rules" ref="forgetPasswordForm" label-width="0px" class="forgetPasswordForm">
        <el-form-item prop="username">
            <el-input v-model="forgetPasswordForm.username" placeholder="用户名" type="email" name="username"></el-input>
        </el-form-item>
        <div class="login-btn">
            <el-button type="primary" @click="submitForgetPasswordForm('forgetPasswordForm')">提交</el-button>
        </div>
    </el-form>
</template>
<script>
    export default {
        data: function(){
            return {
                forgetPasswordForm: {
                    username: ''
                },
                rules: {
                    username: [
                        { required: true, message: '请输入用户名', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            submitForgetPasswordForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        localStorage.setItem('ms_username',this.forgetPasswordForm.username);
                        this.$router.push('/');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        }
    };
</script>

<style scoped>
    .forgetPasswordForm{
        position: absolute;
        left:50%;
        top:50%;
        width:300px;
        height:160px;
        margin:-150px 0 0 -190px;
        padding:40px;
        border-radius: 5px;
        background: #fff;
    }
    .login-btn{
        text-align: center;
    }
    .login-btn button{
        width:100%;
        height:36px;
    }
</style>
