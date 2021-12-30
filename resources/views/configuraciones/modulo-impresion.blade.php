@extends('layouts.app')

@section('contenido')
    <modulo-impresiones-component :userauth="{{ \Auth::user() }}"></modulo-impresiones-component>
@endsection
