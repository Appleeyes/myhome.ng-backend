<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function sendEmail(Request $request, User $user)
    {
        $verificationCode = User::generateVerificaionCode();

        Cache::put('verification_code_' . $user->id, $verificationCode, now()->addMinute(10));
        
        Mail::to($user->email)->send(new VerifyEmail($verificationCode));

        return response()->json([
            'message' => 'Verification code sent successfully',
        ], Response::HTTP_OK);
    }
}
