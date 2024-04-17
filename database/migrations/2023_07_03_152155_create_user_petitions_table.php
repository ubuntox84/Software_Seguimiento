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
        Schema::create('user_petitions', function (Blueprint $table) {
            $table->id();
            $table->integer('state_petition');
            $table->string('code_petition',25);
            $table->datetime('processing_date')->nullable();
            $table->integer('processing_status')->nullable();
            $table->string('observations',1024)->nullable();
            $table->text('subject',1024)->nullable();
            $table->string('voucher_imagen_path',1000);
            $table->string('petition_imagen_path',1000);
            $table->string('record_pdf_path',1000)->nullable();

            $table->unsignedBigInteger('user_petition_id')->nullable();
            $table->unsignedBigInteger('user_processor_id')->nullable();
            $table->unsignedBigInteger('petition_id')->nullable();

            $table->foreign('user_petition_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('user_processor_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('petition_id')->references('id')->on('petitions')->onDelete('restrict');
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
        Schema::dropIfExists('user_petitions');
    }
};
