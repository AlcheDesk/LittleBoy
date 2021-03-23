<el-row class="sub-menu">
  <el-col :span="24">
    <el-menu class="el-menu-sub" style="background-color: #eef1f6" mode="horizontal" default-active="{{ explode('/', URL::current())[5] }}">
      <!-- <a href="{{ url('/atm/TestSetting/InstructionBundle') }}"> -->
        <!-- <el-menu-item index="InstructionBundle"> -->
          <!-- 指令包 -->
          <!-- {{__('menu.instruction_bundle')}} -->
        <!-- </el-menu-item> -->
      <!-- </a> -->
      <a href="{{ url('/atm/TestSetting/Folder?page=1+25') }}">
        <el-menu-item index="Folder">
          <!-- 收藏夹 -->
          {{__('menu.folder')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/TestSetting/Project?page=1+25') }}">
        <el-menu-item index="Project">
          <!-- 项目库 -->
          {{__('menu.project')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/TestSetting/TestCase?page=1+25') }}">
        <el-menu-item index="TestCase">
          <!-- 用例库 -->
          {{__('menu.test_case')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/TestSetting/RunList?page=1+25') }}">
        <el-menu-item index="RunList">
          <!-- 运行与设置 -->
          {{__('menu.run_list')}}
        </el-menu-item>
      </a>
    </el-menu>
    <span>
      <operating-guider message="{{__('info.operator.new_guider')}}"></operating-guider>
    </span>
  </el-col>
</el-row>

