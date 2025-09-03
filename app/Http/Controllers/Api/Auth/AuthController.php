<?php 
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email','max:255','string'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // if (! $user->is_verified) {
        //     return response()->json(['message' => 'Please verify OTP before login.'], 403);
        // }

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'nip'          => ['required','numeric','unique:users,nip'],
            'nama_lengkap' => ['required','max:255','string'],
            'email'        => ['required','email','max:255','string','unique:users,email'],
            'role_id'      => ['required','in:2,3'],
            'bidang_id'    => ['required','exists:bidangs,id'],
            'password'     => ['required','min:6'],
        ]);
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $user = User::create([
            'nip'          => $validated['nip'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'email'        => $validated['email'],
            'role_id'      => $validated['role_id'],
            'bidang_id'    => $validated['bidang_id'],
            'password'     => Hash::make($validated['password']),
            'otp'          => $otp,
            'is_verified'  => false,
        ]);

        // TODO: kirim OTP via email / SMS (sesuai kebutuhan)
        return response()->json([
            'message' => 'User registered. Please verify OTP sent to your email/phone.',
            'otp'     => $otp,
        ], 201);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'otp'   => ['required','string'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->is_verified) {
            return response()->json(['message' => 'User already verified'], 400);
        }

        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        $user->is_verified = true;
        $user->otp = null;
        $res = $user->save(); 

        if (!$res) {
            return response()->json(['message' => 'OTP verified failed. Please try again.'], 400);
        }
        return response()->json(['message' => 'OTP verified successfully. You can now login.'], 200);

    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

}
