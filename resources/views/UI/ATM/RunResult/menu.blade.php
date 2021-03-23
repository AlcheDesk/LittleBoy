<el-row class="sub-menu">
  <el-col :span="24">
    <el-menu class="el-menu-sub" style="background-color: #eef1f6" mode="horizontal" default-active="{{ explode('/', URL::current())[5] }}">
      <a href="{{ url('/atm/RunResult/Project?page=1+25') }}">
        <el-menu-item index="Project">
          <!-- 项目运行结果 -->
          {{__('menu.project_result')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/RunResult/RunList?page=1+25') }}">
        <el-menu-item index="RunList">
          <!-- 列表运行结果 -->
          {{__('menu.run_list_result')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/RunResult/TestCase?page=1+25') }}">
        <el-menu-item index="TestCase">
          <!-- 用例运行结果 -->
          {{__('menu.test_case_result')}}
        </el-menu-item>
      </a>
    </el-menu>
  </el-col>
</el-row>

