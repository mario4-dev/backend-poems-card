<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePoemRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'content' => 'required|string|min:10|max:5000',
            'author' => 'required|string|max:255|min:2',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
            'published' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título debe tener al menos 3 caracteres.',
            'title.max' => 'El título no puede exceder 255 caracteres.',
            'content.required' => 'El contenido es obligatorio.',
            'content.min' => 'El contenido debe tener al menos 10 caracteres.',
            'content.max' => 'El contenido no puede exceder 5000 caracteres.',
            'author.required' => 'El autor es obligatorio.',
            'author.min' => 'El autor debe tener al menos 2 caracteres.',
            'author.max' => 'El autor no puede exceder 255 caracteres.',
            'color.required' => 'El color es obligatorio.',
            'color.regex' => 'El color debe ser un código hexadecimal válido (ej: #FF0000).',
        ];
    }
}
