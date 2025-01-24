<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountInfoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class AccountInformationController extends Controller
{
    use ApiResponse;

    public function index() : JsonResponse
    {
        $account_information = auth()->user()->AccountInformation()->get();

        if ($account_information->count() === 0) {
            return $this->errorResponse('Account information does not exist', 401);
        }

        return $this->successResponse($account_information);
    }

    public function update(Request $request) : JsonResponse
    {
        $account_information_object = auth()->user()->AccountInformation();

        if ($account_information_object->count() === 0) {
            return $this->errorResponse('Account information does not exist', 401);
        }

        $updated_account_information = $account_information_object->update($request->all());

        return $this->successResponse($updated_account_information);
    }

    public function store(AccountInfoRequest $request) : JsonResponse
    {
        $account_information_object = auth()->user()->AccountInformation();

        if ($account_information_object->count() > 0) {
            return $this->errorResponse('Account information already exists', 401);
        }

        $account_information = $account_information_object->create($request->all());

        return $this->successResponse($account_information);
    }
}
