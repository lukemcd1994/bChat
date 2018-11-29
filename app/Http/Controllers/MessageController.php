<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Chat;
use Illuminate\Http\Request;
use App\Http\Requests\NewMessageRequest;
use App\Http\Resources\MessageCollection;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;

class MessageController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\MessageCollection
     */
    public function index(Request $request) {
        return new MessageCollection(Chat::where('id', $request->chat_id)->first()->messages()->getResults());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\NewMessageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewMessageRequest $request ) {
        //Get data from request
        //chat id, message, receiver_name
        $validatedData = $request->validated();
        // return $validatedData;

        //add data to messages table
        $newMessage = Message::create([
            'chat_id' => $validatedData['chat_id'],
            'message_content' => $validatedData['message_body']
        ]);

        //send message to receiving user
        broadcast(new NewMessage($validatedData["receiver"], $validatedData["message_body"], $validatedData['chat_id']));

        //response to sender
        return response()->json([
            'status' => 'success'
        ]);
    }
}
