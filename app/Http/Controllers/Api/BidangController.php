<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Bidang;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        try {
            return response()->json(Bidang::all(), 200);
        } catch (Exception $e) {
            return response()->json('Server Error!', 500); 
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $validated = $request->validate([
            'bidang' => ['required','string','unique:bidangs,bidang'],
        ]);
        $response = Bidang::create([
            'bidang'   => $validated['bidang'],
        ]);
        return response()->json([
            'message' => 'Bidang created successfully!',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { 
        try {
            return response()->json(Bidang::findOrFail($id), 200);
        } catch (Exception $e) {
            return response()->json('Server Error!', 500); 
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $bidang = Bidang::find($id);

        if (!$bidang) {
            return response()->json([
                'message' => 'Bidang Not Found!'
            ], 404);
        }

        $validated = $request->validate([
            'bidang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bidangs', 'bidang')->ignore($bidang->id)
            ]
        ]);

        $bidang->update($validated);

        return response()->json([
            'message' => 'Bidang updated successfully' 
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $bidang = Bidang::find($id);

            if (!$bidang) {
                return response()->json([
                    'message' => 'Bidang Not Found!'
                ], 404);
            }

            $bidang->delete();

            return response()->json([
                'message' => 'Bidang deleted successfully!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Server Error!'
            ], 500);
        }
    }
}
