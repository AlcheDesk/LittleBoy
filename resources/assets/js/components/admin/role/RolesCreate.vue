<template>
<el-form ref="form" :model="permission" label-width="120px">
  <el-form-item label="权限名称">
    <el-input v-model="permission.name"></el-input>
  </el-form-item>
  <el-form-item label="Guard名称">
    <el-input v-model="permission.guard_name"></el-input>
  </el-form-item>
  <el-form-item>
    <el-button type="primary" @click="onSubmit">Create</el-button>
    <el-button>Cancel</el-button>
  </el-form-item>
</el-form>
</template>

<script>
    export default {
        data() {
            return {
                rolesData: []
            }
        },
        methods: {
            init() {
                window.axios.get('/api/permissions').then((response) => {
                    console.log(response, '....')
                    this.rolesData = response.data || [];
                });
            },
            handleEdit(index, row) {
                console.log(index, row);
                this.init();
            },
            handleDelete(row) {
                window.axios.delete('/api/permissions/'+ row.id).then((response) => {
                    this.init();
                });

            }
        },
        mounted() {
            this.init();
        }
    }
</script>
