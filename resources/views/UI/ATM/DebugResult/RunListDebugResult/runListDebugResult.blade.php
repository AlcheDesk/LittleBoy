@extends('UI.ATM.debugMenu')

@section('container')
  @parent
  @include('UI.ATM.DebugResult.menu')
  <debug-runlist message="{{$message}}"></debug-runlist>
@endsection