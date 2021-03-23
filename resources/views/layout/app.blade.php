<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="{{ URL::asset('img/favicon.ico') }}" type="image/x-icon" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="lang-token" content="{{ session('lang') }}">
  <title>{{ session()->pull('title', 'AlcheDesk') }}</title>
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('styleAfterCss')
</head>
<body>
  <div id="app">
    <div class="layout">
      @guest
      <div class="container-fluid login_container">
        <div class="row login_menu">
          @if(session('message'))
          <div class="col-md-4">
            <div class="alert alert-{{session('type')}} alert-dismissable">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>{{ session('message') }}</strong>
            </div>
          </div>
          @endif
          <div class="col-md-2">
            <ul class="nav nav-pills nav-justified">
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('auth.register') }}</a>
              </li>
            </ul>
          </div>
          <div class="col-md-1">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="text" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ session('lang') == 'en' ? 'English' : '中文' }} <span class="caret"></span>
                </a>
                <div style="min-width: 100px;" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
        <div class="row login_img">
          <div class="col-md-4">
            <img src="/img/logo.png">
          </div>
        </div>
        <div class="row justify-content-center login_form">
          @yield('content')
        </div>
      </div>
      @else
        @yield('content')
      @endguest
    </div>
  </div>
  <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
  @yield('scriptAfterJs')
</body>

</html>
