<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'series_id' => $this->series_id,
            'content' => $this->content,
            'cover_image' => $this->cover_image,
            'author_id' => $this->author_id,
            'published' => $this->published,
            'links' => [
                'self' => route('articles.show', ['article' => $this->id])
            ]
        ];
    }
}
