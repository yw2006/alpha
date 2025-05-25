<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorResponsibleInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $vendors = Vendor::with('responsibleInfos')->get();
            return response()->json([
                'status' => 'success',
                'data' => $vendors
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get vendors',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'arName' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'arIndustry' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            "status"=>"nullable|boolean",
            'responsibleInfos' => 'sometimes|array',
            'responsibleInfos.*.name' => 'required|string|max:255',
            'responsibleInfos.*.arName' => 'required|string|max:255',
            'responsibleInfos.*.mobile' => 'nullable|string|max:255',
            'responsibleInfos.*.whatsapp_mobile' => 'nullable|string|max:255',
            'responsibleInfos.*.title' => 'nullable|string|max:255',
            'responsibleInfos.*.arTitle' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $vendor = Vendor::create($request->only([
                'name',
                'arName',
                'industry',
                'arIndustry',
                'phone',
                'address',
                "status"
            ]));

            if ($request->has('responsibleInfos')) {
                foreach ($request->responsibleInfos as $info) {
                    $vendor->responsibleInfos()->create($info);
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'data' => $vendor->load('responsibleInfos')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store vendor',
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
            $vendor = Vendor::with('responsibleInfos')->findOrFail($id);
            return response()->json([
                'status' => 'success',
                'data' => $vendor
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vendor not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve vendor',
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
            'name' => 'sometimes|required|string|max:255',
            'arName' => 'sometimes|required|string|max:255',
            'industry' => 'sometimes|nullable|string|max:255',
            'arIndustry' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:255',
            'address' => 'sometimes|nullable|string',
            "status"=>"nullable|boolean",
            'responsibleInfos' => 'sometimes|array',
            'responsibleInfos.*.id' => 'sometimes|exists:vendor_responsible_infos,id',
            'responsibleInfos.*.name' => 'required|string|max:255',
            'responsibleInfos.*.arName' => 'required|string|max:255',
            'responsibleInfos.*.mobile' => 'nullable|string|max:255',
            'responsibleInfos.*.whatsapp_mobile' => 'nullable|string|max:255',
            'responsibleInfos.*.title' => 'nullable|string|max:255',
            'responsibleInfos.*.arTitle' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $vendor = Vendor::findOrFail($id);
            $vendor->update($request->only([
                'name',
                'arName',
                'industry',
                'arIndustry',
                'phone',
                'address',
                "status"
            ]));

            if ($request->has('responsibleInfos')) {
                $info = $request->responsibleInfos;
                
                VendorResponsibleInfo::updateOrCreate(
                    ['vendor_id' => $vendor->id],
                    $info[0]
                );
            }
            DB::commit();

            return response()->json([
                'status' => 'success',
                'data' => $vendor->load('responsibleInfos')
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vendor or responsible info not found'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update vendor',
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
            $vendor = Vendor::findOrFail($id);
            $vendor->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Vendor deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vendor not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete vendor',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}