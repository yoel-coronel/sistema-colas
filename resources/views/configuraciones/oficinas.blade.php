@extends('layouts.app')

@section('contenido')
    <oficinas-component :userauth="{{ \Auth::user() }}"></oficinas-component>
@endsection

