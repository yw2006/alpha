<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use Attribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    // Get all attribute values
    public function index(Request $request)
    {
        try {
            $attribute = $request->query("attribute",null);
            if($attribute==null){
                $attributeValues = AttributeValue::all();
            }
            else{
                $attributeValues = AttributeValue::where("attribute_id",$attribute)->get();
            }
            return response()->json([
                'status' => 'success',
                'data' => $attributeValues
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get attribute values',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Create a new attribute value
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'arName' => 'required|string|max:255',
            'attribute_id' => 'required|exists:attributes,id'
        ]);

        try {
            $attributeValue = AttributeValue::create($request->only(['name', 'arName', 'attribute_id']));
            return response()->json([
                'status' => 'success',
                'data' => $attributeValue
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store attribute value',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Get a single attribute value
    public function show($id)
    {
        try {
            $attributeValue = AttributeValue::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $attributeValue
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Attribute value not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve attribute value',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Update an attribute value
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'arName' => 'sometimes|required|string|max:255',
            'attribute_id' => 'sometimes|required|exists:attributes,id'
        ]);

        try {
            $attributeValue = AttributeValue::findOrFail($id);
            $attributeValue->update($request->only(['name', 'arName', 'attribute_id']));
            return response()->json([
                'status' => 'success',
                'data' => $attributeValue
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Attribute value not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update attribute value',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Delete an attribute value (soft delete)
    public function destroy($id)
    {
        try {
            $attributeValue = AttributeValue::findOrFail($id);
            $attributeValue->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Attribute value deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Attribute value not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete attribute value',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}