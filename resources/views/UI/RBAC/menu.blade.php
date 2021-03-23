@extends('layout.app')

@section('content')
<div class="rbac">
  <el-row type="flex" class="header" style="background-color: #324157;">
    <el-col :span="4">
      <a href="{{ url('/') }}" >
        <img class="img" src="{{ URL::asset('img/logo.png') }}">
      </a>
    </el-col>
    <el-col :span="16" style='padding-left: 20px;'>
      <div class="title">
        <h2>{{__('RBAC.menu.user_management_system')}}</h2>
      </div>
    </el-col>
    <el-col :span="4">
      <div class="user_message" style="text-align: center;">
        <el-dropdown type="info" split-button round size="medium" placement="bottom-start" trigger="click">
          <img src="/upload/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:2px; left:-35px; border-radius:50%">
          {{ Auth::user()->name }}
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
                {{ __('auth.logout') }}
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
      <div style="display: flex; justify-content: center; align-items: center; height: 70px;">
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
  <el-row :gutter="20" type="flex" class="menu">
    <el-col :span="4" style="margin-left: 15px;">
      <div class="title">
        @hasanyrole('administrator|su')
          <div class="text">{{__('RBAC.menu.administrator')}}</div>
        @else
          <div class="text">{{__('RBAC.menu.general_user')}}</div>
        @endhasanyrole
      </div>
    </el-col>
    <el-col :span="4" class="title">
      <h4 style="color: #111;">{{ Auth::user()->name }}</h4>
    </el-col>
    <el-col :offset="12" :span="4">
      <div class="title">
        <a href="{{ url('/meowlomo/filemanager') }}">
          <div class="text">{{ trans('laravel-filemanager::lfm.title-panel') }}</div>
        </a>
      </div>
    </el-col>
  </el-row>
  <div class="container_rbac">
    <el-row :gutter="20" class="content">
      <el-col :span="6" class="content_left_menu">
        <el-menu class="left_menu" unique-opened default-active="{{ explode('/', URL::current())[5] }}">
          <a href="{{ url('/RBAC/administrator/index') }}">
            <el-menu-item index="index" class="sub_menu">
              {{__('RBAC.menu.basic_information')}}
            </el-menu-item>
          </a>
          <a href="{{ url('/RBAC/administrator/permission') }}">
            <el-menu-item index="permission" class="sub_menu">
              {{__('RBAC.menu.authority_management')}}
            </el-menu-item>
          </a>
          <a href="{{ url('/RBAC/administrator/group') }}">
            <el-menu-item index="group" class="sub_menu">
              {{__('RBAC.menu.group_management')}}
            </el-menu-item>
          </a>
          <a href="{{ url('/RBAC/administrator/user') }}">
            <el-menu-item index="user" class="sub_menu">
              {{__('RBAC.menu.user_management')}}
            </el-menu-item>
          </a>
        </el-menu>
      </el-col>
      <el-col :span="18" class="content_right_container">
        @yield('container')
      </el-col>
    </el-row>
  </div>
</div>


@endsection
