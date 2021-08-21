<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('external_id');
            $table->string('owner_id');
            $table->string('payment_id')->nullable();
            $table->string('callback_virtual_account_id')->nullable();
            $table->string('merchant_code');
            $table->string('bank_code');
            $table->string('account_number');
            $table->double('amount')->default(0);
            $table->double('expected_amount');
            $table->string('currency');
            $table->string('status');
            $table->dateTime('expiration_date');
            $table->dateTime('transaction_timestamp')->nullable();
            $table->boolean('paid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
