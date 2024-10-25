<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'planilla';
    
    // Clave primaria de la tabla
    protected $primaryKey = 'id';

    // Indica que el modelo tiene claves primarias autoincrementales
    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'periodo',
        'salario',
        'pago_adicional_id',
        'monto_total_adicional',
        'monto_vacaciones',
        'dias',
        'horas',
        'observacion1_id',
        'observacion2_id',
        'empleado_id',
        'empleador_id',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pagoAdicional()
    {
        return $this->belongsTo(PagoAdicional::class, 'pago_adicional_id');
    }

    public function observacion1()
    {
        return $this->belongsTo(Observaciones::class, 'observacion1_id');
    }

    public function observacion2()
    {
        return $this->belongsTo(Observaciones::class, 'observacion2_id');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleados::class, 'empleado_id');
    }

    public function empleador()
    {
        return $this->belongsTo(Empleador::class, 'empleador_id');
    }
}
