@extends('UI.ATM.debugMenu')

@section('container')
  @parent
  @include('UI.ATM.DebugResult.menu')
  <debug-testcase message="{{$message}}"></debug-testcase>
@endsection