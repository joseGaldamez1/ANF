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
        Schema::create('pago_adicional', function (Blueprint $table) {
            $table->id();
            $table->string('periodo', 20);
            $table->integer('cantidad_hora_diurna');
            $table->decimal('monto_hora_diurna', 10, 2);
            $table->integer('cantidad_hora_nocturna');
            $table->decimal('monto_hora_nocturna', 10, 2);
            $table->decimal('vacaciones', 10, 2);
            $table->decimal('aguinaldo', 10, 2);
            $table->unsignedBigInteger('empleado_id');
            $table->decimal('indemnizacion', 10, 2);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_adicional');
    }
};
