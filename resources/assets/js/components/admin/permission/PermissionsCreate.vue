<template>
    <div class='permission-create'>
        <el-dialog title="添加权限" :visible.sync="show">
            <el-form ref="form" :model="permissionData" label-width="120px">
            <el-form-item label="权限名称" prop="name">
                <el-input v-model="this.permissionData.name" placeholder="permissionData.name"></el-input>
            </el-form-item>
            <el-form-item label="Guard名称" prop="guard_name">
                <el-input v-model="this.permissionData.guard_name" placeholder="permissionData.guard_name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitCreate">{{ lang.operator.confirm }}</el-button>
                <el-button @click="close">{{ lang.operator.cancel }}</el-button>
            </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        props: ['inputData', 'show'],
        data() {
            return {
                show: false,
                permissionData: {}
            }
        },
        methods: {
            init(inputData){
                this.permissionData = this.inputData;
                this.show = this.inputData.show;
            },
            submitCreate(){

            },
            close(){
                this.$emit('permission-create-dialog-close');
                this.show = false;
            }
        },
        mounted() {
            this.init(this.inputData);
        }
    }
</script>
