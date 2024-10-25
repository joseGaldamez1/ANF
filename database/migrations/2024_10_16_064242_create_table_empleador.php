<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empleador', function (Blueprint $table) {
            $table->id();
        $table->unsignedBigInteger('tipo_documento_id');
        $table->string('numero_documento');
        $table->integer('numero_patronal'); 
        $table->string('centro_trabajo', 10);
        //llave foranea con la tabla tipo_documento
        $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleador');
    }
};
