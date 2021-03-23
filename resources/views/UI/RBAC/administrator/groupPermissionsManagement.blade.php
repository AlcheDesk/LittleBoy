@extends('UI.RBAC.menu')

@section('container')
  @parent
  <group-permission message="{{$message}}"></group-permission>

@endsection