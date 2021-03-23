@extends('layout.app')

@section('content')
<div class="col-md-6">
  <div class="card">
    <div class="card-header">获取邀请码</div>

    <div class="card-body">
        
        <form method="GET" action="{{ route('invite') }}">
        <div class="form-group row">
          <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

          <div class="col-md-6">
            <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
          </div>

            <button type="submit" style="height: 50%;" class="btn btn-primary">{{ __('send') }}</button>

        </div>
        </form>
    </div>
  </div>
</div>
@endsection
