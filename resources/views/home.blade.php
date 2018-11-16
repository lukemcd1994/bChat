@extends('layouts.app')

@section('content')
<div id="root" class="container">
    <div class="row justify-content-left">
        <chats-component v-if="chatsVisible"></chats-component>
				<current-chat-component v-if="currentChatVisible"></current-chat-component>
				<new-chat-component v-if="newChatVisible"></new-chat-component>
				<chat-created-component v-if="chatCreatedVisible"></chat-created-component>
    </div>
</div>
@endsection
