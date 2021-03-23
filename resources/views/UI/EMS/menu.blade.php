<?php use App\Http\Controllers\API\RBAC\Administrator\HasPermissionsManagement;?>
@extends('layout.app')

@section('content')
<div class="ems">
  <div class="header">
    <el-row :gutter="20" class="row">
      <el-col :span="7" class="col">
        <a href="{{ url('/') }}" >
          <img src="{{ URL::asset('img/logo.png') }}" class="logo_img">
        </a>
      </el-col>
      <el-col :span="11">
        <div class="header_title">
          EMS
        </div>
      </el-col>
      <el-col :span="4">
        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
          <el-dropdown split-button round size="medium" title="{{ Auth::user()->name }}" placement="bottom-start" trigger="click">
            <img src="/upload/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:2px; left:-35px; border-radius:50%">
            @if (strlen(Auth::user()->name) > 10)
              {{ substr(Auth::user()->name, 0, 10).'...' }}
            @else
              {{ Auth::user()->name }}
            @endif
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>
              <a href="{{ route('profile') }}"
                onclick="event.preventDefault();
                document.getElementById('profile-form').submit();">
                {{ __('profile') }}
              </a>
              </el-dropdown-item>
              <el-dropdown-item>
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>
              </el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
          <form id="profile-form" action="{{ route('profile') }}" method="GET" style="display: none;">
          @csrf
          </form>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </el-col>
      <el-col :span="2">
        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
          <el-dropdown style="color: white;" placement="bottom-start" trigger="click">
            <span class="el-dropdown-link">
              {{ session('lang') == 'en' ? 'English' : '中文' }}<i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>
                <a style="color: #49515a;" href="{{ route('lang', ['locale' => 'en']) }}">
                  {{ __('English') }}
                </a>
              </el-dropdown-item>
              <el-dropdown-item>
                <a style="color: #49515a;" href="{{ route('lang', ['locale' => 'zh-CN']) }}">
                  {{ __('中文') }}
                </a>
              </el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </el-col>
    </el-row>
  </div>
  <div class="body">
    <el-row :gutter="20" class="row">
      <el-col :span="6"  class="body_left_menu_container">
        <el-menu default-active="{{ explode('/', URL::current())[4] }}" class="el-menu-vertical-demo body_left_menu" unique-opened>
{{--          @if (Auth::user()->hasPermissionTo('view_ems_executive_overview'))--}}
            @if((strcmp(env('CLOUD_CONFIG'),'public')==0 && HasPermissionsManagement::hasPermissionToMeowlomo('view_ems_executive_overview', Auth::user()->id)) || (strcmp(env('CLOUD_CONFIG'),'private')==0 && (Auth::user()->hasPermissionTo('view_ems_executive_overview'))))

            <a href="{{ url('/ems/ControlCenter') }}" style="width: 100%;">
              <el-menu-item class="body_left_menu_item" index="ControlCenter">
                <i class="fa fa-tasks fa-lg"></i>
                <!-- 执行总览 -->
                {{ __('EMS.menu.exec_overview') }}
              </el-menu-item>
            </a>
          @endif
{{--          @if (Auth::user()->hasPermissionTo('view_ems_work_list'))--}}
            @if((strcmp(env('CLOUD_CONFIG'),'public')==0 && HasPermissionsManagement::hasPermissionToMeowlomo('view_ems_work_list', Auth::user()->id)) || (strcmp(env('CLOUD_CONFIG'),'private')==0 && (Auth::user()->hasPermissionTo('view_ems_work_list'))))
            <a href="{{ url('/ems/Work') }}" style="width: 100%;">
              <el-menu-item class="body_left_menu_item" index="Work">
                <i class="fa fa-briefcase fa-lg"></i>
                <!-- 工作列表 -->
                {{ __('EMS.menu.work_list') }}
              </el-menu-item>
            </a>
          @endif
{{--          @if (Auth::user()->hasPermissionTo('view_ems_test_case_details'))--}}
            @if((strcmp(env('CLOUD_CONFIG'),'public')==0 && HasPermissionsManagement::hasPermissionToMeowlomo('view_ems_test_case_details', Auth::user()->id)) || (strcmp(env('CLOUD_CONFIG'),'private')==0 && (Auth::user()->hasPermissionTo('view_ems_test_case_details'))))
            <a href="{{ url('/ems/Task') }}" style="width: 100%;">
              <el-menu-item class="body_left_menu_item" index="Task">
                <i class="fa fa-calendar-check-o fa-lg"></i>
                <!-- 用力详情 -->
                {{ __('EMS.menu.testcase_detail') }}
              </el-menu-item>
            </a>
          @endif
{{--          @if (Auth::user()->hasPermissionTo('view_ems_execution_unit'))--}}
            @if((strcmp(env('CLOUD_CONFIG'),'public')==0 && HasPermissionsManagement::hasPermissionToMeowlomo('view_ems_execution_unit', Auth::user()->id)) || (strcmp(env('CLOUD_CONFIG'),'private')==0 && (Auth::user()->hasPermissionTo('view_ems_execution_unit'))))
            <a href="{{ url('/ems/ExecutionUnit') }}" style="width: 100%;">
              <el-menu-item class="body_left_menu_item" index="ExecutionUnit">
                <i class="fa fa-window-restore fa-lg"></i>
                <!-- 执行单元 -->
                {{ __('EMS.menu.exec_unit') }}
              </el-menu-item>
            </a>
          @endif
        </el-menu>
      </el-col>
      <el-col class="body_right_container">
        @yield('container')
      </el-col>
    </el-row>
  </div>
</div>
@endsection
