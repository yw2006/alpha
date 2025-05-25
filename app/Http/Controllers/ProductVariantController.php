<?php

namespace App\Http\Controllers;

use App\Models\productVariant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "status"=>"required|boolean"
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }
            $product = productVariant::findOrFail($id);
            $product->update($validator->validate());
            return response()->json([
                'status' => true,
                "message"=>"product variant status updated successfully"
            ], 200);
        } catch  (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'product variant not found'
            ], 404);
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update product variant.'.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
        try {
            $productVariant = productVariant::findOrFail($id);
            $productVariant->delete();
            return response()->json([
                'status' => true,
                "message"=>"product variant deleted successfully"
            ], 200);
        } 
        catch  (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'product variant not found'
            ], 404);
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete product variant.'.$e->getMessage(),
                
            ], 500);
        }
    }
    
}
