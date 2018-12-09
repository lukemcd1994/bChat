<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatTest extends TestCase
{
    /**
     *
     */
    public function testCreateChat(){
        $user = \App\User::where('name', 'luke')->first();
        $user2 = \App\User::where('name', 'sam')->first();
        $Date = date('Y-m-d');
        $data = [
            'user2_name' => $user2->name,
            'delete_at' => date('Y-m-d', strtotime($Date. ' + 1 days')),
            'ecdh_pub' => '04007965a3baccbfbd5ece64c408cc9fd438f3ac552bda092a390be34359ba39cc61c417339cfd6c54b930a4e89e4e38dc193958241970a53d99a473b8c27f9080ccfa00deeae40bbed812d1d026f8157238de1144077795391955e85199464a103561312dfcd3bb9eae4042fea5c226c4cf754df5f26964497bbbda9b4869ae77786f8bbb'
        ];
        $response = $this->actingAs($user)->json('POST','/chats', $data);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJson(['message' => 'The chat request was successfully sent.']);
        $chat = \App\Chat::where('id', $response->baseResponse->original['pending_id'])->first();
        $this->assertEquals($chat->pending, 1);
        $chat->delete();
    }
    public function testUnathorizedCreateChat(){
        $user = \App\User::where('name', 'luke')->first();
        $user2 = \App\User::where('name', 'sam')->first();
        $Date = date('Y-m-d');
        $data = [
            'user2_name' => $user2->name,
            'delete_at' => date('Y-m-d', strtotime($Date. ' + 1 days')),
            'ecdh_pub' => '04007965a3baccbfbd5ece64c408cc9fd438f3ac552bda092a390be34359ba39cc61c417339cfd6c54b930a4e89e4e38dc193958241970a53d99a473b8c27f9080ccfa00deeae40bbed812d1d026f8157238de1144077795391955e85199464a103561312dfcd3bb9eae4042fea5c226c4cf754df5f26964497bbbda9b4869ae77786f8bbb'
        ];
        $response = $this->json('POST','/chats', $data);
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
    /**
     *
     */
    public function testAcceptChat(){
        $user = \App\User::where('name', 'luke')->first();
        $user2 = \App\User::where('name', 'sam')->first();
        $chat = \App\Chat::where('user2_id', $user2->id)->where('user1_id',$user->id)->where('pending', 1)->first();
        $data = [
            'delete_at' => $chat->delete_at,
            'ecdh_pub' => '0401bee97da5a5cc6da1010e6755be37bf9deaf8f6859552f268c278cd6e4a6a0c7c9c07f877eeab8648d494273be4bd6052588dde297aa8a9b10f73e3993df81b7c0200c6ac58774aefafea82ea01117327fb35dcda2e094744ef4f6224dacec92ee6d7f2689cc6807f9f8058ec617fbc732d8b8dc90f21b1cae1359509440986cfb563d9',
            'pending_id' => $chat->id,
            'pending_method' => 'accept',
            'pending_secret' => $chat->pending_secret,
            'user2_name' => $user->name
        ];
        $response = $this->actingAs($user2)->json('POST', '/chats', $data);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJson(['message' => 'The chat request was accepted.']);
        $chat = \App\Chat::where('id', $chat->id)->first();
        $this->assertEquals($chat->pending, 0);
    }

    public function testRejectChat(){
        $user = \App\User::where('name', 'luke')->first();
        $user2 = \App\User::where('name', 'sam')->first();
        $chat = \App\Chat::where('user2_id', $user2->id)->where('user1_id',$user->id)->where('pending', 1)->first();
        $data = [
            'delete_at' => $chat->delete_at,
            'pending_id' => $chat->id,
            'pending_method' => 'decline',
            'pending_secret' => $chat->pending_secret,
            'user2_name' => $user->name
        ];
        $response = $this->actingAs($user2)->json('POST', '/chats', $data);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJson(['message' => 'The chat request was declined.']);
        $chat = \App\Chat::where('id', $chat->id)->first();
        $this->assertEquals($chat, null);
    }

    public function testUnauthenticatedGetChats(){
        $user = \App\User::where('name', 'luke')->first();
        $response = $this->json('GET', '/chats');
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testSendMessage(){
        $user = \App\User::where('name', 'luke')->first();
        $chat = \App\Chat::where('user1_id', $user->id)->first();
        $user2 = \App\User::where('id', $chat->user2_id)->first();
        $response = $this->actingAs($user)->json('POST', '/send',
            ['chat_id' => $chat->id, 'receiver' => $user2->name, 'message_body' => 'Test message']
        );
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function testUnauthenticatedSendMessage(){
        $user = \App\User::where('name', 'luke')->first();
        $chat = \App\Chat::where('user1_id', $user->id)->first();
        $user2 = \App\User::where('id', $chat->user2_id)->first();
        $response = $this->json('POST', '/send',
            ['chat_id' => $chat->id, 'receiver' => $user2->name, 'message_body' => 'Test message']
        );
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testGetMessages(){
        $user = \App\User::where('name', 'luke')->first();
        $chat = \App\Chat::where('user1_id', $user->id)->first();
        $response = $this->actingAs($user)->json('POST', '/messages' ,['chat_id' => $chat->id]);
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'data' => [
                    [
                        'message_body'
                    ]
                ]
            ]
        );
    }

    public function testUnauthenticatedGetMessages(){
        $user = \App\User::where('name', 'luke')->first();
        $chat = \App\Chat::where('user1_id', $user->id)->first();
        $response = $this->json('POST', '/messages' ,['chat_id' => $chat->id]);
        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthenticated.']);
    }
}
