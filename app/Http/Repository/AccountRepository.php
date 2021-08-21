<?php

namespace App\Http\Repository;

use App\Models\Account;
use JWTAuth;
use JWTFactory;
use Carbon\Carbon;


class AccountRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Account());
    }

    private function randomNumber()
    {
        return mt_rand(100000, 999999);
    }

    public function generateOTP($data)
    {
        $otp = self::randomNumber();
        $factory = JWTFactory::customClaims([
            'sub'   => [
                'account' => $data,
                'otp' => $otp
            ],
            'exp'   => Carbon::now()->addMinutes(2)->timestamp,
        ]);

        $payload = $factory->make();

        $token = JWTAuth::encode($payload);
        return response()->json([
            'token' => $token->get(),
            'number' => $otp
        ]);
    }

    public function generateTokenActivate($email)
    {
        $factory = JWTFactory::customClaims([
            'sub'   => [
                'email' => $email,
            ],
            'exp'   => Carbon::now()->addDays(30)->timestamp,
        ]);

        $payload = $factory->make();

        $token = JWTAuth::encode($payload);
        return $token->get();
    }
}
