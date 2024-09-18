<?php

namespace App\Http\Requests;

class CommentUpdateRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'comment' => ['required', 'string']
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'comment.required' => 'comment is required',
            'comment.string' => 'comment must be of a text type'
        ];
    }
}
