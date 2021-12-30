@extends('layouts.app')

@section('contenido')

    <atencion-component :userauth="{{ \Auth::user() }}"></atencion-component>

@endsection
