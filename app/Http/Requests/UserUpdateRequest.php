<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', Rule::unique('users')->ignore($this->user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
            'password' => ['string', 'min:8'],
            'bio' => ['string', 'max:150'],
            'birth_date' => ['date'],
            'location' => ['string', 'max:255']
        ];
    }
}
