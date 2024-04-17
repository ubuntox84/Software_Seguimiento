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
        Schema::create('area_knowledge', function (Blueprint $table) {
            $table->id();
            $table->string('code',50)->index()->nullable();
            $table->string('name',100)->index()->unique();

            $table->unsignedBigInteger('curricula_id')->nullable();
            $table->foreign('curricula_id')
                    ->references('id')
                    ->on('curriculas')
                    ->onDelete('restrict');
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
        Schema::dropIfExists('area_knowledge');
    }
};
