@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.ModulePro.menu')
  <pack-system-requirements message="{{$message}}"></pack-system-requirements>
@endsection