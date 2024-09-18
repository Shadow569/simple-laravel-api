<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogPostUpdateRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function rules(Request $request): array
    {
        return [
            'title' => ['sometimes', 'required', 'string'],
            'content' => ['nullable', 'string'],
            'slug' => ['sometimes', 'required', 'string', Rule::unique('posts', 'slug')->ignore($request->route('id'))],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', Rule::exists('categories', 'id')],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', Rule::exists('tags', 'id')]
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.required' => 'title is required',
            'title.string' => 'title must be of a text type',
            'content.string' => 'content must be of a text type',
            'slug.required' => 'slug is required',
            'slug.string' => 'slug must be of a text type',
            'slug.unique' => 'the slug is already used',
            'categories.array' => 'categories must be an array',
            'categories.*.integer' => 'category entry should be an integer number',
            'categories.*.exists' => 'given category doesnt exist',
            'tags.*.integer' => 'tag entry should be an integer number',
            'tags.*.exists' => 'given tag doesnt exist',
        ];
    }
}
