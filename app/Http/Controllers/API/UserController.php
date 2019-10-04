<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * User's profile get
     *
     * @return array
     */
    public function userProfile()
    {
        return success(auth()->user(),'User Profile Fetched successfully.');
    }

    public function update(){

    }
}
