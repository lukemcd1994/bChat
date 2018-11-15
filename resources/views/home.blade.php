@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <chats-component></chats-component>
        <current-chat-component></current-chat-component>
        <accept-chat-modal></accept-chat-modal>
    </div>
</div>
@endsection