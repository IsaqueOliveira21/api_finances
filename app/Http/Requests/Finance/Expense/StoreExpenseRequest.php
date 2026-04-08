<?php

namespace App\Http\Requests\Finance\Expense;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
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
            'description' => 'nullable|string|max:255',
            'type' => 'required|string|in:unique,installment,recurring',
            'total_amount' => 'required|numeric',
            'category' => 'required|string',
            'first_due_date' => 'required|date',
            'installment_count' => Rule::when(
                $this->input('type') === 'installment',
                ['required', 'integer', 'min:1'],
                ['nullable', 'integer'],
            ),
        ];
    }

    public function messages(): array {
        return [];
    }
}