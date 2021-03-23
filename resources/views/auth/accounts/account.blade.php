@extends('auth.accounts.accountHome')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('account.accounts') }}</div>

            <div class="card-body">
                <form id="accountForm" method="GET" action="">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <span style="color:#7cabce; font-size: 13px; font-weight: bold">{{ __('account.accountsInfo') }}</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <el-button type="success" style="width: 200px;">
                                <a href="{{ route('accountCreateShow') }}" style="color: white; font-size: 15px;">{{ __('account.creat') }}</a>
                            </el-button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <el-button type="primary" style="width: 200px;">
                                <a href="{{ route('accountJoinShow') }}" style="color: white; font-size: 15px;">{{ __('account.join') }}</a>
                            </el-button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <el-button type="info" style="width: 200px;">
                                <a href="/home/individual/{{ Auth::user()->uuid }}">{{ __('account.individual') }}</a>
                            </el-button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection



