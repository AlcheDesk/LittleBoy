<el-row class="sub-menu">
  <el-col :span="24">
    <el-menu class="el-menu-sub" style="background-color: #eef1f6" mode="horizontal" default-active="{{ explode('/', URL::current())[5] }}">
      <a href="{{ url('/atm/ModulePro/EngineSetting?page=1+25') }}">
        <el-menu-item index="EngineSetting">
          <!-- 引擎设置 -->
          {{__('menu.engine')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/ModulePro/DriverPacks?page=1+25') }}">
        <el-menu-item index="DriverPacks">
          <!-- 引擎包管理 -->
          {{__('menu.engine_pack')}}
        </el-menu-item>
      </a>
      <a href="{{ url('/atm/ModulePro/SystemRequirementsPacks?page=1+25') }}">
        <el-menu-item index="SystemRequirementsPacks">
          <!-- 系统需求 -->
          {{__('menu.system_requirements')}}
        </el-menu-item>
      </a>
    </el-menu>
    <span>
      <operating-guider message="{{__('info.operator.new_guider')}}"></operating-guider>
    </span>
  </el-col>
</el-row>

