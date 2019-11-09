<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSong extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'title' => 'required',
            'song_cover' => 'file|image|mimes:jpeg,png,gif,webp|max:2048',
            'original_song' => 'file|mimes:mpga,wav,mp3,mp4,avi,mpeg,quicktime|max:200000',
        ];
    }
}
