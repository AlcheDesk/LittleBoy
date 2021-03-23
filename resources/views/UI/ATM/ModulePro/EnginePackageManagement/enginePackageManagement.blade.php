@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.ModulePro.menu')
  <engine-packs message="{{$message}}"></engine-packs>
@endsection