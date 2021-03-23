<template>
    <div class='permission-edit'>
        <el-dialog title="编辑权限" :visible.sync="show" @close="closeDialog">
            <el-form ref="form" :model="permissionData" label-width="120px">
            <el-form-item label="权限名称" prop="name">
                <el-input v-model="permissionData.name" placeholder="permissionData.name"></el-input>
            </el-form-item>
            <el-form-item label="Guard名称" prop="guard_name">
                <el-input v-model="permissionData.guard_name" placeholder="permissionData.guard_name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitUpdate">{{ lang.operator.confirm }}</el-button>
                <el-button @click="closeDialog">{{ lang.operator.cancel }}</el-button>
            </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        props: ['permissionEditInputData', 'permissionEditVisiable'],
        data() {
            return {
                show: false,
                permissionData: {}
            }
        },
        methods: {
            init(permissionEditInputData){
                this.permissionData = this.permissionEditInputData;
                this.show = this.permissionEditVisiable;
            },
            submitUpdate(){
                console.log('permission id', this.permissionData);
                window.axios.patch('/api/permissions/'+ this.permissionData.id, {name: this.permissionData.name, guard_name: this.permissionData.guard_name}).then((response) => {
                    console.log(response);
                    this.closeDialog();
                });
            },
            closeDialog(){
                this.$emit('permission-edit-dialog-close');
                this.show = false;
            }
        },
        mounted() {
            this.init(this.permissionEditInputData);
        }
    }
</script>
