<?php

namespace App\Domain\Finance\Expense\Models;

use App\Domain\Finance\Transaction\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
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

    public function getRecurringStatus(): String {
        $currentMonthPayment = $this->transactions
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->first();
        $dueDate = Carbon::parse($this->first_due_date)->day;
        if($currentMonthPayment) return 'paid';
        if(Carbon::now()->day < $dueDate) return 'pending';
        return 'late';
    }

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