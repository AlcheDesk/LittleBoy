<template>
    <div class='permission-index'>
        <el-table
        :data="permissionsData"
        stripe
        style="width: 100%">
        <el-table-column :render-header="renderHeader">
        </el-table-column>
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
        <permissions-edit v-if="showEditPermissionDialog" :permissionEditInputData = "editPermissionData" :permissionEditVisiable = "showEditPermissionDialog" v-on:permission-edit-dialog-close="handlePermissionDialogCloseEvent"></permissions-edit>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                permissionsData: [],
                showEditPermissionDialog: false,
                editPermissionData: {}
            }
        },

        methods: {
            init() {
                window.axios.get('/api/permissions').then((response) => {
                    this.permissionsData = response.data || [];
                });
            },
            initEditPermission(rowData) {
                this.showEditPermissionDialog = true;
                this.editPermissionData = rowData;
            },
            handleDelete(row) {
                window.axios.delete('/api/permissions/'+ row.id).then((response) => {
                    this.init();
                });
            },
            handlePermissionDialogCloseEvent(){
                this.showEditPermissionDialog = false;
            },
            renderHeader(h, { column, $index }){
                return h('div', {
                        attrs: {
                            class: 'cell'  //ele原来样式
                        },
                        domProps: {
                            innerHTML:
                            '<div>' +
                            '<el-button type="text" size="small">' +
                                '<i class="el-icon-plus" onClick={this.addColOption}></i>' +
                            '</el-button>' +
                            '<el-button type="text" size="small">' +
                                '<i class="el-icon-plus" onClick={this.addColOptions}>批量添加选项</i>' +
                            '</el-button>' +
                            '</div>'
                        }
                    })
            }
        },
        mounted() {
            this.init();
        }
    }
</script>
