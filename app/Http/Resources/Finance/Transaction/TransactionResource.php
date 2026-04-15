<?php

namespace App\Http\Resources\Finance\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "expense_id" => $this->expense_id,
            "type" => $this->type,
            "amount" => $this->amount,
            "description" => $this->description,
        ];
    }
}
