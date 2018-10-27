<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Chat extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'with' => User::findOrFail(Auth::user()->id == $this->user1_id ? $this->user2_id : $this->user1_id)->name,
            'delete_at' => $this->delete_at
        ];
    }
}
