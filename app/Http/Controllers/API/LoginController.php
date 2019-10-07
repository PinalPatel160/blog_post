<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    /**
     * Login API
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email|max:260|min:5',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = Auth::user();

            if ($user->email_verified_at !== null) {
                $user->update(['api_token' => Str::random(60)]);

                return success($user, 'Login successfully');
            } else {

                return response()->json(['error' => 'Please Verify Email'], 401);
            }
        } else {

            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function logout()
    {

        if (auth()->user()->update(['api_token' => null])) {
            return response()->json([
                'message' => 'User Logged Out',
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }
}
