<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Only users with an author profile (Kagawads/officials) can post.
     * Residents have no author, so they get a 403.
     */
    public function authorize(): bool
    {
        return $this->user()?->author !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'body' => ['required', 'string', 'min:20'],
            'category' => ['required', 'in:'.implode(',', Post::CATEGORIES)],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['exists:tags,id'],
            'is_published' => ['boolean'],
        ];
    }

    /**
     * Without this the error says "The selected tags.1 is invalid."
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tags.required' => 'Pick at least one tag.',
            'tags.*.exists' => 'One of the selected tags does not exist.',
        ];
    }
}
