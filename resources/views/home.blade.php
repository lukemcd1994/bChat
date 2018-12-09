@extends('layouts.app')

@section('content')
<div id="root" class="container">
	<accept-chat-modal></accept-chat-modal>
	<div class="card">
		<!-- header content -->
		 <div class="card-header">
	        <div class="row" v-show="chatListVisible">
	            <chats-component></chats-component>
	            <header-buttons-component></header-buttons-component>
	        </div>
	        <div class="row" v-show="newChatVisible">
	            <new-chat-component></new-chat-component>
	            <header-buttons-component></header-buttons-component>
	        </div>
	    </div>
	    <!-- main content -->
		<main-component></main-component>
	</div>
</div>
@endsection