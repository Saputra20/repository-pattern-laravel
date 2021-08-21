<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\BiodataRequest;
use App\Http\Requests\BusinessRequest;
use App\Http\Repository\AccountRepository;
use App\Http\Repository\BiodataRepository;
use App\Http\Repository\BusinessRepository;
use Illuminate\Support\Facades\Auth;

// Helper
use App\Helpers\ApiResponse;

class RegisterController extends Controller
{

    protected $accountRepo, $biodataRepo, $businessRepo;

    public function __construct()
    {
        $this->accountRepo = new AccountRepository();
        $this->biodataRepo = new BiodataRepository();
        $this->businessRepo = new BusinessRepository();
    }

    public function account(RegisterRequest $request)
    {
        try {
            $body = $request->all();
            $body["password"] = Hash::make($request->password);
            $body['remember_token'] = $this->accountRepo->generateTokenActivate($request->email);

            $account = $this->accountRepo->create($body);
            dispatch(new \App\Jobs\SendRegistrationMail((object) $body));
            return ApiResponse::success("success", $account);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }

    public function biodata(BiodataRequest $request)
    {
        try {
            $body = $request->all();
            $body['account_id'] = Auth::user()->id;

            $biodata = $this->biodataRepo->create($body);
            $account = $this->accountRepo->find(Auth::user()->id);
            $account->step_register = 'business';
            $account->save();

            return ApiResponse::success('success', $biodata);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }

    public function business(BusinessRequest $request)
    {
        try {
            $body = $request->all();
            $body['account_id'] = Auth::user()->id;
            $body['social_media'] = json_encode($request->social_media);

            $business = $this->businessRepo->create($body);
            $account = $this->accountRepo->find(Auth::user()->id);
            $account->step_register = 'complete';
            $account->save();

            return ApiResponse::success('success', $business);
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage(), 501);
        }
    }
}
