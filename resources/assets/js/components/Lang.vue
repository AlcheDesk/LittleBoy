<template>
  <div>
    <el-dropdown @command="handleCommand" trigger="click">
      <span class="el-dropdown-link">
        <slot></slot>
        <i class="el-icon-arrow-down el-icon--right"></i>
      </span>
      <el-dropdown-menu slot="dropdown">
        <el-dropdown-item command="en">en</el-dropdown-item>
        <el-dropdown-item command="zh-CN">zh-CN</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>
  </div>
</template>

<script>
export default {
  methods: {
    handleCommand(command) {
      axios.get('/api/lang/' + command).then((res) => {
        // window.location.reload();
      })
    }
  }
};
</script>

<style scoped>
.el-dropdown-link {
  cursor: pointer;
  color: #bac6d0;
  font-size: 16px;
  font-weight: 400;
  line-height: 2.4;
  padding: 10px 16px;
}
</style>