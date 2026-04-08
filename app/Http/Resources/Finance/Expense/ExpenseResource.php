<?php

namespace App\Http\Resources\Finance\Expense;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'user_id'=> $this->user_id,
            'description'=> $this->description,
            'type'=> $this->type,
            'total_amount'=> $this->total_amount,
            'category'=> $this->category,
            'first_due_date'=> $this->first_due_date,
            'installment_count'=> $this->installment_count,
        ];
    }
}