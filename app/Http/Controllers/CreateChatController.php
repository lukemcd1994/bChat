<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;

use App\Http\Requests\CreateChatRequest;
use App\Chat;

class CreateChatController extends Controller
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
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\CreateChatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateChatRequest $request)
    {
        $validatedData = $request->validated();

        // TODO Setup key exchange before creating the chat model

        Chat::create([
                'user1_id' => Auth::user()->id,
                'user2_id' => User::where('name', $validatedData['user2_name'])->firstOrFail()->value('id'),
                'delete_at' => date('Y-m-d H:i:s', strtotime($validatedData['delete_at']))
            ]);

        return $validatedData;
    }
}
