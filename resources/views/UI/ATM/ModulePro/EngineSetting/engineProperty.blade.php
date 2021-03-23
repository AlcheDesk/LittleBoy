@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.ModulePro.menu')
  <engine-properties message="{{$message}}"></engine-properties>
@endsection