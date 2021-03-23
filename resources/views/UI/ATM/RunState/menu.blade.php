<el-row class="sub-menu">
  <el-col :span="24">
    <el-menu class="el-menu-sub" style="background-color: #eef1f6" mode="horizontal" default-active="{{ explode('/', URL::current())[5] }}">
      <a href="{{ url('/atm/RunState/Project?page=1+25') }}">
        <el-menu-item index="Project">
          <!-- 项目运行状态 -->
          {{__('menu.project_status')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/RunState/RunList?page=1+25') }}">
        <el-menu-item index="RunList">
          <!-- 列表运行状态 -->
          {{__('menu.run_list_status')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/RunState/TestCase?page=1+25') }}">
        <el-menu-item index="TestCase">
          <!-- 用例运行状态 -->
          {{__('menu.test_case_status')}}
        </el-menu-item>
      </a>
    </el-menu>
  </el-col>
</el-row>

