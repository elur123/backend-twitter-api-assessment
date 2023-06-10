<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TweetStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:350'],
            'files.*' => ['mimetypes:image/jpeg,image/png,video/mp4'],
        ];
    }
}
