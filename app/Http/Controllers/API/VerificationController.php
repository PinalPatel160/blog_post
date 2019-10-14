<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

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
        $user = User::findOrFail($request['id']);

        if ($user->hasVerifiedEmail()) {

            $message = 'Your email already verified. Thanks!';
            return view('email_verify', compact(['user', 'message']));
        }

        //To enable the “email_verified_at" field of that user be a current time stamp by the must verify email feature
        $user->email_verified_at = date('Y-m-d g:i:s');
        $user->update();

        $message = 'Your email has been successfully verified';
        return view('email_verify', compact(['user', 'message']));
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

        if (!$user){
            return response()->json('Email not exist.',404);
        }

        if ($user->hasVerifiedEmail()) {
            $message = 'Your email already verified. Thanks!';
            return view('email_verify', compact(['user', 'message']));
        }

        $user->sendApiEmailVerificationNotification();

        return success('', 'The notification has been resubmitted');
    }
}
