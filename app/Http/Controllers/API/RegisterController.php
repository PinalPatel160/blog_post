<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
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
        $user = new User($request->all());

        //If user's profile exist then store and add in DB
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->avatar->store('avatar');
        }

        //Add password in request parameter
        $user->password = Hash::make($request['password']);
        $user->save();

        $user->sendApiEmailVerificationNotification();

        if ($user) {

            return success($user, 'Please confirm yourself by clicking on verify user button sent to you on your email.');
        } else {

            return response()->json(['error' => 'Registration failed, please try again'], 201);
        }
    }

}
