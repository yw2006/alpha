<?php

namespace App\Http\Controllers;

use App\Models\PaymentTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentTermController extends Controller
{
    /**
     * Display a listing of the payment terms.
     */
    public function index(Request $request)
    {
        try {
            $isMobile = $request->query('platform') === 'mobile';
            if ($isMobile){
                $paymentTerms = PaymentTerm::where("status",1)->get();
            }else{
                $paymentTerms = PaymentTerm::all();
            }
            return response()->json([
                'status' => 'success',
                'data' => $paymentTerms
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created payment term.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:payment_terms,name',
                'arName' => 'required|string|max:255|unique:payment_terms,arName',
                'kind' => 'required|string|max:255',
                'arKind' => 'required|string|max:255',
                'period' => 'required|string',
                'arPeriod' => 'required|string',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $paymentTerm = PaymentTerm::create($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Payment term created successfully',
                'data' => $paymentTerm
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified payment term.
     */
    public function show(string $id)
    {
        try {
            $paymentTerm = PaymentTerm::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => $paymentTerm
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment term not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified payment term.
     */
    public function update(Request $request, string $id)
    {
        try {
            $paymentTerm = PaymentTerm::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:payment_terms,name',
                'arName' => 'required|string|max:255|unique:payment_terms,arName',
                'kind' => 'required|string|max:255',
                'arKind' => 'required|string|max:255',
                'period' => 'required|string',
                'arPeriod' => 'required|string',
                'status' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $paymentTerm->update($validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Payment term updated successfully',
                'data' => $paymentTerm
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment term not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified payment term.
     */
    public function destroy(string $id)
    {
        try {
            $paymentTerm = PaymentTerm::findOrFail($id);
            $paymentTerm->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Payment term deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment term not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
