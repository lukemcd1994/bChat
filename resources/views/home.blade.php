@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" v-for="comp in compArray">
        <!-- <chats-component></chats-component>
				<current-chat-component></current-chat-component> -->
				<component :is=comp>
				</component>
    </div>
</div>
@endsection
