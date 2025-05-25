<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyResponsibleInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $created_by=$request->query("created_by",null);
            if($created_by != null){
                $companies = Company::where('created_by', $created_by)->where("status",1)
                ->withCount('order')
                ->get(["id","location","name","address"]);
            }else {
                $companies = Company::with(['city', 'discount_type'])
     ->withCount('order')
     ->get()
     ->map(function ($company) {
        $data = $company->toArray();
        unset($data['city'], $data['discount_type'],$data['city_id'],$data["discount_type_id"],$data['deleted_at']); // remove relationship data
        $data['city_name'] = $company->city?->name;
        $data['discount_type_name'] = $company->discount_type?->name;
        return $data;
     });

            }
            return response()->json([
                'status' => 'success',
                'data' => $companies
            ], 200);
        } catch (\Exception $e) {
            Log::error('Companies fetch failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => "Failed to get companies",
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
                "arName"=>"required|string|max:255",
                'email' => 'required|email|unique:companies,email',
                'address' => 'nullable|string',
                "arAddress"=>'nullable|string',
                'phone' => 'nullable|string|max:20',
                'location' => 'nullable|string',
                'industry' => 'nullable',
                "arIndustry"=>"nullable",
                "status"=>"nullable|boolean",
                'payment_terms' => 'nullable|string',
                'commercial_registration_number' => 'nullable|string',
                'commercial_registration_image' => 'nullable|file|mimes:jpeg,png,pdf',
                'tax_id' => 'nullable|string',
                'tax_image' => 'nullable|file|mimes:jpeg,png,pdf',
                'image' => 'nullable|file|mimes:jpeg,png,jpg',
                'city_id' => 'required|exists:cities,id',
                'discount_type_id' => 'nullable|exists:discount_types,id',
                'created_by' => 'required|exists:users,id',
                // Responsible info (will be handled separately)
                'responsible_info.name' => 'nullable|string|max:255',
                'responsible_info.arName' => 'nullable|string|max:255',
                'responsible_info.mobile' => 'nullable|string|max:20',
                'responsible_info.title' => 'nullable|string|max:255',
                'responsible_info.arTitle' => 'nullable|string|max:255',
                'responsible_info.whatsapp_mobile' => 'nullable|string|max:20',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $validated = $validator->validated();
            // Separate responsible info from company data
            $responsibleInfo = $validated['responsible_info'] ?? [];
            unset($validated['responsible_info']);
    
            // Handle file uploads
            if ($request->hasFile('commercial_registration_image')) {
                $validated['commercial_registration_image'] = $request->file('commercial_registration_image')->store('companies', 'public');
            }
    
            if ($request->hasFile('tax_image')) {
                $validated['tax_image'] = $request->file('tax_image')->store('companies', 'public');
            }
    
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('companies', 'public');
            }
    
            DB::beginTransaction();
    
            // Create the company
            $company = Company::create($validated);
    
            // Create responsible info if provided
            if (!empty($responsibleInfo)) {
                $responsibleInfo['company_id'] = $company->id;
                CompanyResponsibleInfo::create($responsibleInfo);
            }
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Company created successfully',
                'data' => $company->load('company_responsible_info')
            ], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Company creation failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create company',
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
            $company = Company::with([
                'feedback',
                'company_responsible_info',
                'city:id,name',      // Only select needed fields from city
                'discount_type:id,name,value', // Only select needed fields from discount_type
                "payment_term"
            ])
            ->select([
                'id', 
                'name', 
                "arName",
                'email', 
                'address', 
                "arAddress",
                'phone', 
                'location', 
                'industry',
                "arIndustry",
                'commercial_registration_number',
                'commercial_registration_image',
                'tax_id',
                'tax_image',
                "status",
                'image',
                'city_id',
                'discount_type_id',
                'created_by',
                'created_at',
                'updated_at'
            ])
            ->findOrFail($id);
            
            // Create a new array with the exact structure you want
            $company = $company->toArray();
            return response()->json([
                'status' => 'success',
                'data' => $company
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company not found'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Company fetch failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => "Failed to get company",
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'arName' => 'nullable|string|max:255',
                'email' => "nullable|email|unique:companies,email,$id",
                'address' => 'nullable|string',
                'arAddress' => 'nullable|string',
                'phone' => 'nullable|string|max:20',
                'location' => 'nullable|string',
                'industry' => 'nullable',
                "arIndustry"=>"nullable",
                "status"=>"nullable|boolean",
                'payment_term_id' => 'nullable|exists:payment_terms,id',
                'commercial_registration_number' => 'nullable|string',
                'commercial_registration_image' => 'nullable|file|mimes:jpeg,png,pdf',
                'tax_id' => 'nullable|string',
                'tax_image' => 'nullable|file|mimes:jpeg,png,pdf',
                'image' => 'nullable|file|mimes:jpeg,png,jpg',
                'city_id' => 'nullable|exists:cities,id',
                'discount_type_id' => 'nullable|exists:discount_types,id',
                'created_by' => 'nullable|exists:users,id',
    
                // Responsible info
                'responsible_info.name' => 'nullable|string|max:255',
                'responsible_info.arName' => 'nullable|string|max:255',
                'responsible_info.mobile' => 'nullable|string|max:20',
                'responsible_info.title' => 'nullable|string|max:255',
                'responsible_info.arTitle' => 'nullable|string|max:255',
                'responsible_info.whatsapp_mobile' => 'nullable|string|max:20',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $validated = $validator->validated();
            $responsibleInfo = $validated['responsible_info'] ?? [];
            unset($validated['responsible_info']);
    
            // Fetch company
            $company = Company::findOrFail($id);
    
           // Compare and store only if file content is different
           if ($request->hasFile('commercial_registration_image')) {
            if ($company->commercial_registration_image && Storage::disk('public')->exists($company->commercial_registration_image)) {
                Storage::disk('public')->delete($company->commercial_registration_image);
            }
        
            $validated['commercial_registration_image'] = $request->file('commercial_registration_image')->store('companies', 'public');
        }
        
           if ($request->hasFile('tax_image')) {
            if ($company->tax_image && Storage::disk('public')->exists($company->tax_image)) {
                Storage::disk('public')->delete($company->tax_image);
            }
        
            $validated['tax_image'] = $request->file('tax_image')->store('companies', 'public');
        }
        
        if ($request->hasFile('image')) {
            if ($company->image && Storage::disk('public')->exists($company->image)) {
                Storage::disk('public')->delete($company->image);
            }
        
            $validated['image'] = $request->file('image')->store('companies', 'public');
        }
            DB::beginTransaction();
    
            // Update company
            $company->update($validated);
    
            // Update or create responsible info
            if (!empty($responsibleInfo)) {
                CompanyResponsibleInfo::updateOrCreate(
                    ['company_id' => $company->id],
                    $responsibleInfo
                );
            }
    
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Company updated successfully',
                'data' => $company->load('company_responsible_info')
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Company update failed: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update company',
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
            $company = Company::findOrFail($id);
    
            // Delete the company
            $company->delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Company deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Company not found'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}