@extends('layout.app')

@section('content')
<div class="col-md-6">
  <div class="card">
    <div class="card-header">{{ __('auth.login_user') }}<h1>{{$type ?? ''}}</h1></div>

    <div class="card-body">
      <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
          <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('auth.user_name') }}</label>

          <div class="col-md-6">
            <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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

      @if(session()->has('showimgcaptcha'))
        <div class="form-group row">
          <label for="captcha" class="col-md-4 col-form-label text-md-right">{{ __('auth.captcha') }}</label>

          <div class="col-md-6">
           <input id="captcha" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" required>
            <img class="thumbnail captcha mt-3 mb-2" src="{{ recaptcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
            @if ($errors->has('captcha'))
              <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('captcha') }}</strong>
              </span>
            @endif
          </div>
        </div>
      @endif

      @if(session()->has('showgooglecaptcha'))
        <div class="form-group row">
          <label for="nocaptcha" class="col-md-4 col-form-label text-md-right">{{ __('auth.captcha') }}</label>
          <div class="col-md-6">
            {!! ReNoCaptcha::renderJs() !!}
            {!! ReNoCaptcha::display() !!}
          </div>
        </div>
      @endif

        <div class="form-group row">
          <label for="domain" class="col-sm-4 col-form-label text-md-right">{{ __('auth.domain') }}</label>
          <div class="col-md-6">
            <select name="domain" id="domain" class="form-control">
                <option value="local">local</option>
                <option value="LDAP389">verificationServer:LDAP 389</option>
                <option value="LDAP636">verificationServer:LDAP 636</option>
            </select>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-6 offset-md-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

              <label class="form-check-label" style="margin-left: 20px;" for="remember">
                {{ __('auth.remember_me') }}
              </label>
            </div>
          </div>
        </div>

        <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-3">
            <button id="login" type="submit" class="btn btn-primary">
              {{ __('auth.login') }}
            </button>

            <a class="btn btn-link" href="{{ route('password.request') }}">
              {{ __('auth.forget_you_password') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scriptAfterJs')
<script type="text/javascript">
  $('#login').on('click', function() {
    $('#login').attr('disabled', 'true');
    $('#loginForm').submit();
  })
</script>
@endsection

<!-- @section('scripts')

<script src='https://www.google.com/reCAPTCHA/api.js'></script>
<script src='https://www.recaptcha.net/recaptcha/api.js'></script>
   {! NoCaptcha :: renderJs()!!}

@endsection  -->


