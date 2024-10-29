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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre1', 45); 
            $table->string('nombre2', 45)->nullable();
            $table->string('apellido1', 45); 
            $table->string('apellido2', 45)->nullable();
            $table->string('apellido_casada', 45)->nullable(); 
            $table->unsignedBigInteger('tipo_documento_id'); 
            $table->string('numero_documento', 20); 
            $table->string('numero_afiliado', 45); 
            $table->string('direccion', 150);
            $table->string('telefono', 8);
            $table->string('correo', 100);
            $table->date('fecha_ingreso');
            $table->unsignedBigInteger('institucion_id');
            $table->unsignedBigInteger('puesto_trabajo_id');
            
            // Claves foráneas
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento');
            $table->foreign('puesto_trabajo_id')->references('id')->on('puestos_trabajo');
            $table->foreign('institucion_id')->references('id')->on('instituciones');
            
            $table->timestamps(); 
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
