<?php

namespace App\Exceptions;

use Exception;

class InvalidExpenseTypeException extends Exception
{
    public function __construct(
        string $message = "Invalid Expense Type, Recurring Expense Needed!",
    ) {
        parent::__construct($message);
    }
}