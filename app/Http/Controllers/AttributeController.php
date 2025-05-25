<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    // Get all attributes
    public function index()
    {
        try {
        $attributes = Attribute::with("values")->get();
        return response()->json([
            'status' => 'success',
            'data' => $attributes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to get attributes",
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Create a new attribute
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'arName' => 'required|string|max:255',
            "status"=>"nullable|boolean"
        ]);

        try{
            $attribute = Attribute::create($request->only(['name', 'arName',"status"]));
        return response()->json([
            'status' => 'success',
            'data' => $attribute
            ],201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to store attribute",
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Get a single attribute
    public function show($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $attribute
                ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'attribute not found'
            ], 404);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to store attribute",
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
       
    }

    // Update an attribute
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'arName' => 'sometimes|required|string|max:255',
            "status"=>"nullable|boolean"
        ]);
        try{
            $attribute = Attribute::findOrFail($id);
            if ($attribute)
            $attribute->update($request->only(['name', 'arName',"status"]));

            return response()->json([
            'status' => 'success',
            'data' => $attribute
            ],201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'attribute not found'
            ], 404);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to store attribute",
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Delete an attribute (soft delete)
    public function destroy($id)
    {
        try {
            $attribute = Attribute::findOrFail($id);
            $attribute->delete();
            return response()->json(['message' => 'Attribute deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'attribute not found'
            ], 404);
        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to store attribute",
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
       
    }
}
