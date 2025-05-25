<?php

namespace App\Http\Controllers;

use App\Models\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiscountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $discountTypes = DiscountType::get();

            return response()->json([
                'status' => 'success',
                'data' => $discountTypes
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:discount_types,name',
                'arName' => 'required|string|max:255|unique:discount_types,name',
                "value"=>"required|numeric",
                "status"=>"nullable|boolean"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $discountType = DiscountType::create($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Discount type created successfully',
                'data' => $discountType
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $discountType = DiscountType::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $discountType
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Discount type not found'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $discountType = DiscountType::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255|unique:discount_types',
                'arName' => 'nullable|string|max:255|unique:discount_types,name',
                "value"=> "nullable|numeric",
                "status"=>"nullable|boolean"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $discountType->update($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Discount type updated successfully',
                'data' => $discountType
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Discount type not found'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $discountType = DiscountType::findOrFail($id);
            $discountType->delete(); // Soft delete if enabled

            return response()->json([
                'status' => 'success',
                'message' => 'Discount type deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Discount type not found'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}