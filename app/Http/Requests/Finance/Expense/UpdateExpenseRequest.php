<?php

namespace App\Http\Requests\Finance\Expense;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            "description" => "nullable|string|max:255",
            "total_amount" => "required|numeric",
            "category" => "required|string",
            "first_due_date" => "required|date",
        ];
    }
}
