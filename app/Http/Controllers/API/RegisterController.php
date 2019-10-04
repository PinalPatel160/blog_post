<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StoreFileController;
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
        if ($file) {
            $request['avatar'] = (new StoreFileController())->storeFile($file,'avatar');
        }

        //Add api_token,password in request parameter
        $request['api_token'] = Str::random(60);
        $request['password'] = Hash::make($request['password']);

        $user = User::create($request->all());

        if ($user) {

            return success('','Before proceeding, please check your email for a verification link.');
        } else {
            return fail('','Registration failed, please try again.');

        }
    }

}
