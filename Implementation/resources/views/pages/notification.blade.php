@extends('layouts.app', ['title' => 'notification'])

@section('content')
    <div class="max-w-3xl mx-auto mt-4 p-4">
        @include("components.notification.filter")
        @include("components.notification.carte_notification")
    </div>
@endsection