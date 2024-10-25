<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    use HasFactory;
    // Nombre de la tabla
    protected $table = 'tipo_documento';

    // Clave primaria de la tabla
    protected $primaryKey = 'id';

    // Indica que el modelo tiene claves primarias autoincrementales
    public $incrementing = true;    

    // Tipo de clave primaria
    protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'codigo',
        'nombre',
    ];

    public $hidden = [
        'created_at',
        'updated_at',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleados::class, 'tipo_documento_id');
    }

}
