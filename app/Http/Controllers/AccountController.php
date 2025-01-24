<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Account;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request) : \Illuminate\Http\JsonResponse
    {
        $account = Account::query() -> where('email', $request->email)->first();

        if (!$account || !Hash::check($request->password, $account->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        $account->save();
        $token = $account->createToken('token')->plainTextToken;

        return $this->successResponse(['account' => $account, 'token' => $token], 'Logged in successfully');
    }

    public function register(LoginRequest $request) : \Illuminate\Http\JsonResponse
    {
        $account = Account::query() -> where('email', $request->email)->first();

        if ($account) {
            return $this->errorResponse('Email already exists', 401);
        }

        $account = Account::create($request->all());
        $token = $account->createToken('token')->plainTextToken;

        return $this->successResponse(['account' => $account, 'token' => $token], 'Registered successfully');
    }

    public function logout() : \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse([], 'Logged out successfully');
    }

    public function destroy() : \Illuminate\Http\JsonResponse
    {
        auth()->user()->delete();

        return $this->successResponse([], 'Account deleted successfully');
    }
}
