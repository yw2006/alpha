<?php

namespace App\Http\Controllers;

use App\Models\CompanyFeedback;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Exception;

class CompanyFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $company_id = $request->query("company", null);
            
            if ($company_id !== null) {
                $feedback = CompanyFeedback::where("company_id", $company_id)->get();
            }else{
                return response()->json(['message' => 'company is required'], 400);
            }
            
            return response()->json([
                'status' => 'success',
                'data' => isset($feedback) ? $feedback :null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_id' => 'required|exists:companies,id',
                'note' => 'nullable|string|max:1000',
                'created_by' => 'required|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $feedback = CompanyFeedback::create($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback created successfully',
                'data' => $feedback
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $feedback = CompanyFeedback::find($id);
            
            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $feedback
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $feedback = CompanyFeedback::find($id);
            
            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'note' => 'sometimes|nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $feedback->update($request->only(['note']));

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback updated successfully',
                'data' => $feedback
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $feedback = CompanyFeedback::find($id);
            
            if (!$feedback) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Feedback not found'
                ], 404);
            }

            $feedback->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Feedback deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete feedback',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}