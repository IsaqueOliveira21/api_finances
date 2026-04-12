<?php

namespace App\Domain\Finance\Expense\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ExpenseInstallment extends Model
{
    use SoftDeletes;

    protected $table = "expenses_installments";

    protected $fillable = [
        "expense_id",
        "installment_number",
        "amount",
        "due_date",
        "paid_at",
    ];

    public function expense() {
        return $this->belongsTo(Expense::class);
    }
}