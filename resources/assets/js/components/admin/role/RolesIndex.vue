<template>
    <div class='role-index'>
        <el-table
        :data="rolesData"
        stripe
        style="width: 100%">
        <el-table-column
            prop="name"
            label="名称"
            width="180">
        </el-table-column>
        <el-table-column
            prop="created_at"
            label="创建时间"
            width="180">
        </el-table-column>
        <el-table-column
            prop="updated_at"
            label="更新时间"
            width="180">
        </el-table-column>
        <el-table-column
        label="操作">
        <template slot-scope="scope">
            <el-button size="mini" @click="initEditPermission(scope.row)">{{lang.operator.edit}}</el-button>
            <el-button size="mini" type="danger" @click="handleDelete(scope.row)">{{lang.operator.delete}}</el-button>
        </template>
        </el-table-column>
        </el-table>
        <roles-edit v-if="showEditPermissionDialog" :inputData = "editPermissionData"  v-on:role-edit-dialog-close="handlePermissionDialogCloseEvent"></roles-edit>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                rolesData: [],
                showEditPermissionDialog: false,
                editPermissionData: {}
            }
        },

        methods: {
            init() {
                window.axios.get('/api/roles').then((response) => {
                    this.rolesData = response.data || [];
                });
            },
            initEditPermission(rowData) {
                this.showEditPermissionDialog = true;
                this.editPermissionData = rowData;
                this.editPermissionData.show = true;
            },
            handleDelete(row) {
                window.axios.delete('/api/roles/'+ row.id).then((response) => {
                    this.init();
                });
            },
            handlePermissionDialogCloseEvent(){
                this.showEditPermissionDialog = false;
            }
        },
        mounted() {
            this.init();
        }
    }
</script>
