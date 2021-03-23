<?php use App\Http\Controllers\API\RBAC\Administrator\HasPermissionsManagement;?>
@extends('layout.app')

@section('content')
<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
  <div class="container" style="height: 50px; margin-right: 5px; min-width: 100%">
    <a class="navbar-brand" href="{{ url('/') }}">
      {{ config('app.name', 'meowlomo') }}
    </a>

    <div class="collapse navbar-collapse col-md-10" style="float: right;" id="navbarSupportedContent">
      @if(strcmp(env('CLOUD_CONFIG'),'public')==0)
        @if(!empty($account_uuid))
          <span style="margin-left: auto;">{{ __('account.inviteCode') }}: {{ $account_uuid }}</span>
        @endif
      @endif
      <div class="col-md-1.5" style="margin-left: auto;" id="langSupportedContent" >
        @if(strcmp(env('CLOUD_CONFIG'),'public')==0)
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    @if(!empty($account_name))
                      {{ $account_name }} <span class="caret"></span>
                    @else
                    {{ Auth::user()->name }} <span class="caret"></span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('accountJoinShow') }}"
                       onclick="event.preventDefault();
          document.getElementById('accountJoin-form').submit();">
                        {{ __('account.accountJoin') }}
                    </a>
                    <form id="accountJoin-form" action="{{ route('accountJoinShow') }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                    <a class="dropdown-item" href="{{ route('accountListShow') }}"
                       onclick="event.preventDefault();
          document.getElementById('accountListShow-form').submit();">
                        {{ __('account.accountChoose') }}
                    </a>
                    <form id="accountListShow-form" action="{{ route('accountListShow') }}" method="GET" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        @endif
      </div>

      <ul class="navbar-nav ml-auto" style="margin-left: 50px !important;">
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img src="/upload/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:5px; left:-30px; border-radius:50%">
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('profile') }}"
            onclick="event.preventDefault();
            document.getElementById('profile-form').submit();">
                {{ __('profile') }}
            </a>
            <form id="profile-form" action="{{ route('profile') }}" method="GET" style="display: none;">
              @csrf
            </form>
            <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
      </ul>
    </div>

    <div class="col-md-1.5" style="margin-left: 10px;" id="langSupportedContent" >
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a id="langDropdown" class="nav-link dropdown-toggle" href="#" role="text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ session('lang') == 'zh-CN' ? '中文' : 'English' }} <span class="caret"></span>
          </a>
          <div style="min-width: 100px;" class="dropdown-menu dropdown-menu-right" aria-labelledby="langDropdown">
            <a class="dropdown-item" href="{{ route('lang', ['locale' => 'en']) }}">
                {{ __('English') }}
            </a>
            <a class="dropdown-item" href="{{ route('lang', ['locale' => 'zh-CN']) }}">
                {{ __('中文') }}
            </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="home_container">
    @if((strcmp(env('CLOUD_CONFIG'),'public')==0 && HasPermissionsManagement::hasPermissionToMeowlomo('RBAC', Auth::user()->id)) || (strcmp(env('CLOUD_CONFIG'),'private')==0 && (Auth::user()->hasPermissionTo('RBAC'))))
  <div class="content">
    <div class="card">
      <div class="card_text">
        <a href="{{ route('basicInfo') }}" style="color: #62edbc; font-size: 26px; font-weight: bold;">{{ __('home.control_panel') }}</a>
        <a href="{{ route('basicInfo') }}" style="color: #62edbc; font-size: 22px;">{{ __('home.control_panel_description') }}</a>
      </div>
    </div>
  </div>
  @endif
{{--  @if (Auth::user()->hasPermissionTo('ATM'))--}}
    @if((strcmp(env('CLOUD_CONFIG'),'public')==0 && HasPermissionsManagement::hasPermissionToMeowlomo('ATM', Auth::user()->id)) || (strcmp(env('CLOUD_CONFIG'),'private')==0 && (Auth::user()->hasPermissionTo('ATM'))))
  <div class="content">
    <div class="card">
      <div class="card_text">
        <a href="{{ route('Project') }}" style="color: #7096e1; font-size: 26px; font-weight: bold;">{{ __('home.atm_name') }}</a>
        <a href="{{ route('Project') }}" style="color: #7096e1; font-size: 22px;">{{ __('home.atm_description') }}</a>
      </div>
    </div>
  </div>
  @endif
{{--  @if (Auth::user()->hasPermissionTo('EMS'))--}}
    @if((strcmp(env('CLOUD_CONFIG'),'public')==0 && HasPermissionsManagement::hasPermissionToMeowlomo('EMS', Auth::user()->id)) || (strcmp(env('CLOUD_CONFIG'),'private')==0 && (Auth::user()->hasPermissionTo('ATM'))))
  <div class="content">
    <div class="card">
      <div class="card_text">
        <a href="{{ route('ControlCenter') }}" style="color: #7096e1; font-size: 26px; font-weight: bold;">{{ __('home.ems_name') }}</a>
        <a href="{{ route('ControlCenter') }}" style="color: #7096e1; font-size: 22px;">{{ __('home.ems_description') }}</a>
      </div>
    </div>
  </div>
  @endif
</div>
<!-- <div>
  <clients></clients>
  <passport-authorized-clients></passport-authorized-clients>
  <passport-personal-access-tokens></passport-personal-access-tokens>
</div> -->

@endsection
