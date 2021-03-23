@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <system-setting message="{{$message}}"></system-setting>

@endsection