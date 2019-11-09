<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'slug' => $this->slug,
            'template' => $this->template,
            'content' => $this->content,
            'author_id' => $this->author_id,
            'metas' => $this->metas()->pluck('meta_value', 'meta_key'),
            'links' => [
                'self' => route('pages.show', ['page' => $this->slug])
            ]
        ];
    }
}
