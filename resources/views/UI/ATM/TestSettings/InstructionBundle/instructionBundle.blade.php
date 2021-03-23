@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <instruction-bundle message="{{$message}}"></instruction-bundle>
@endsection