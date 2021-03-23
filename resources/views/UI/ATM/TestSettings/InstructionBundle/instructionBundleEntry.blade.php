@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.TestSettings.menu')
  <instruction-bundle-entry message="{{$message}}"></instruction-bundle-entry>
@endsection