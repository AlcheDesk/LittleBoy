@extends('UI.ATM.debugMenu')

@section('container')
  @parent
  @include('UI.ATM.DebugResult.menu')
  <debug-runcase message="{{$message}}"></debug-runcase>
@endsection