@extends('UI.ATM.menu')

@section('container')
  @parent
  @include('UI.ATM.RunResult.menu')
  <run-instruction-runresult message="{{$message}}"></run-instruction-runresult>
@endsection