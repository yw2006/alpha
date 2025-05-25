<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyFeedbackController;
use App\Http\Controllers\DiscountTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentTermController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\VendorController;
use App\Http\Middleware\UserIsAdmin;
use App\Models\City;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum',UserIsAdmin::class);

Route::post("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");

Route::post("/register",[RegisteredUserController::class, "store"]);

Route::post("/login", [LoginUserController::class, "authenticate"]);

Route::post('/forgot-password', [ForgetPasswordController::class, 'forgetPassword'])
    ->name('password.email');   

Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
    ->name('password.reset');

// Route::get("/orders", [OrderController::class, "index"])->middleware("auth:sanctum");
Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index')->middleware(["auth:sanctum"]);
Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store')->middleware(["auth:sanctum"]);
Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show')->middleware(["auth:sanctum"]);
Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update')->middleware(["auth:sanctum"]);
Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy')->middleware(["auth:sanctum"]);

// DiscountTypeController routes
Route::get('/discount-types', [DiscountTypeController::class, 'index'])->name('discount-types.index')->middleware(["auth:sanctum"]);
Route::post('/discount-types', [DiscountTypeController::class, 'store'])->name('discount-types.store')->middleware(["auth:sanctum"]);;
Route::get('/discount-types/{id}', [DiscountTypeController::class, 'show'])->name('discount-types.show')->middleware(["auth:sanctum"]);;
Route::put('/discount-types/{id}', [DiscountTypeController::class, 'update'])->name('discount-types.update')->middleware(["auth:sanctum"]);;
Route::delete('/discount-types/{id}', [DiscountTypeController::class, 'destroy'])->name('discount-types.destroy')->middleware(["auth:sanctum"]);
// company feedback
Route::get('/company/feedback', [CompanyFeedbackController::class, 'index'])->name('discount-types.index')->middleware(["auth:sanctum"]);
Route::post('/company/feedback', [CompanyFeedbackController::class, 'store'])->name('company.feedback.store')->middleware(["auth:sanctum"]);;
// Route::get('/company/feedback/{id}', [CompanyFeedbackController::class, 'show'])->name('company.feedback.show')->middleware(["auth:sanctum"]);;
Route::put('/company/feedback/{id}', [CompanyFeedbackController::class, 'update'])->name('company.feedback.update')->middleware(["auth:sanctum"]);;
Route::delete('/company/feedback/{id}', [CompanyFeedbackController::class, 'destroy'])->name('company.feedback.destroy')->middleware(["auth:sanctum"]);
// attribute 
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index')->middleware(["auth:sanctum"]);
Route::post('/attributes', [AttributeController::class, 'store'])->name('attributes.store')->middleware(["auth:sanctum"]);
Route::get('/attributes/{id}', [AttributeController::class, 'show'])->name('attributes.show')->middleware(["auth:sanctum"]);
Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update')->middleware(["auth:sanctum"]);
Route::delete('/attributes/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy')->middleware(["auth:sanctum"]);
// attribute values 
Route::get('/attribute/values', [AttributeValueController::class, 'index'])->name('attribute.values.index')->middleware(["auth:sanctum"]);
Route::post('/attribute/values', [AttributeValueController::class, 'store'])->name('attribute.values.store')->middleware(["auth:sanctum"]);
Route::get('/attribute/values/{id}', [AttributeValueController::class, 'show'])->name('attribute.values.show')->middleware(["auth:sanctum"]);
Route::put('/attribute/values/{id}', [AttributeValueController::class, 'update'])->name('attribute.values.update')->middleware(["auth:sanctum"]);
Route::delete('/attribute/values/{id}', [AttributeValueController::class, 'destroy'])->name('attribute.values.destroy')->middleware(["auth:sanctum"]);
// get cities
Route::get("/cities",[CityController::class, 'index'])->name('cities.index')->middleware(["auth:sanctum"]);
// categories 
Route::get("/categories",[CategoryController::class, 'index'])->name('categories.index')->middleware(["auth:sanctum"]);
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware(["auth:sanctum"]);
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show')->middleware(["auth:sanctum"]);
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update')->middleware(["auth:sanctum"]);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware(["auth:sanctum"]);


// vendors 
Route::get("/vendors",[VendorController::class, 'index'])->name('vendors.index')->middleware(["auth:sanctum"]);
Route::post('/vendors', [VendorController::class, 'store'])->name('vendors.store')->middleware(["auth:sanctum"]);
Route::get('/vendors/{id}', [VendorController::class, 'show'])->name('vendors.show')->middleware(["auth:sanctum"]);
Route::put('/vendors/{id}', [VendorController::class, 'update'])->name('vendors.update')->middleware(["auth:sanctum"]);
Route::delete('/vendors/{id}', [VendorController::class, 'destroy'])->name('vendors.destroy')->middleware(["auth:sanctum"]);

Route::get("/payment/terms",[PaymentTermController::class, 'index'])->name('payment.terms.index')->middleware(["auth:sanctum"]);
Route::post('/payment/terms', [PaymentTermController::class, 'store'])->name('payment.terms.store')->middleware(["auth:sanctum"]);
Route::get('/payment/terms/{id}', [PaymentTermController::class, 'show'])->name('payment.terms.show')->middleware(["auth:sanctum"]);
Route::put('/payment/terms/{id}', [PaymentTermController::class, 'update'])->name('payment.terms.update')->middleware(["auth:sanctum"]);
Route::delete('/payment/terms/{id}', [PaymentTermController::class, 'destroy'])->name('payment.terms.destroy')->middleware(["auth:sanctum"]);

// Route::get("/products",[ProductController::class, 'index'])->name('products.index');
// Route::post('/vendors', [VendorController::class, 'store'])->name('vendors.store')->middleware(["auth:sanctum"]);
// Route::get('/vendors/{id}', [VendorController::class, 'show'])->name('vendors.show')->middleware(["auth:sanctum"]);
// Route::put('/vendors/{id}', [VendorController::class, 'update'])->name('vendors.update')->middleware(["auth:sanctum"]);
// Route::delete('/vendors/{id}', [VendorController::class, 'destroy'])->name('categories.destroy')->middleware(["auth:sanctum"]);


// products 
Route::get('/products',[ProductController::class,"index"])->name('products.index')->middleware(["auth:sanctum"]);
Route::post('/products',[ProductController::class,"store"])->name('products.store')->middleware(["auth:sanctum"]);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show')->middleware(["auth:sanctum"]);
Route::patch('/products/{id}/status', [ProductController::class, 'updateStatus'])->name('products.status.update')->middleware(["auth:sanctum"]);
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware(["auth:sanctum"]);
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware(["auth:sanctum"]);
// product variants
Route::patch('/products/variants/{id}/status', [ProductVariantController::class, 'updateStatus'])->name('products.variants.status.update')->middleware(["auth:sanctum"]);
Route::delete('/products/variants/{id}', [ProductVariantController::class, 'destroy'])->name('products.variants.destroy')->middleware(["auth:sanctum"]);


