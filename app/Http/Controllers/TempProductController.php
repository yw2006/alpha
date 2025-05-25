<?php

namespace App\Http\Controllers;

use App\Models\TempProduct;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class TempProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = TempProduct::get();
            return response()->json([
                'status' => 'success',
                'data' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get products',
                'details' => config('app.debug') ? $e->getMessage() : null
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:your_table,email',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|boolean',
            'image' => 'nullable|file|mimes:jpeg,png,jpg',
            'related_model_id' => 'required|exists:related_models,id',
            
            // Nested (dot notation)
            'info.name' => 'nullable|string|max:255',
            'info.title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Example: Handle optional file uploads
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        }

        // Use $validated to create or update a model
        $product = TempProduct::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Resource created successfully',
            'data' => $$product 
        ], 201);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong',
            'details' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = TempProduct::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $product
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve product',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'stock' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0'
        ]);

        try {
            $product = TempProduct::findOrFail($id);
            $product->update($request->only(['title', 'stock', 'description', 'price']));
            return response()->json([
                'status' => 'success',
                'data' => $product
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update product',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = TempProduct::findOrFail($id);
            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete product',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
