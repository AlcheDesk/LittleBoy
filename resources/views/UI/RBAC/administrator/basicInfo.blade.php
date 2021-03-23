@extends('UI.RBAC.menu')

@section('container')
  @parent
  <div class="user_message_card">
    <div class="user_card">
      <div class="label">
        <span>{{__('RBAC.dialog.label.user_name')}}:</span>
      </div>
      <div class="message">
        <span>{{ Auth::user()->name }}</span>
      </div>
    </div>
    <div class="title user_card">
      <div class="label">
        <span>{{__('RBAC.dialog.label.account_level')}}:</span>
      </div>
      <div class="message">
        @hasanyrole('administrator|su')
          <div class="text">{{__('RBAC.menu.administrator')}}</div>
        @else
          <div class="text">{{__('RBAC.menu.general_user')}}</div>
        @endhasanyrole
      </div>
    </div>
    <div class="title role_card">
      <div class="label">
        <span>{{__('RBAC.dialog.label.role')}}:</span>
      </div>
      <div class="message">
        @foreach (Auth::user()->getRoleNames() as $role)
          <div class="text role_button">{{ $role }}</div>
        @endforeach
      </div>
    </div>
    <div class="title permission_card">
      <div class="label">
        <span>{{__('RBAC.dialog.label.permission')}}:</span>
      </div>
      <div class="message">
        @foreach (Auth::user()->getAllPermissions()->pluck('name') as $permission)
          <div class="text permission_button">{{ $permission }}</div>
        @endforeach
      </div>
    </div>
  </div>

@endsection