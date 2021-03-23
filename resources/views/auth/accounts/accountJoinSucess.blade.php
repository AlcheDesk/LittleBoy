@extends('auth.accounts.accountHome')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('accountJoinSucess') }}</div>

            <div class="card-body">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <span style="font-size: 13px; color: #7cabce; font-weight: bold">{{ __('account.accountJoinSucessInfo1') }}<span style="font-weight: bold; font-size: 15px;">{{ $account_name }}</span>{{ __('account.accountJoinSucessInfo2') }}</span>
                        </div>
                    </div>

                <div class="form-group row"></div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button id="accountJoin" type="submit" class="btn btn-primary">
                                <a href="{{ route('accountListShow') }}">{{ __('account.get_into') }}</a>
                            </button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection



