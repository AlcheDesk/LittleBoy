@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.ModulePro.menu')
  <engine-setting message="{{$message}}"></engine-setting>
@endsection