<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SongResource extends JsonResource
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
            'artist' => $this->artist,
            'chord' => $this->chord,
            'tempo' => $this->tempo,
            'original_song' => $this->original_song,
            'song_cover' => $this->song_cover,
            'author_id' => $this->author_id,
            'links' => [
                'self' => route('songs.show', ['song' => $this->id])
            ]
        ];
    }
}
