@extends('auth.accounts.accountHome')

@section('content')

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <span style="font-size: 13px; color: #7cabce; font-weight: bold">{{ __('account.accountChooseInfo') }}</span>

                <div style="float:right">
                  <button type="submit" class="btn btn-primary">
                      <a href="{{ route('accountListShow') }}" style="color: #fff !important;">{{ __('account.accountChoose') }}</a>
                  </button>
              </div>
            </div>

            <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-8 offset-md-2">
                        </div>
                    </div>

                    <el-row>
                        @foreach ($account_name as $name)
                        <el-col :span="8">
                            <el-card :body-style="{ padding: '0px' }" style="background-color: #7cabce;margin: 20px;">
                                <div id="accountShow" style="padding: 14px; display: flex;">
                                    <div style="flex: 3">
                                      <span style="color: white">{{ $name->name }}</span>
                                    </div>
                                    <div style="flex: 1; 
                                                display: flex;
                                                justify-content: flex-end;
                                                align-items: center;">
                                        <i class="el-tag__close el-icon-close" onclick="event.preventDefault();
                                        document.getElementById('account-exit-{{$name->name}}').submit();"></i>
                                      <form id="account-exit-{{ $name->name }}" action="{{ route('exitAccount') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="account_uuid" name="account_uuid" value="{{ $name->uuid }}">
                                      </form>
                                    </div>
                                </div>
                            </el-card>
                        </el-col>
                        @endforeach
                    </el-row>
            </div>
        </div>
    </div>
@endsection



