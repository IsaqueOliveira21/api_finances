<?php

namespace App\Http\Controllers\Finance\Transaction;

use App\Domain\Finance\Transaction\DTOs\IndexTransactionDTO;
use App\Domain\Finance\Transaction\DTOs\StoreTransactionDTO;
use App\Domain\Finance\Transaction\Services\TransactionService;
use App\Domain\Finance\Transaction\Services\WalletService;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexTransactionRequest;
use App\Http\Requests\Finance\Transaction\StoreTransactionRequest;
use App\Http\Resources\Finance\Transaction\TransactionResource;
use App\Traits\Api\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use ApiResponse;

    public function __construct(
        private TransactionService $transactionService,
        private WalletService $walletService,
    ) {}

    public function index(IndexTransactionRequest $request) {
        try {
            $filters = $request->validated();
            $transactions = $this->transactionService->index(
                IndexTransactionDTO::fromRequest($filters),
            );
            return $this->successResponse(TransactionResource::collection($transactions), "", 200);
        } catch (Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}");
        }
    }

    public function store(StoreTransactionRequest $request) {
        try {
            $input = $request->validated();
            $transaction = $this->transactionService->store(
                StoreTransactionDTO::fromRequest($input),
            );
            return $this->successResponse(new TransactionResource($transaction), "Transaction created successfully!", 201);
        } catch (Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}");
        }
    }

    public function getUserWalletBalance() {
        try {
            $balance = $this->walletService->getUserWalletBalance();
            return $this->successResponse($balance, "", 200);
        } catch (Exception $e) {
            return $this->errorResponse("{$e->getLine()}: {$e->getMessage()}");
        }
    }
}
