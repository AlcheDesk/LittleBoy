<template>
    <div class='role-edit'>
        <el-dialog title="编辑权限" :visible.sync="show">
            <el-form ref="form" :model="roleData" label-width="120px">
            <el-form-item label="权限名称" prop="name">
                <el-input v-model="this.roleData.name" placeholder="roleData.name"></el-input>
            </el-form-item>
            <el-form-item label="Guard名称" prop="guard_name">
                <el-input v-model="this.roleData.guard_name" placeholder="roleData.guard_name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitUpdate">{{ lang.operator.confirm }}</el-button>
                <el-button @click="close">{{ lang.operator.cancel }}</el-button>
            </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        props: ['inputData'],
        data() {
            return {
                show: false,
                roleData: {}
            }
        },
        methods: {
            init(inputData){
                this.roleData = this.inputData;
                this.show = this.inputData.show;
            },
            submitUpdate(){

            },
            close(){
                this.$emit('role-edit-dialog-close');
                this.show = false;
            }
        },
        mounted() {
            this.init(this.inputData);
        }
    }
</script>
