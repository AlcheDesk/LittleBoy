@extends('UI.RBAC.menu')

@section('container')
  @parent
  <user-log  message="{{$message}}"></user-log>

@endsection