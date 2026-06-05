<?php

namespace App\Domain\Finance\Transaction\Models;

use App\Domain\Finance\Expense\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = "transactions";

    protected $fillable = [
        "user_id",
        "expense_id",
        "type",
        "amount",
        "description",
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function expense() {
        return $this->belongsTo(Expense::class);
    }
}