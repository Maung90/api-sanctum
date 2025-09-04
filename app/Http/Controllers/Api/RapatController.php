<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rapat;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        if ($request->user()->role_id === 1) {
            return response()->json(Rapat::all(), 200);

        }elseif ($request->user()->role_id === 2) {
            $data = Rapat::where('created_by', $request->user()->id);
            return response()->json($data, 200);

        }else{
            return response()->json('Not Found', 404); 
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'waktu'     => ['required', 'date'],
            'lokasi'    => ['nullable', 'string', 'max:255'],
            'agenda'    => ['nullable', 'string'],
            'status'    => ['required', 'in:draft,ongoing,selesai'],
            'passcode'  => ['nullable', 'string', 'max:255'],
            'qr'        => ['nullable', 'string'],
            'notulensi' => ['nullable', 'string'],
        ]);

        $rapat = Rapat::create([
            'created_by' => $request->user()->id,
            ...$validated,
        ]);

        return response()->json([
            'message' => 'Rapat created successfully',
            // 'data'    => $rapat,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        try {
            if ($request->user()->role_id === 1) {
                return response()->json(Rapat::findOrFail($id), 200);

            }elseif ($request->user()->role_id === 2) { 
                $rapat = Rapat::where('id', $id)
                ->where('created_by', $request->user()->id)
                ->firstOrFail();
                return response()->json($rapat, 200);

            }else{
                return response()->json('Not Found', 404); 
            }
        } catch (Exception $e) {
            return response()->json('Server Error!', 500); 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rapat = Rapat::where('id', $id)
        ->where('created_by', $request->user()->id)
        ->firstOrFail();

        $validated = $request->validate([
            'judul'     => ['sometimes', 'required', 'string', 'max:255'],
            'waktu'     => ['sometimes', 'required', 'date'],
            'lokasi'    => ['nullable', 'string', 'max:255'],
            'agenda'    => ['nullable', 'string'],
            'status'    => ['sometimes', 'required', 'in:draft,ongoing,selesai'],
            'passcode'  => ['nullable', 'string', 'max:255'],
            'qr'        => ['nullable', 'string'],
            'notulensi' => ['nullable', 'string'],
        ]);

        $rapat->update($validated);

        return response()->json([
            'message' => 'Rapat updated successfully',
            'data'    => $rapat,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $rapat = Rapat::where('id', $id)
        ->where('created_by', $request->user()->id)
        ->first();

        if (!$rapat) {
            return response()->json([
                'message' => 'Rapat Not Found or Unauthorized'
            ], 404);
        }

        $rapat->delete();

        return response()->json([
            'message' => 'Rapat deleted successfully'
        ], 200);
    }

}
