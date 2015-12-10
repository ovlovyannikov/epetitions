@extends('templates.default')

@section('content')
        Натисніть тут, щоб скинути пароль: {{ url('password/reset/'.$token) }}
@stop
