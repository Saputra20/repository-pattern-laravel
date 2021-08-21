<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['external_id', 'owner_id', 'payment_id', 'callback_virtual_account_id', 'merchant_code', 'bank_code', 'account_number', 'amount', 'status', 'expected_amount', 'currency', 'expiration_date', 'transaction_timestamp', 'paid'];
}
