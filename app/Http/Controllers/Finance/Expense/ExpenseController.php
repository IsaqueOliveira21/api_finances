<?php

namespace App\Http\Controllers\Finance\Expense;

use App\Domain\Finance\Expense\DTOs\IndexExpenseDTO;
use App\Domain\Finance\Expense\DTOs\StoreExpenseDTO;
use App\Domain\Finance\Expense\DTOs\UpdateExpenseDTO;
use App\Domain\Finance\Expense\Models\Expense;
use App\Domain\Finance\Expense\Services\ExpenseService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\Expense\IndexExpenseRequest;
use App\Http\Requests\Finance\Expense\StoreExpenseRequest;
use App\Http\Requests\Finance\Expense\UpdateExpenseRequest;
use App\Http\Resources\Finance\Expense\ExpenseResource;
use App\Traits\Api\ApiResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    use ApiResponse;

    public function __construct(
        private ExpenseService $expenseService,
    ) {}

    public function index(IndexExpenseRequest $request) {
        try {
            $filters = $request->validated();
            $expenses = $this->expenseService->index(
                IndexExpenseDTO::fromRequest($filters),
            );
            return $this->successResponse(ExpenseResource::collection($expenses), '', 200);
        } catch(Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 500);
        }
    }

    public function show(Expense $expense) {
        $this->authorize('view', $expense);
        return $this->successResponse(new ExpenseResource($expense), '', 200);
    }

    public function store(StoreExpenseRequest $request) {
        try {
            $input = $request->validated();
            $expense = $this->expenseService->store(
                StoreExpenseDTO::fromRequest($input),
            );
            return $this->successResponse(new ExpenseResource($expense), 'Expense created successfully!', 201);
        } catch (Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 500);
        }
    }

    public function update(Expense $expense, UpdateExpenseRequest $request) {
        try {
            $this->authorize("update", $expense);
            $input = $request->validated();
            $expense = $this->expenseService->update($expense, UpdateExpenseDTO::fromRequest($input));
            return $this->successResponse(new ExpenseResource($expense), 'Expense updated successfully!', 200);
        } catch (AuthorizationException $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 403);
        } catch (Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 500);
        }
    }

    public function destroy(Expense $expense) {
        try {
            $this->authorize("delete", $expense);
            $this->expenseService->destroy($expense);
            return response()->json(null, 204);
        } catch(Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}", 500);
        }
    }
}