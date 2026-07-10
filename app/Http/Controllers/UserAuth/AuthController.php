<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $request->validate([
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', Rules\Password::defaults()],
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
      return response()->json(['error' => 'Credentials do not match'], 400);
    }
    $token = $user->createToken('flutter')->plainTextToken;
    return response()->json([
      'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
      ],
      'token' => $token,
    ]);
  }

  public function register(Request $request)
  {
    $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('flutter')->plainTextToken;

    return response()->json([
      'user' => [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
      ],
      'token' => $token,
    ]);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out successfully']);
  }
}
