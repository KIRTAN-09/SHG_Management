@extends('adminlte::page')

@section('title', 'Notifications')

@section('content_header')
    <h1>Notifications</h1>
@stop

@section('content')
    <div class="container">
        @if(count($notifications) > 0)
            <ul class="list-group">
                @foreach($notifications as $notification)
                    <li class="list-group-item">{{ $notification }}</li>
                @endforeach
            </ul>
        @else
            <p>No notifications available.</p>
        @endif
    </div>
@stop
