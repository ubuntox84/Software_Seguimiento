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
            $table->json('courses')->nullable()->after('petition_id');
            $table->json('articles')->nullable()->after('courses');
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
              $table->dropColumn(['courses', 'articles']);
        });
    }
};
