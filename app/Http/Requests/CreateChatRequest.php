<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*
         * Currently don't need to do any additional authorization - being logged in is enough and that is handled via
         * the middleware.
         * In the future, this could potentially be used to check if the user's email has been verified, for example
        */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user2_name' => [
                'required',
                'string',
                'max:255',
                Rule::exists('users', 'name')->whereNot('name', Auth::user()->name)
            ],
            'delete_at' => 'required|date|after:now',
            'pending_id' => 'required_with_all:pending_secret,pending_method|integer|exists:chats,id,pending,1',
            'pending_secret' => 'required_with_all:pending_id,pending_method|string|size:23|exists:chats,pending_secret,id,' . $this->request->get('pending_id'),
            'pending_method' =>  [
                'required_with_all:pending_id,pending_secret',
                'string',
                Rule::in(['accept', 'decline']),
            ]
        ];
    }
}
