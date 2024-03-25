<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balance_request', function (Blueprint $table) {
            $table->id();
            $table->string('pending_balance');
            $table->string('customers_name');
            $table->string('account_number');
            $table->string('account_name');
            $table->dateTime('date_time');
            $table->string('rep_id');
            $table->string('sales_representative');
            $table->string('status');
            $table->string('customers_id');
            $table->decimal('balance_accept');
            $table->string('payment_method');
            $table->date('transaction_date');
            $table->decimal('transaction_amount');
            $table->string('transaction_number');
            $table->string('pos_account');
            $table->date('accepted_transaction_bank_date');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('balance_request');
    }
}
