<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexTransactionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "type" => "nullable|string",
            "min_amount" => "nullable|numeric|min:0",
            "max_amount" => "nullable|numeric|min:0",
            "start_date" => "nullable|date",
            "end_date" => "nullable|date",
        ];
    }

    public function messages(): array {
        return [];
    }
}
