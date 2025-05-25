<?php

namespace App\Http\Controllers;

use App\Models\PriceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PriceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $priceRequests = PriceRequest::all();

            return response()->json([
                'status' => 'successfull',
                'data' => $priceRequests
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
                'customer_notes' => 'nullable|string',
                'company_id' => 'required|exists:companies,id',
                'created_by' => 'required|exists:users,id',
                'image' => 'nullable|image|max:2048',
                'status' => 'nullable|in:pending,approved,rejected'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('price_requests', 'public');
            }

            $priceRequest = PriceRequest::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Price request created successfully',
                'data' => $priceRequest
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
            $priceRequest = PriceRequest::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $priceRequest
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Price request not found'
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
            $priceRequest = PriceRequest::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'customer_notes' => 'nullable|string',
                'company_id' => 'sometimes|exists:companies,id',
                'created_by' => 'sometimes|exists:users,id',
                'image' => 'nullable|image|max:2048',
                'status' => 'nullable|in:pending,approved,rejected'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('price_requests', 'public');
            }

            $priceRequest->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Price request updated successfully',
                'data' => $priceRequest
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Price request not found'
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
            $priceRequest = PriceRequest::findOrFail($id);
            $priceRequest->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Price request deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Price request not found'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
