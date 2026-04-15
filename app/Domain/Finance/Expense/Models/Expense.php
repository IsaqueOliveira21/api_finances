<?php

namespace App\Domain\Finance\Expense\Models;

use App\Domain\Finance\Transaction\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $table = "expenses";

    protected $fillable = [
        'user_id',
        'description',
        'type',
        'total_amount',
        'category',
        'first_due_date',
        'installment_count',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function installments() {
        return $this->hasMany(ExpenseInstallment::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
