<?php

namespace App\Http\Requests;
use App\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfile extends FormRequest
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
        $rules =  [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,$this->id,id"],
            'user_avatar' => 'file|image|mimes:jpeg,png,gif,webp|max:2048',
        ];


        if(auth()->user()->can('updateUserRole', User::class)) {
            $rules['roles'] = 'required';
        }


        return $rules;
    }
}
