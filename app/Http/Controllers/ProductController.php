<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\productVariant;
use Database\Factories\ProductVariantFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $isMobile = $request->query('platform') === 'mobile';
            
            $query = Product::with('category:id,name,arName')
                ->select([
                    'products.id',
                    'products.title',
                    'products.arTitle',
                    'products.status',
                    'products.base_price',
                    'products.base_stock',
                ]);
            
            // For mobile, only show active products
            if ($isMobile) {
                $query->where('status', 1);
            }
            // For web, show all products (active and inactive)
            
            $products = $query->get();
            
            return response()->json([
                'status' => true,
                'data' => $products,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch products.' . $e->getMessage(),
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
        'title' => 'required|string|max:255',
        'arTitle' => 'required|string|max:255',
        'base_price' => 'nullable|numeric|min:0',
        'discount_price' => 'nullable|integer|min:0',
        'base_stock' => 'nullable|integer|min:0',
        'description' => 'nullable|string',
        'arDescription' => 'nullable|string',
        'status' => 'nullable|boolean',
        'image' => 'nullable|file|mimes:jpeg,png,jpg',
        "category_id"=>"exists:categories,id",
        "vendor_id"=>"exists:vendors,id",
        'variant' => 'sometimes|array',
        'variant.*.price' => 'nullable|numeric|min:0',
        'variant.*.stock' => 'nullable|numeric|min:0',
        'variant.*.image' => 'nullable|file|mimes:jpeg,png,jpg',
        'variant.*.status' => 'nullable|boolean',
        'variant.*.attribute_value_ids' => 'nullable|array',
        'variant.*.attribute_value_ids.*' => 'exists:attribute_values,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    $validated = $validator->validated();
    $variantsData = $validated['variant'] ?? [];
    unset($validated['variant']);

    DB::beginTransaction();

    // Handle image upload if needed
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    $product = Product::create($validated);
    $product->category()->attach($validated["category_id"]);
    $product->vendors()->attach($validated["vendor_id"]);
    // Create variants
    foreach ($variantsData as $variant) {
        if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
            $variant['image'] = $variant['image']->store('variants', 'public');
        }

        
    // Extract and remove attribute values from the data
    $attributeValueIds = $variant['attribute_value_ids'] ?? [];
    unset($variant['attribute_value_ids']);

    // Create variant
    $createdVariant = $product->variants()->create($variant);

    // Attach attribute values
    if (!empty($attributeValueIds)) {
        $createdVariant->attributeValues()->sync($attributeValueIds);
    }
        

    }

    DB::commit();

    return response()->json([
        'status' => true,
        'message' => 'Product created successfully.',
        // 'data' => $product->load(['variants',"category","vendors"]), // optional: include variants in response
    ], 201);
} catch (\Exception $e) {
    DB::rollBack();
    Log::error('Error creating product: ' . $e->getMessage());
    return response()->json([
        'status' => false,
        'message' => 'Failed to create product.'.$e->getMessage(),
    ], 500);
}

    }
    public function update(Request $request,string $id )
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'arTitle' => 'required|string|max:255',
                'base_price' => 'nullable|numeric|min:0',
                'base_price' => 'nullable|numeric|min:0',
                'discount_price' => 'nullable|integer|min:0',
                'description' => 'nullable|string',
                'arDescription' => 'nullable|string',
                'status' => 'nullable|boolean',
                'image' => 'nullable|file|mimes:jpeg,png,jpg',
                'category_id' => 'required|exists:categories,id',
                'vendor_id' => 'required|exists:vendors,id',
                'variant' => 'sometimes|array',
                'variant.*.id' => 'nullable|exists:product_variants,id', // for identifying existing variants
                'variant.*.price' => 'nullable|numeric|min:0',
                'variant.*.stock' => 'nullable|numeric|min:0',
                'variant.*.image' => 'nullable|file|mimes:jpeg,png,jpg',
                'variant.*.status' => 'nullable|boolean',
                'variant.*.attribute_value_ids' => 'nullable|array',
                'variant.*.attribute_value_ids.*' => 'exists:attribute_values,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $product = Product::findOrFail($id);
            $validated = $validator->validated();
            $variantsData = $validated['variant'] ?? [];
            unset($validated['variant']);
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
            
                // Store new image
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            DB::beginTransaction();
    
    
            $product->update($validated);

            // Sync many-to-many
            $product->category()->sync([$validated['category_id']]);
            $product->vendors()->sync([$validated['vendor_id']]);
    
            // Handle variants
            $existingVariantIds = [];
    
            foreach ($variantsData as $variant) {
                $attributeValueIds = $variant['attribute_value_ids'] ?? [];
                unset($variant['attribute_value_ids']);
    
                
                if (isset($variant['image']) && $variant['image'] instanceof \Illuminate\Http\UploadedFile) {
                    // If it's an update, delete the old image
                    if (isset($variant['id'])) {
                        $existing = $product->variants()->where('product_variants.id', $variant['id'])->first();
                        if ($existing && $existing->image && Storage::disk('public')->exists($existing->image)) {
                            Storage::disk('public')->delete($existing->image);
                        }
                    }
                
                    // Store new image
                    $variant['image'] = $variant['image']->store('variants', 'public');
                }
                
                if (isset($variant['id'])) {
                    // Update existing variant
                    $existing = $product->variants()->where('product_variants.id', $variant['id'])->first();
                    if ($existing) {
                        $existing->update($variant);
                        $existing->attributeValues()->sync($attributeValueIds);
                        $existingVariantIds[] = $existing->id;
                    }
                } else {
                    // Create new variant
                    $createdVariant = $product->variants()->create($variant);
                    $createdVariant->attributeValues()->sync($attributeValueIds);
                    $existingVariantIds[] = $createdVariant->id;
                }
            }
            // Optionally delete removed variants
            $product->variants()->whereNotIn('product_variants.id', $existingVariantIds)->delete();
            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully.',
                'data' => $product->load(['variants', 'category:id,name,arName', 'vendors:id,name,arName']),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to update product. ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            $isMobile = $request->query('platform') === 'mobile';
    
            $query = Product::with([
                'variants' => function ($variantQuery) use ($isMobile) {
                    if ($isMobile) {
                        $variantQuery->where('status', 1);
                    }
                },
                'variants.attributeValues.attribute:id,name,arName'
            ]);
    
            if ($isMobile) {
                $query->where('status', 1);
            }
    
            $product = $query->findOrFail($id);
    
            return response()->json([
                'status' => true,
                'data' => $product,
            ], 200);
        } 
        catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'product not found'
            ], 404);
        } catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch product.' . $e->getMessage(),
            ], 500);
        }
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
            $product = Product::findOrFail($id);
            $product->update($validator->validate());
            return response()->json([
                'status' => true,
                "message"=>"product status updated successfully"
            ], 200);
        } catch  (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'product not found'
            ], 404);
        }catch(\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update product.'.$e->getMessage()
            ], 500);
        }


    }

    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            DB::beginTransaction();
            $product->variants()->delete();
            $product->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                "message"=>"product deleted successfully"
            ], 200);
        } 
        catch  (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'product not found'
            ], 404);
        }catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete product.'.$e->getMessage(),
                
            ], 500);
        }
    }
}
