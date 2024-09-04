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
      return  response()->json('Credentials do not match', 400);
    }
    $token = $user->createToken('user')->plainTextToken;
    $user->token = $token;
    return response()->json([
      'id' => $user['id'],
      'name' => $user['name'],
      'email' => $user['email'],
      'token' => $token,
    ], 200);
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

    return response()->json("You have successfully registered", 200);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();

    return response()->json(
      "You have successfully have been loged out and your token has been deleted",
      200
    );
  }
}
