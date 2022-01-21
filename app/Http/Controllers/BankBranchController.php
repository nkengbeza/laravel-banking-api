<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankBranchCollection;
use App\Http\Resources\BankBranchResource;
use App\Models\BankBranch;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


/**
 * @group Transaction History
 * @authenticated
 *
 * The API displays bank transactions.
 */
class BankBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): BankBranchCollection
    {
        return new BankBranchCollection(BankBranch::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return BankBranchResource|JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse|BankBranchResource
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:0|max:128',
            'address_line_1' => 'required|min:0|max:64',
            'address_line_2' => 'required|min:0|max:64',
            'state' => 'nullable|min:3|max:3',
            'country' => 'nullable|min:3|max:3',
            'bank' => 'required|exists:App\Models\Bank,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $validated = $validator->validated();
            $branch = new BankBranch();
            $branch->name = $validated['name'];
            $branch->address_line_1 = $validated['address_line_1'];
            $branch->address_line_2 = $validated['address_line_2'];
            $branch->state = $validated['state'];
            $branch->country = $validated['country'];
            $branch->bank_id = $validated['bank'];
            $branch->created_at = Carbon::now();
            $branch->updated_at = Carbon::now();
            $branch->save();
            return new BankBranchResource($branch);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BankBranchResource
     */
    public function show(int $id): BankBranchResource
    {
        return new BankBranchResource(BankBranch::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return BankBranchResource|JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse|BankBranchResource
    {
        $branch = BankBranch::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:0|max:128',
            'address_line_1' => 'required|min:0|max:64',
            'address_line_2' => 'required|min:0|max:64',
            'state' => 'nullable|min:3|max:3',
            'country' => 'nullable|min:3|max:3',
            'bank' => 'required|exists:App\Models\BankBranch,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            $validated = $validator->validated();

            $branch->name = $validated['name'];
            $branch->address_line_1 = $validated['address_line_1'];
            $branch->address_line_2 = $validated['address_line_2'];
            $branch->state = $validated['state'];
            $branch->country = $validated['country'];
            $branch->updated_at = Carbon::now();
            $branch->save();
            return new BankBranchResource($branch);
        }
    }

}
