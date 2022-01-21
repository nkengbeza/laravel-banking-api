<?php

namespace App\Http\Controllers;

use App\Contracts\ITransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


/**
 * @group Bank Account Transactions
 * @authenticated
 *
 * The API to perform simple bank transactions.
 */
class BankTransactionController extends Controller
{

    private ITransactionService $transactionService;

    /**
     * @param ITransactionService $transactionService
     */
    public function __construct(ITransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function transfer(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required|exists:bank_accounts,account_number',
            'to' => 'required|exists:bank_accounts,account_number',
            'amount' => 'numeric|required|min:0',
            'charges' => 'numeric|min:0',
            'comments' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $validator = $validator->validated();
            return response()->json(
                $this->transactionService
                    ->transfer($validator['from'], $validator['to'], $validator['amount'], $validator['charges'], $validator['comments']), 200);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function deposit(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required|exists:bank_accounts,account_number',
            'amount' => 'numeric|required|min:0',
            'charges' => 'numeric|min:0',
            'comments' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $validator = $validator->validated();
            return response()->json($this->transactionService
                    ->deposit($validator['account_number'], $validator['amount'], $validator['charges'], $validator['comments']), 200);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function withdraw(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required|exists:bank_accounts,account_number',
            'amount' => 'numeric|required|min:0',
            'charges' => 'numeric|min:0',
            'comments' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $validator = $validator->validated();
            return response()->json($this->transactionService
                    ->withdraw($validator['account_number'], $validator['amount'], $validator['charges'], $validator['comments']), 200);
        }
    }
}
