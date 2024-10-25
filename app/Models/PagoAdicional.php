<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoAdicional extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'pago_adicional';

    // Clave primaria de la tabla
    protected $primaryKey = 'id';

    // Indica que el modelo tiene claves primarias autoincrementales
    public $incrementing = true;

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'periodo',
        'cantidad_hora_diurna',
        'monto_hora_diurna',
        'cantidad_hora_nocturna',
        'monto_hora_nocturna',
        'vacaciones',
        'aguinaldo',
        'empleado_id',
        'indemnizacion'
    ];

  
    public function empleado()
    {
        return $this->belongsTo(Empleados::class, 'empleado_id');
    }
}
