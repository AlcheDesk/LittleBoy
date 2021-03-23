@extends('layout.app')

@section('content')

<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
  <div class="container" style="height: 50px; margin-right: 5px;">
    <a class="navbar-brand" href="{{ url('/') }}">
      {{ config('app.name', 'AlcheDesk') }}
    </a>
    <div class="collapse navbar-collapse" style="float: right;" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img src="/upload/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; position:absolute; top:5px; left:-30px; border-radius:50%">
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
  </div>
</nav>
  <div class="card">
    <div class="card-header">
      <h2>{{ $user->name }}'s Profile</h2>
    </div>
    <div class="card-body">
      <div>
          <img src="upload/avatars/{{ Auth::user()->avatar }}" style="width:150px; height:150px; border-radius:0%; margin: center;">
      </div>
      <div class="form-group row"></div>

    @if(session()->has('message'))
        <div class="modal-dialog" role="document" id="myModal">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">提示信息</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeDialog()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ session()->get('message') }}</p>
            </div>
            <div class="modal-footer">
              <button onclick="closeDialog()" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      @endif

  <div style="margin-left: 140px; margin-top: 50px;">
    <form enctype="multipart/form-data" action="{{ route('update_profile_name') }}" method="POST">
      <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('auth.name') }}</label>

        <div class="" style="width:300px;">
          <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Auth::user()->name }}" required autofocus>
          @if ($errors->has('name'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('name') }}</strong>
          </span>
          @endif
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
        <div class="row-editbtn" style="margin-left: 20px;"><input type="submit" value="修改" class="btn btn-primary"></div>
      </div>
    </form>

    <form enctype="multipart/form-data" action="{{ route('update_profile_email') }}" method="POST">
      <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.email_address') }}</label>

        <div class="" style="width:300px;">
          <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::user()->email }}" required autofocus>
          @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
          @endif
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
        <div class="row-editbtn" style="margin-left: 20px;"><input type="submit" value="修改" class="btn btn-primary"></div>
      </div>
    </form>

    <form enctype="multipart/form-data" action="{{ route('update_profile_password') }}" method="POST">
      <!-- 修改密码 -->
      <div class="form-group row">
        <label for="old-password" class="col-md-4 col-form-label text-md-right">{{ __('auth.password') }}</label>
        <div class="" style="width:300px;">
          <input id="old-password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="old-password"placeholder="请输入旧密码" required autofocus>
        </div>
        <div class="row-editbtn" style="margin-left: 20px;">
           <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">修改</button>
       </div>
      </div>

    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right"></label>
        <div class="" style="width:300px;">
          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="请输入新密码" required autofocus>
          @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right"></label>
        <div class="" style="width:300px;">
          <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="确认新密码"  required>
        </div>
      </div>

      <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right"></label>
        <p>
          <button type="button" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">取消</button>
          <button type="submit" class="btn btn-default btn-sm">确定</button>
        </p>
      </div>
      </form>
    </div>

        <form enctype="multipart/form-data" action="{{ route('profile') }}" method="POST">
          <div class="form-group row">
            <label for="avatar" class="col-md-4 col-form-label text-md-right">头像</label>
            <div class='upload-border'>
              <input type="file" name="avatar" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" value="{{ old('avatar') }}" required autofocus>
                 @if ($errors->has('avatar'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('avatar') }}</strong>
                </span>
                  @endif
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </div>
          <div class="row-editbtn" style="margin-left: 20px;"><input type="submit" value="修改" class="btn btn-primary"></div>
        </div>
        </form>
  </div>
    </div>
  </div>
@endsection
<script>
  function closeDialog(){
      $("#myModal").css("display","none");
    }
</script>
@yield('scriptAfterJs')

