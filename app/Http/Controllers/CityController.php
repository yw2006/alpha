<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cities = City::all();
            return response()->json([
                'status' => 'success',
                'data' => $cities
                ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Failed to store attribute",
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

}
