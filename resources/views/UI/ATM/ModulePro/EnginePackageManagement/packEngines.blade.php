@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.ModulePro.menu')
  <pack-engines message="{{$message}}"></pack-engines>
@endsection