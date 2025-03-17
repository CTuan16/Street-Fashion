<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required','email:rfc','unique:users,email',
                Rule::unique('users')->ignore($this->email)],
            'role' => 'required|string|max:255', // Thêm rule required cho role
            'password' => 'required|min:1',
            'password_confirmation' => 'required|same:password'
        ];
    }
    
    public function messages()
    {
        return [
            'role.required' => 'Vui lòng chọn vị trí cho người dùng.',
        ];
    }
}
