<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_petitions', function (Blueprint $table) {
        $table->json('backup')->nullable();
        $table->json('excel_record')->nullable();
        $table->json('configuration')->nullable();
        $table->integer('agreement_number')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('user_petitions', function (Blueprint $table) {
        $table->dropColumn('backup');
        $table->dropColumn('excel_record');
        $table->dropColumn('agreement_number');
        $table->dropColumn('configuration');
    });
    }
};
