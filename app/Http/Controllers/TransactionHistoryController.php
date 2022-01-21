<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionHistoryCollection;
use App\Http\Resources\TransactionHistoryResource;
use App\Models\TransactionHistory;

/**
 * @group Transaction History
 * @authenticated
 *
 * The API displays bank transactions.
 */
class TransactionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TransactionHistoryCollection
     */
    public function index(): TransactionHistoryCollection
    {
        return new TransactionHistoryCollection(TransactionHistory::paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TransactionHistoryResource
     */
    public function show(int $id): TransactionHistoryResource
    {
        return new TransactionHistoryResource(TransactionHistory::findOrFail($id));
    }

}
