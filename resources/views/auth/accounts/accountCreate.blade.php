@extends('auth.accounts.accountHome')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('account.creat') }}</div>

            <div class="card-body">
                <form id="accountForm" method="POST" action="{{ route('accountCreate') }}">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <span style="font-size: 13px; color: #7cabce; font-weight: bold">{{ __('account.accountCreateInfo') }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('account.name') }}</label>

                        <div class="col-md-7">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" maxlength="16" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                            <label for="industry" class="col-md-3 col-form-label text-md-right">{{ __('account.industry') }}</label>

                            <div class="col-md-7">
                                <input id="industry" type="text" class="form-control{{ $errors->has('industry') ? ' is-invalid' : '' }}" maxlength="16" name="industry" required>

                                @if ($errors->has('industry'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('industry') }}</strong>
                                </span>
                                @endif
                            </div>
                    </div>

                    <div class="form-group row">
                        <label for="position" class="col-md-3 col-form-label text-md-right">{{ __('account.position') }}</label>

                        <div class="col-md-7">
                            <input id="position" type="text" class="form-control{{ $errors->has('industry') ? ' is-invalid' : '' }}" maxlength="16" name="position" required>

                            @if ($errors->has('position'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('position') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="contact" class="col-md-3 col-form-label text-md-right">{{ __('account.contact') }}</label>

                        <div class="col-md-7">
                            <input id="contact" type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" maxlength="16" name="contact" required>

                            @if ($errors->has('contact'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('contact') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone_number" class="col-md-3 col-form-label text-md-right">{{ __('account.phone_number') }}</label>

                        <div class="col-md-7">
                            <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" maxlength="16" name="phone_number" required>

                            @if ($errors->has('phone_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-2">
                            @if ($errors->any())
                                <span style="color: red">
{{--                                    {!! implode('', $errors->all('<div>:message</div>')) !!}--}}
                                    {{ __('account.accountSubmitErrorMsg') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-4 offset-md-4">
                            <button id="accountAdd" type="submit" class="btn btn-primary">
                                {{ __('account.create') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



