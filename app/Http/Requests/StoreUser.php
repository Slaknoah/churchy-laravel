<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:6', 'confirmed'],
                    'roles' => ['required']
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $rules =  [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255',
                    Rule::unique('users')->ignore($this->user),],
                    'user_avatar' => 'file|image|mimes:jpeg,png,gif,webp|max:2048',
                ];
        
        
                if(auth()->user()->can('updateUserRole', User::class)) {
                    $rules['roles'] = 'required';
                }
        
        
                return $rules;
            }
            default: break;
        }

        
    }
}
