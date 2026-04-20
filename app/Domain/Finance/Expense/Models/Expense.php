<?php

namespace App\Domain\Finance\Expense\Models;

use App\Domain\Finance\Transaction\Models\Transaction;
use App\Models\User;
use Database\Factories\ExpenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes, HasFactory;

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

    protected static function newFactory()
    {
        return ExpenseFactory::new();
    }

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