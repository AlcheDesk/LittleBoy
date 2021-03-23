@extends('layout.app')

@section('content')
<el-row type="flex" class="header">
  <el-col :span="24">
    <el-menu style="background-color: #324157" default-active="{{ explode('/', URL::current())[4] }}" class="el-menu-vertical-demo" unique-opened mode="horizontal">
      <el-col :span="4">
        <a href="{{ url('/') }}" >
          <img class="img" src="{{ URL::asset('img/logo.png') }}">
        </a>
      </el-col>
     <!--  <el-col :span="6">
        <div style="font-size: 20px; height: 70px; padding: 5px 20px; line-height: 60px; background-color: #f9d97c;">调试信息</div>
      </el-col> -->
      <el-col :span="12">
        <a href="{{ url('/atm/DebugResult/Project') }}">
          <el-menu-item class="el-menu-1" index="DebugResult">
            <!-- 调试运行结果 -->
          {{__('menu.debug_result')}}
          </el-menu-item>
        </a>
      </el-col>
      <el-col :span="4">
        <div style="display: flex; justify-content: center; align-items: center; height: 70px;">
          <el-dropdown split-button round size="medium" placement="bottom-start" trigger="click">
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
          <div  style="display: flex; justify-content: center; align-items: center; height: 70px;">
              <a href="https://alchedesk.gitbook.io/user-manual/" target="_blank">{{__('menu.user_manual')}}</a>
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
    </el-menu>
  </el-col>
</el-row>
@yield('container')
@endsection
