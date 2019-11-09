<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => (string)$this->id,
            'name' => $this->name,
            'email' => $this->email,
            'user_avatar' => $this->user_avatar,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'roles' => $this->roles()->get(),
            'metas' => $this->metas()->pluck('meta_value', 'meta_key'),
            'links' => [
                'self' => route('users.show', ['user' => $this->id])
                ]
            ];
    }
}
