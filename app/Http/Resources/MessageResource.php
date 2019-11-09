<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'title' => $this->title,
            'media' => $this->media,
            'speaker_id' => $this->speaker_id,
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'author_id' => $this->author_id,
            'series_id' => $this->series_id,
            'metas' => $this->metas()->pluck('meta_value', 'meta_key'),
            'links' => [
                'self' => route('messages.show', ['message' => $this->id])
            ]
        ];
    }
}
