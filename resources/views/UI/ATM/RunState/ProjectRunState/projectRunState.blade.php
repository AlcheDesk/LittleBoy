@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunState.menu')
  <project-runstatus message="{{$message}}"></project-runstatus>
@endsection