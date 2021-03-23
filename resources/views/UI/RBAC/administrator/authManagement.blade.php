@extends('UI.RBAC.menu')

@section('container')
  @parent
  <auth-management message="{{$message}}"></auth-management>

@endsection