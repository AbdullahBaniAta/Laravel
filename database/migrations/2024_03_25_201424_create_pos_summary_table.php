<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_summary', function (Blueprint $table) {
            $table->id();
            $table->date('day');
            $table->string('pos_id');
            $table->string('pos_name');
            $table->string('arabic_name');
            $table->string('rep_name');
            $table->string('rep_id');
            $table->string('channel');
            $table->string('region');
            $table->string('city');
            $table->integer('quantity');
            $table->decimal('sum_channel_price', 10, 2);
            $table->decimal('sum_net_price', 10, 2);
            $table->decimal('sum_cost', 10, 2);
            $table->decimal('company_earning', 10, 2);
            $table->decimal('customer_earning', 10, 2);
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
        Schema::dropIfExists('pos_summary');
    }
}
