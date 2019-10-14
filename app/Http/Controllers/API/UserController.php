<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StoreFileController;
use App\Http\Requests\ProfileUpdateRequest;
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
        return success(auth()->user(), 'User\'s profile fetched successfully.');
    }

    public function update(ProfileUpdateRequest $request)
    {

        if ($request->hasFile('avatar')) {
            $filename = $request->avatar->store('avatar');
        }

        auth()->user()->update(array_merge($request->all(), isset($filename) ? ['avatar' => $filename] : []));

        return success('', 'Profile updated successfully.');

    }
}
