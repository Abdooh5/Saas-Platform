<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;


class UserController extends Controller
{
    public function index()
{ $user= Auth::user();

    return UserResource::collection(
        User::where('company_id', $user->company_id)->get()
    );
}
 public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        // تحقق من كلمة المرور الحالية
        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }

        // تحديث كلمة المرور
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    }

    public function store(StoreUserRequest $request)
{
   $user= Auth::user();
    Gate::authorize('create', User::class);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make('password123'),
        'company_id' => $user->company_id,
        'role' => User::ROLE_MEMBER,
    ]);

    return response()->json([
        'success' => true,
        'data' => new UserResource($user)
    ]);
}

}
