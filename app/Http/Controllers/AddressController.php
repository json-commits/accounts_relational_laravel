<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressIDRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class AddressController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $address_list = auth()->user()->address()->get();

        return $this->successResponse($address_list);
    }

    /**
     * Store a newly created resource in storage.
     */
    // TODO: Add validation for the request for duplicate address
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user_address_object = auth()->user()->address();

        if ($request->default) {
            $user_address_object->where('default', 1)->update(['default' => 0]);
        }

        $new_address = auth()->user()->address()->create($request->all());

        return $this->successResponse($new_address);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        $address = auth()->user()->address()->find($request->id);

        if (!$address) {
            return $this->errorResponse('Address not found', 404);
        }

        return $this->successResponse($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressIDRequest $request): \Illuminate\Http\JsonResponse
    {
        $address_object = auth()->user()->address()->find($request->id);

        if (!$address_object) {
            return $this->errorResponse('Address not found', 404);
        }

        if ($request->default) {
            auth()->user()->address()->where('default', 1)->update(['default' => 0]);
        }

        $address_object->update($request->all());

        return $this->successResponse($address_object);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AddressIDRequest $request): \Illuminate\Http\JsonResponse
    {
        $address = auth()->user()->address()->find($request->id);

        if (!$address) {
            return $this->errorResponse('Address not found', 404);
        }

        $address->delete();

        return $this->successResponse($address);
    }
}
