<template>
  <el-row :gutter="10" class="tool_bar_header">
    <el-col :span="10" class="breadcrumb_text" :class="backgroundColor">
      <slot name="breadcrumb"></slot>
    </el-col>
    <template v-if="name">
      <el-col :span="3" class="name">
        <el-popover
          ref="name"
          placement="top"
          trigger="click">
          <template v-if="messageInfo">
            {{ messageInfo.name || messageInfo.testCaseName || messageInfo.projectName}}
          </template>
          <template v-else>
            <slot name="name"></slot>
          </template>
        </el-popover>
        <div v-popover:name>
          <template v-if="messageInfo">
            <div class="text_ellipsis">
              {{ messageInfo.name || messageInfo.testCaseName || messageInfo.projectName}}
            </div>
          </template>
          <template v-else>
            <slot name="name"></slot>
          </template>
        </div>
      </el-col>
    </template>
    <template v-if="status">
      <el-col :span="4" class="name execute">
        <slot name="execute"></slot>
      </el-col>
      <el-col :span="5" class="message">
        <slot name="progress"></slot>
      </el-col>
      <el-col :span="4" class="message">
        <el-popover
          ref="createdAt"
          placement="top"
          trigger="click">
          <template v-if="messageInfo">
            {{ messageInfo.createdAt }}
          </template>
          <template v-else>
            <slot name="creator"></slot>
          </template>
        </el-popover>
        <div v-popover:createdAt>
          <template v-if="messageInfo">
            <div class="text_ellipsis">
              {{ messageInfo.createdAt }}
            </div>
          </template>
          <template v-else>
            <slot name="creator"></slot>
          </template>
        </div>
      </el-col>
    </template>
    <template v-else>
      <el-col :span="6" class="message">
        <el-popover
          ref="createdAt"
          placement="top"
          trigger="click">
          <template v-if="messageInfo">
            {{ messageInfo.createdAt || messageInfo.latestRunUpdatedAt || messageInfo.projectUpdatedAt}}
          </template>
          <template v-else>
            <slot name="creator"></slot>
          </template>
        </el-popover>
        <div v-popover:createdAt>
          <template v-if="messageInfo">
            <div class="text_ellipsis">
              {{ messageInfo.createdAt || messageInfo.latestRunUpdatedAt || messageInfo.projectUpdatedAt}}
            </div>
          </template>
          <template v-else>
            <slot name="creator"></slot>
          </template>
        </div>
      </el-col>
      <el-col :span="5" class="operation">
        <slot name="operation"></slot>
      </el-col>
    </template>
  </el-row>
</template>

<script>
  export default {
    props: {
      name: {
        default: true,
      },
      messageInfo: {},
      status: {
        default: false,
      }
    },
    data() {
      return {};
    },
    computed: {
      backgroundColor: function() {
        var str = window.location.pathname;
        if (str.includes('TestSetting') || str.includes('DebugResult')) {
          return 'test_setting';
        }
        if (str.includes('ModulePro')) {
          return 'module_pro';
        }
        if (str.includes('RunState')) {
          return 'run_status';
        }
        if (str.includes('RunResult')) {
          return 'run_result';
        }
      }
    }
  };
</script>
