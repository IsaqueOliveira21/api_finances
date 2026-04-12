<?php

namespace App\Http\Resources\Finance\Expense;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseInstallmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "expense_id" => $this->expense_id,
            "installment_number" => $this->installment_number,
            "amount" => $this->amount,
            "due_date" => $this->due_date,
            "paid_at" => $this->paid_at,
            "created_at" => $this->created_at,
        ];
    }
}