<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([$request->user()], 200);
    }
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama_lengkap' => ['sometimes','string','max:255'],
            'email'        => ['sometimes','email','max:255','unique:users,email,'.$user->id], 
            'bidang_id'    => ['sometimes','exists:bidangs,id'],
            'password'     => ['nullable','min:6'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => $user
        ]);
    }
}
