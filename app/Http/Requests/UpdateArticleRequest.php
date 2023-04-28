<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'         => ['sometimes','required', 'string', 'max:255', 'unique:articles,id'],
            'excerpt'       => ['required','string'],
            'description'   => ['required','string'],
            'status'        => ['in:on'],
            'category_id'   => ['required','integer','exists:categories,id'],
            'tags'          => ['nullable','array'],

        ];
    }
}
