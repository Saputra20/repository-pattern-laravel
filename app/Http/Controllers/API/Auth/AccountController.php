<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\ResendVerification;
use App\Http\Controllers\Controller;
use App\Http\Repository\AccountRepository;
use App\Http\Repository\BiodataRepository;
use App\Http\Repository\BusinessRepository;
use JWTAuth;
use Exception;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $accountRepo, $biodataRepo, $businessRepo;

    public function __construct()
    {
        $this->accountRepo = new AccountRepository();
        $this->biodataRepo = new BiodataRepository();
        $this->businessRepo = new BusinessRepository();
    }

    public function activate()
    {
        try {
            $payload = JWTAuth::parseToken()->getPayload()->get('sub');
            $email = $payload->email;

            $account = $this->accountRepo->findWhere(["email" => $email]);

            if ($account) {
                if ($account->active == 0) {
                    $account->active = 1;
                    $account->active_at = \Carbon\Carbon::now();
                    $account->save();

                    echo "Congrats, your account is active!";
                } else {
                    echo "Sorry, your account has been verification before!";
                }
            } else {
                return ApiResponse::error("Token is Invalid", 401);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return ApiResponse::error("Token is Invalid", 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return ApiResponse::error("Token is Expired", 401);
            } else {
                return ApiResponse::error("Authorization Token not found", 401);
            }
        }
    }

    public function sendActivateEmail(ResendVerification $request)
    {
        try {
            $account = $this->accountRepo->findWhere(["email" => $request->email]);

            if ($account) {
                $body['email'] = $request->email;
                $body['remember_token'] = $this->accountRepo->generateTokenActivate($request->email);

                dispatch(new \App\Jobs\SendRegistrationMail((object) $body));
                return ApiResponse::success("E-mail verification sent successfuly");
            } else {
                return ApiResponse::error("E-mail not found", 404);
            }
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }

    public function account()
    {
        try {
            $account = $this->accountRepo->find(Auth::user()->id);
            return ApiResponse::success("success", $account);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }

    public function profile()
    {
        try {
            $biodata = $this->biodataRepo->findWhere(['account_id' => Auth::user()->id]);
            return ApiResponse::success("success", $biodata);
        } catch (\Throwable $th) {
            return ApiResponse::error("Server internal Error", 501);
        }
    }

    public function business()
    {
        try {
            $business = $this->businessRepo->findWhere(['account_id' => Auth::user()->id]);
            return ApiResponse::success("success", $business);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }
}
