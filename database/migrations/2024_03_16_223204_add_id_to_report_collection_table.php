<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToReportCollectionTable extends Migration
{
    public function up()
    {
        Schema::table('report_collection', function (Blueprint $table) {
            $table->id();
        });
    }

    public function down()
    {
        Schema::table('report_collection', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
