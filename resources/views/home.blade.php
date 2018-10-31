@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <chats-component></chats-component>
				<current-chat-component></current-chat-component>
    </div>
</div>
@endsection
