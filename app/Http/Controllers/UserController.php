<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;


/**
 * @group User management
 *
 * The API to perform simple user management.
 */
class UserController extends Controller
{

    /**
     * @param Request $request
     * @return UserResource
     */
    public function findRandomUser(Request $request): UserResource
    {
        return new UserResource(User::all()->firstOrFail());
    }

    /**
     * @authenticated
     * @param int $id
     * @return JsonResponse
     */
    public function userToken(int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $token = $user->createToken(Str::uuid()->toString());
        return response()->json(['token' => $token->plainTextToken], 200);
    }

    /**
     * @authenticated
     * @param Request $request
     * @param int $id
     * @return UserResource
     */
    public function me(Request $request, int $id): UserResource
    {
        return new UserResource($request->user());
    }

}
