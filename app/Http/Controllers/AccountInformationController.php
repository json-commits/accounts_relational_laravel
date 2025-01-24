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

        return $this->successResponse($account_information);
    }

    public function update(Request $request) : JsonResponse
    {
        $account_information = auth()->user()->AccountInformation()->update($request->all());

        return $this->successResponse($account_information);
    }

    public function store(AccountInfoRequest $request) : JsonResponse
    {
        $account_information = auth()->user()->AccountInformation()->create($request->all());

        return $this->successResponse($account_information);
    }
}
