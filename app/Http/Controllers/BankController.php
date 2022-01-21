<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankBranchCollection;
use App\Http\Resources\BankCollection;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use App\Models\BankBranch;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @group Bank Account Management
 * @authenticated
 *
 * The API to perform simple bank transactions.
 */
class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return BankCollection
     */
    public function index(): BankCollection
    {
        return new BankCollection(Bank::paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BankResource
     */
    public function show(int $id): BankResource
    {
        return new BankResource(Bank::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return BankResource|JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse|BankResource
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:128',
            'code' => 'required|max:16'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $bank = Bank::findOrFail($id);
            $validated = $validator->validated();
            $bank->name = $validated['name'];
            $bank->code = $validated['code'];
            $bank->updated_at = Carbon::now();
            $bank->save();
            return new BankResource($bank);
        }
    }

    /**
     * @param int $id
     * @return BankBranchCollection
     */
    public function bankBranches(int $id): BankBranchCollection
    {
        return new BankBranchCollection(BankBranch::where(['bank_id', '=', $id])->paginate());
    }

}
