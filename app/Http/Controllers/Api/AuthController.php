<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginUserRequest;
class AuthController extends Controller
{
    
public function register(RegisterUserRequest $request)
{
    $company = Company::create([
        'name' => $request->company_name,
       // 'domain'=>$request->domain ? $request->domain : null,
       
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'company_id' => $company->id,
        'role' => User::ROLE_ADMIN,
    ]);

    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Registration successful',
        'data' => [
            'user' => new UserResource($user->load('company')),
            'token' => $token
        ]
    ], 201);
}




public function login(LoginUserRequest $request)
{
    $user = \App\Models\User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful',
        'data' => [
            'user' => new UserResource($user->load('company')),
            'token' => $token
        ]
    ]);
}
}
