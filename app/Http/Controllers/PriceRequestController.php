<?php

namespace App\Http\Controllers;

use App\Models\PriceRequest;
use Illuminate\Http\Request;

class PriceRequestController extends Controller
{
    // List all price requests
    public function index()
    {
        $priceRequests = PriceRequest::with(['company', 'creator'])->latest()->get();
        return response()->json($priceRequests);
    }

    // Store a new price request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_notes' => 'nullable|string',
            'company_id' => 'required|exists:companies,id',
            'created_by' => 'required|exists:users,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'in:pending,approved,rejected',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('price_requests', 'public');
        }

        $priceRequest = PriceRequest::create($validated);

        return response()->json($priceRequest, 201);
    }

    // Show a specific price request
    public function show($id)
    {
        $priceRequest = PriceRequest::with(['company', 'creator'])->findOrFail($id);
        return response()->json($priceRequest);
    }

    // Update a price request
    public function update(Request $request, $id)
    {
        $priceRequest = PriceRequest::findOrFail($id);

        $validated = $request->validate([
            'customer_notes' => 'nullable|string',
            'company_id' => 'sometimes|exists:companies,id',
            'created_by' => 'sometimes|exists:users,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'in:pending,approved,rejected',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('price_requests', 'public');
        }

        $priceRequest->update($validated);

        return response()->json($priceRequest);
    }

    // Delete a price request (soft delete)
    public function destroy($id)
    {
        $priceRequest = PriceRequest::findOrFail($id);
        $priceRequest->delete();

        return response()->json(['message' => 'Deleted successfully.']);
    }
}
