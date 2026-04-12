<?php

namespace App\Http\Controllers\Finance\Expense;

use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Models\ExpenseInstallment;
use App\Domain\Finance\Expense\Services\ExpenseInstallmentService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Finance\Expense\ExpenseInstallmentResource;
use App\Http\Resources\Finance\Expense\ExpenseResource;
use App\Traits\Api\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ExpenseInstallmentController extends Controller
{
    use ApiResponse;

    public function __construct(
        private ExpenseInstallmentService $expenseInstallmentService,
    ) {}

    public function index(Expense $expense) {
        try {
            $this->authorize("view", $expense);
            $installments = $this->expenseInstallmentService->index($expense);
            return $this->successResponse(ExpenseInstallmentResource::collection($installments), '', 200);
        } catch (AuthorizationException $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 403);
        } catch (Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 500);
        }
    }

    public function pay(Expense $expense, ExpenseInstallment $expenseInstallment) {
        try {
            $this->authorize("update", $expense);
            $installment = $this->expenseInstallmentService->pay($expenseInstallment);
            return $this->successResponse(new ExpenseInstallmentResource($installment), "Installment paid successfully!", 200);
        } catch (AuthorizationException $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 403);
        } catch (Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 500);
        }
    }
}
