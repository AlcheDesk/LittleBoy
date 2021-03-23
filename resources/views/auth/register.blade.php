@extends('layout.app')

@section('content')
<!-- <div class="container-fluid login_container">
  <div class="row login_menu">
    <div class="col-md-2">
      <ul class="nav nav-pills nav-justified">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
      </ul>
    </div>
  </div>
  <div class="row login_img">
    <div class="col-md-4">
      <img src="/img/logo.png">
    </div>
  </div>
  <div class="row justify-content-center "> -->
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">{{ __('auth.register') }}</div>

        <div class="card-body">
          <form id="registerForm" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('auth.name') }}</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" maxlength="16" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('auth.email_address') }}</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.password') }}</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('auth.confirm_password') }}</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
              </div>
            </div>
<!--
            <div class="form-group row">
              <label for="inviteCode" class="col-md-4 col-form-label text-md-right">{{ __('InviteCode') }}</label>

              <div class="col-md-6">
                <input id="inviteCode" type="inviteCode" class="form-control{{ $errors->has('inviteCode') ? ' is-invalid' : '' }}" name="inviteCode" required>

                @if ($errors->has('inviteCode'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('inviteCode') }}</strong>
                </span>
                @endif
              </div>
            </div> -->

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button id="register" type="submit" class="btn btn-primary">
                  {{ __('auth.register') }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <!-- </div> -->
<!-- </div> -->
@endsection


@section('scriptAfterJs')
<script type="text/javascript">
  $('#register').on('click', function() {
    $('#register').attr('disabled', 'true');
    $('#registerForm').submit();
  })
</script>
@endsection