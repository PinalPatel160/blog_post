<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StoreFileController;
use App\Http\Resources\UsersResource;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserStoreRequest;

class RegisterController extends Controller
{
    /**
     * Store a newly created user in db.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserStoreRequest $request)
    {

        $file = $request->file('avatar');

        //If user's profile exist then store and add in DB
        if ($request->file('avatar')) {
            $filename = (new UserController())->uploadAvatar($request->file('avatar'));
        }

        //Add password in request parameter
        $request['password'] = Hash::make($request['password']);

        $user = User::create(array_merge($request->all(), ['avatar' => isset($filename) ? $filename : null]));
        $user->sendApiEmailVerificationNotification();

        if ($user) {

            return success($user, 'Please confirm yourself by clicking on verify user button sent to you on your email.');
        } else {

            return response()->json(['error' => 'Registration failed], please try again'], 201);
        }
    }

}
