@extends('UI.ATM.debugMenu')

@section('container')
  @parent
  @include('UI.ATM.DebugResult.menu')
  <debug-instruction message="{{$message}}"></debug-instruction>
@endsection