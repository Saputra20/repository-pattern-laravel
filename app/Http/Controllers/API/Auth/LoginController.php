<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Http\Repository\AccountRepository;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

// models
use App\Models\Account;

// request
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResendVerification;
use App\Http\Requests\VerifyOtpRequest;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $accountRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->accountRepo = new AccountRepository();
    }

    public function authenticate(LoginRequest $request)
    {
        try {
            $credentials = $request->only("email", "password");
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return ApiResponse::error("invalid credentials", 400);
            }

            $account = $this->accountRepo->findWhere(['email' => $request->email]);
            if($account->active == 0){
                return ApiResponse::error("account not active", 403);
            }
            $otp = $this->accountRepo->generateOTP($account)->getData();
            dispatch(new \App\Jobs\SendOTPMail($otp->number, $account->email));

            return ApiResponse::success("success", ['otp_token' => $otp->token]);
        } catch (JWTException $e) {
            return ApiResponse::error("could no create token", 500);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        try {
            $payload    = JWTAuth::parseToken()->getPayload()->get('sub');
            $otp        = $payload->otp;

            if ($otp == $request->otp) {
                $account = $this->accountRepo->find($payload->account->id);
                $token = JWTAuth::fromUser($account);
                if (!$token) {
                    return ApiResponse::error("could not create token", 400);
                }

                $account->access_token = $token;
                $account->token_type = 'bearer';
                $account->expire_in = JWTAuth::factory()->getTTL() * 60;

                return ApiResponse::success("success", $account);
            } else {
                return ApiResponse::error("Otp not match!", 403);
            }
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }

    public function resendOtp(ResendVerification $request)
    {
        try {
            $account = $this->accountRepo->findWhere(['email' => $request->email]);

            if (!$account) {
                return ApiResponse::error("email not found", 404);
            }

            $otp = $this->accountRepo->generateOTP($account)->getData();
            dispatch(new \App\Jobs\SendOTPMail($otp->number, $account->email));

            return ApiResponse::success("success", ['otp_token' => $otp->token]);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }
}
