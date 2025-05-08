<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhatsAppWebhook extends FormRequest
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
            'timestamp' => ['required'],
            'event' => ['required'],
            'contact' => ['required', 'array'],
            'contact.phone' => ['required'],
            'contact.displayName' => ['required'],
            'object' => ['required', 'array'],
            'object.type' => ['required'],
            'object.id' => ['required'],
            'payload' => ['required', 'array'],
        ];
    }
}
