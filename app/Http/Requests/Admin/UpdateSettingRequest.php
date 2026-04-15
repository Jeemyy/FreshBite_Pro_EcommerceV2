<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'about'             => 'nullable|string|max:500',
            'contact.address'   => 'nullable|string|max:255',
            'contact.email'     => 'nullable|email|max:255',
            'contact.phone'     => 'nullable|string|max:20',
            'pages'             => 'required|array',       // لازم يختار صفحة واحدة على الأقل
            'pages.*'           => 'required|string|max:255', // كل عنصر في array لازم يكون نص
        ];
    }
}
