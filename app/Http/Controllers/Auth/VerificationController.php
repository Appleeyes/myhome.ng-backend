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
    /**
     * @OA\Post(
     *      path="/api/v1/{user}/send-verification-email",
     *      tags={"Email"},
     *      summary="Send a verification code to the user's email",
     *      description="Sends a verification code to the user's email for verification purposes.",
     *      operationId="sendEmail",
     *      @OA\Parameter(
     *          name="user",
     *          in="path",
     *          required=true,
     *          description="ID of the user to receive the verification code",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Verification code sent successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Verification code sent successfully"),
     *          ),
     *      ),
     * )
     */
    public function sendEmail(Request $request, User $user)
    {
        $verificationCode = User::generateVerificationCode();

        Cache::put('verification_code_' . $user->id, $verificationCode, now()->addMinutes(10));

        Mail::to($user->email)->send(new VerifyEmail($verificationCode));

        return response()->json([
            'message' => 'Verification code sent successfully',
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/verify-email",
     *      tags={"Email"},
     *      summary="Verify the user's email using the verification code",
     *      description="Verifies the user's email by checking the verification code.",
     *      operationId="verifyEmail",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          required=true,
     *          description="ID of the user to be verified",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="verification_code",
     *          in="query",
     *          required=true,
     *          description="Verification code sent to the user's email",
     *          @OA\Schema(type="integer", example=1234)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Email verified successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Email verified successfully"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid verification code",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid verification code"),
     *          ),
     *      ),
     * )
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'verification_code' => 'required|numeric'
        ]);

        $userId = $request->input('user_id');
        $verificationCode = $request->input('verification_code');

        $cachedCode = Cache::get('verification_code_' . $userId);

        if ($cachedCode && $cachedCode == $verificationCode){
            $user = User::find($userId);
            $user->email_verified_at = now();
            $user->save();

            Cache::forget('verification_code_' . $userId);

            return response()->json([
                'message'=> 'Email verified successfully'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'message' => 'Invalid verification code',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
