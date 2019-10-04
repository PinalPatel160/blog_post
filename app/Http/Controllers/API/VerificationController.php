<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user’s email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $user = User::findOrFail($request['id'])->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'User already have verified email!'], 422);
        }

        // to enable the “email_verified_at" field of that user be a current time stamp by the must verify email feature
        $user->email_verified_at = date('Y-m-d g:i:s');
        $user->update();

        /*$user->update([
            'email_verified_at' => date('Y-m-d g:i:s')
        ]);*/

        return success('', 'Email verified!');
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $user = User::where(request()->validate([
            'email' => ['required', 'email'],
        ]))->first();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'User already have verified email!'], 422);
        }

        $user->sendApiEmailVerificationNotification();
        return success('', 'The notification has been resubmitted');
    }
}
