@extends('layouts.app')

@section('contenido')
    <tickets-component :userauth="{{ \Auth::user() }}"></tickets-component>
@endsection

