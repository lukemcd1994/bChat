<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Http\Requests\CreateChatRequest;
use App\Http\Resources\ChatCollection;
use App\User;
use Illuminate\Support\Facades\Auth;

class ChatSessionController extends Controller
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
     * @return \App\Http\Resources\ChatCollection
     */
    public function index()
    {
        return new ChatCollection(Auth::user()->chats()->getResults());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateChatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateChatRequest $request)
    {
        $validatedData = $request->validated();

        // TODO Setup key exchange before creating the chat model

        $newChat = Chat::create([
                'user1_id' => Auth::user()->id,
                'user2_id' => User::where('name', $validatedData['user2_name'])->value('id'),
                'delete_at' => date('Y-m-d H:i:s', strtotime($validatedData['delete_at']))
            ]);

        return response()->json([
            'status' => 'success',
            'message' => 'The chat session was successfully created.',
            'chat_id' => $newChat->id
        ]);
    }
}
