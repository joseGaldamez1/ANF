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
        Schema::create('planilla', function (Blueprint $table) {
            $table->id(); 
            $table->string('periodo', 10); 
            $table->decimal('salario', 10, 2); 
            $table->unsignedBigInteger('pago_adicional_id');
            $table->decimal('monto_pago_adicional', 10, 2);
            $table->decimal('monto_vacaciones', 10, 2); 
            $table->integer('dias'); 
            $table->integer('horas'); 
            $table->integer('dias_vacaciones'); 
            $table->unsignedBigInteger('observacion1_id'); 
            $table->unsignedBigInteger('observacion2_id');
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('empleador_id');
            
            // Claves foráneas
            $table->foreign('pago_adicional_id')->references('id')->on('pago_adicional');
            $table->foreign('observacion1_id')->references('id')->on('observaciones');
            $table->foreign('observacion2_id')->references('id')->on('observaciones');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('empleador_id')->references('id')->on('empleador');
    
            $table->timestamps(); // Campos created_at y updated_at
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planilla');
    }
};
