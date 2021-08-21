<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\TransactionRepository;
use App\Http\Requests\VARequest;
use Xendit\Xendit;

class PaymentController extends Controller
{
    protected $trxRepo;

    public function __construct()
    {
        Xendit::setApiKey(env('XENDIT_SECRET'));
        $this->trxRepo = new TransactionRepository();
    }

    public function getListVa()
    {
        try {
            $banks = \Xendit\VirtualAccounts::getVABanks();

            return ApiResponse::success("success", $banks);
        } catch (\Xendit\Exceptions\ApiException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode(), []);
        }
    }

    public function getVa($id)
    {
        try {
            $va = \Xendit\VirtualAccounts::getFVAPayment($id);

            return ApiResponse::success("success", $va);
        } catch (\Xendit\Exceptions\ApiException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode(), []);
        }
    }

    public function storeVa(VARequest $request)
    {
        try {
            $params = $request->all();
            $params['external_id'] = \uniqid();
            $params['is_closed'] = true;
            $params['is_single_use'] = true;
            $params['expiration_date'] = \Carbon\Carbon::now()->addDays(1)->toISOString();

            $va = \Xendit\VirtualAccounts::create($params);

            $body = $va;
            $body['expiration_date'] = \Carbon\Carbon::parse($va['expiration_date'])->format('Y-m-d H:i:s');

            $transaction = $this->trxRepo->create($body);

            return ApiResponse::success("success", $transaction);
        } catch (\Xendit\Exceptions\ApiException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode(), []);
        }
    }

    public function notificationVa(Request $request, $type)
    {
        switch ($type) {
            case 'paid':
                $external_id = $request->external_id;
                $trx = $this->trxRepo->findWhere(['external_id' => $external_id]);

                if ($trx) {
                    $trx->payment_id = $request->payment_id;
                    $trx->callback_virtual_account_id = $request->callback_virtual_account_id;
                    $trx->amount = $request->amount;
                    $trx->transaction_timestamp = \Carbon\Carbon::parse($request->transaction_timestamp)->format('Y-m-d H:i:s');
                    $trx->paid = true;
                    $trx->save();

                    return ApiResponse::success("success", $trx);
                } else {
                    return ApiResponse::error('Transaction not found', 404, []);
                }
                break;

            case 'created':
                $external_id = $request->external_id;
                $trx = $this->trxRepo->findWhere(['external_id' => $external_id]);

                if ($trx) {
                    $trx->status = $request->status;
                    $trx->save();

                    return ApiResponse::success("success", $trx);
                } else {
                    return ApiResponse::error('Transaction not found', 404, []);
                }
                break;
        }
    }

    public function notification(Request $request , $paymentMethod , $type)
    {
        switch ($paymentMethod) {
            case 'e-wallet':
                $data = $request->data;
                break;
            
            default:
                # code...
                break;
        }
    }

    public function snapMidtrans()
    {
        try {
            \Midtrans\Config::$serverKey = env('MIDTRANS_SECRET');

            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => 10000,
                )
            );

            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
            return ApiResponse::success('success' , $paymentUrl);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function notificationMidtrans()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SECRET');
    }
}