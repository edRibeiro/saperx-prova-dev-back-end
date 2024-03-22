<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('contacts', 'email')->ignore($this->id)],
            'birth_date' => 'required|date|date_format:Y-m-d',
            'phones' => 'required|array|min:1',
            'phones.*' => ['string', 'distinct', 'regex:/^\(\d{2}\) (?:9?\d{4}|\d{4}-\d{4})$/', Rule::unique('phones', 'number')->ignore($this->id, 'contact_id')->where(function ($query) {
                $query->whereNull('deleted_at');
            })]
        ];
    }
}
