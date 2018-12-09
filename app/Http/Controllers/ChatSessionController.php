<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\ChatAcceptedEvent;
use App\Http\Requests\CreateChatRequest;
use App\Http\Resources\ChatCollection;
use App\User;
use App\Events\NewChatRequestedEvent;
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

        if (!(array_key_exists('pending_method', $validatedData))) {

            $newChat = Chat::create([
                'user1_id' => Auth::user()->id,
                'user2_id' => User::where('name', $validatedData['user2_name'])->value('id'),
                'delete_at' => date('Y-m-d H:i:s', strtotime($validatedData['delete_at'])),
                'pending' => 1,
                'pending_secret' => uniqid('', true)
            ]);

            event(new NewChatRequestedEvent(
                User::findOrFail(User::where('name', $validatedData['user2_name'])->value('id')),
                [
                    'pending_id' => $newChat->id,
                    'with' => Auth::user()->name,
                    'pending_secret' => $newChat->pending_secret,
                    'delete_at' => $newChat->delete_at,
                    'ecdh_pub' => $validatedData['ecdh_pub']
                ]
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'The chat request was successfully sent.',
                'pending_id' => $newChat->id
            ]);
        }
        else {

            if ($validatedData["pending_method"] === "accept") {
                Chat::find($validatedData["pending_id"])->update(array('pending' => 0));

                event(new ChatAcceptedEvent(
                    User::findOrFail(User::where('name', $validatedData['user2_name'])->value('id')),
                    [
                        'id' => $validatedData['pending_id'],
                        'delete_at' => date('Y-m-d H:i:s', strtotime($validatedData['delete_at'])),
                        'with' => Auth::user()->name,
                        'ecdh_pub' => $validatedData['ecdh_pub']
                    ]
                ));

                return response()->json([
                    'status' => 'success',
                    'message' => 'The chat request was accepted.',
                ]);
            }
            else if ($validatedData["pending_method"] === "decline") {

                Chat::find($validatedData["pending_id"])->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'The chat request was declined.',
                ]);
            }
            else {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid pending_method was received!',
                ], 422);
            }
        }
    }
}
