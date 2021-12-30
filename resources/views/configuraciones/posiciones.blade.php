@extends('layouts.app')

@section('contenido')
    <posiciones-component :userauth="{{ \Auth::user() }}"></posiciones-component>
@endsection
