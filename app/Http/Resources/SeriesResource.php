<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeriesResource extends JsonResource
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
            'metas' => $this->metas()->pluck('meta_value', 'meta_key'),
            'links' => [
                'self' => route('series.show', ['series' => $this->id])
            ]
        ];
    }
}
