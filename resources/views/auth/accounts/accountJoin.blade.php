@extends('auth.accounts.accountHome')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ __('account.accountJoin') }}
            <div style="float:right">
                <button type="submit" class="btn btn-primary">
                    <a href="{{ route('accountCreateShow') }}" style="color: #fff !important;">{{ __('account.creat') }}</a>
                </button>
            </div>
            </div>

            <div class="card-body">
                <form id="accountForm" method="POST" action="{{ route('accountJoin') }}">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <span  style="font-size: 13px; color: #7cabce; font-weight: bold">{{ __('account.accountJoinInfo') }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inviteCode" class="col-md-3 col-form-label text-md-right">{{ __('account.inviteCode') }}</label>

                        <div class="col-md-7">
                            <input id="inviteCode" type="text" class="form-control{{ $errors->has('inviteCode') ? ' is-invalid' : '' }}" maxlength="36" name="inviteCode" placeholder="请输入团队邀请码" required autofocus>

                            @if ($errors->has('inviteCode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('inviteCode') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-5 offset-md-5">
                            @if ($errors->any())
                                <span style="color: red">
{{--                                    {!! implode('', $errors->all('<div>:message</div>')) !!}--}}
                                    {{ __('account.accountSubmitErrorMsg') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6">
                            <button id="accountJoin" type="submit" class="btn btn-primary">
                                {{ __('account.join_meowlomo') }}
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



