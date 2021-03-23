@extends('UI.ATM.debugMenu')

@section('container')
  @parent
  @include('UI.ATM.DebugResult.menu')
  <debug-case message="{{$message}}"></debug-case>
@endsection