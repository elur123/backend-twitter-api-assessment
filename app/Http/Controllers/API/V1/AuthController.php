<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;


use App\Models\User;
class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        User::create($request->validated());

        return response()->json(['message' => 'Successfully registered'], 200);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw new HttpResponseException(response()->json([
                'email' => ['The provided credentials are incorrect.'],
            ], 422));
        }

        $user->tokens()->where('name', 'auth-token')->delete();
    
        $token =  $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Successfully login',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()
        ->tokens()
        ->delete();

        return response()->json(['message' => 'Successfully logout'], 200);
    }
}
