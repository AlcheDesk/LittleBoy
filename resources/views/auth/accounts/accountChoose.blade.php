@extends('auth.accounts.accountHome')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span style="font-size: 13px; color: #7cabce; font-weight: bold">{{ __('account.accountChooseInfo') }}</span>
                
                <div style="float:right">
                    <button type="submit" class="btn btn-primary">
                        <a href="{{ route('accountExitListShow') }}" style="color: #fff !important;">{{ __('account.exit') }}</a>
                    </button>
                </div>
                <div style="float:right; margin-right: 30px;">
                    <span style="font-size: 13px; color: #45abce; font-weight: bold"> 主团队： {{ $account }}</span>
                </div>
            </div>

            <div class="card-body">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                        </div>
                    </div>
                <form id="accountListForm" method="GET" action="{{ route('accountListShow') }}">

                    <el-row>
                        @foreach ($account_name as $name)
                        <el-col :span="8">
                            <el-card :body-style="{ padding: '0px' }" style="background-color: #7cabce;margin: 20px;">
                                <div id="accountShow" style="padding: 14px; ">
                                    <a href="/home/{{ $name->name }}"><span style="color: white">{{ $name->name }}</span></a>
                                </div>
                            </el-card>
                        </el-col>
                        @endforeach
                    </el-row>
                </form>
            </div>
        </div>
    </div>
@endsection



