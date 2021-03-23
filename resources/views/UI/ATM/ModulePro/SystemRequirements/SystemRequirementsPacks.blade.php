@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.ModulePro.menu')
  <system-requirements-packs message="{{$message}}"></system-requirements-packs>
@endsection