<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function update_role(Request $request, User $user)
    {
        if ($user->role_id !== 1) {
            return response()->json(['message' => 'Only admin can be approved'], 400);
        }
        // $user->update(['role_id' => $request->role_id]);

        return response()->json(['message' => 'Admin approved', 'data' => $request->role_id]);
    }
}
