<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExchangeRateFilterRequest extends FormRequest
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
            'currency_from' => 'sometimes|string|size:3',
            'currency_to' => 'sometimes|string|size:3',
            'rate_date' => ['sometimes', Rule::date()->format('Y-m-d')],
            'retrieved_at' => ['sometimes', Rule::date()->format('Y-m-d')],
        ];
    }
}
