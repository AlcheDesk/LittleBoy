@extends('UI.ATM.debugMenu')

@section('container')
  @parent
  @include('UI.ATM.DebugResult.menu')
  <debug-api-instruction message="{{$message}}"></debug-api-instruction>
@endsection