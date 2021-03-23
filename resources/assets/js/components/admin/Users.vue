<template>
    <el-table
      :data="userData"
      stripe
      style="width: 100%">
      <el-table-column
        prop="name"
        label="用户名"
        width="180">
      </el-table-column>
      <el-table-column
        prop="email"
        label="邮箱"
        width="180">
      </el-table-column>
      <el-table-column
        prop="active"
        label="激活">
      </el-table-column>
      <el-table-column
        prop="created_at"
        label="创建时间"
        width="180">
      </el-table-column>
      <el-table-column
        prop="createdAt"
        label="更新时间"
        width="180">
      </el-table-column>
      <el-table-column
        prop="uuid"
        label="UUID"
        width="180">
      </el-table-column>
    </el-table>
</template>

<script>
    export default {
            data() {
        return {
                users: []
            }
        },
        methods: {
            read() {
                window.axios.get('/api/users').then(({ response }) => {
                response.data.forEach(crud => {
                    this.cruds.push(new Crud(crud));
                });
                });
            }
        }
    };
</script>
