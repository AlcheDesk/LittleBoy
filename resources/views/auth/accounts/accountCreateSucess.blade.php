@extends('auth.accounts.accountHome')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('accountCreatSucess') }}</div>

            <div class="card-body">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <span style="font-size: 13px; color: #7cabce; font-weight: bold">{{ __('account.accountCreateSucessInfo') }}</span>
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-md-8 offset-md-2">
                            <input id="inviteCode" type="text" class="form-control{{ $errors->has('inviteCode') ? ' is-invalid' : '' }}" maxlength="36" name="inviteCode" value="{{ __('account.inviteCode') }} :{{ $invite_code }}" readonly="readonly" required autofocus>

                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-4 offset-md-6">
                            <button id="accountJoin" type="submit" class="btn btn-primary">
                                <a href="{{ route('accountListShow') }}">{{ __('account.get_into') }}</a>
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection



