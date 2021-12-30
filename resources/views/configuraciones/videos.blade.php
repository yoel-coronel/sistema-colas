@extends('layouts.app')

@section('contenido')
    <videos-component :userauth="{{ \Auth::user() }}"></tickets-component>
@endsection
