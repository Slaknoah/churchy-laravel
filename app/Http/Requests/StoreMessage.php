<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessage extends FormRequest
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
            'cover_image' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'media.*' => 'file|mimes:mpga,wav,mp3,mp4,m4p,avi,mpeg,quicktime|max:200000',
            'series_id' => 'required'
        ];
    }

    // Setting messages
    public function messages() 
    {
        return [
            'title.required' => 'Title can not be left empty',
        ];
    }
}
