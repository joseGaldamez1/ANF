<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    use HasFactory;
        // Nombre de la tabla
        protected $table = 'empleados';

        // Clave primaria de la tabla
        protected $primaryKey = 'id';
    
        // Indica que el modelo tiene claves primarias autoincrementales
        public $incrementing = true;
    
        // Tipo de clave primaria
        protected $keyType = 'int';
    
        // Campos que se pueden asignar de forma masiva
        protected $fillable = [
            'nombre1',
            'nombre2',
            'apellido1',
            'apellido2',
            'apellido_casada',
            'tipo_documento_id',
            'numero_documento',
            'numero_afiliado',
            'direccion',
            'telefono',
            'correo',  
            'fecha_ingreso',
            'institucion_id',
            'puesto_trabajo_id',

        ];
    
        public $hidden = [
            'created_at',
            'updated_at',
        ];

        public function institucion()
        {
            return $this->belongsTo(Institucion::class, 'institucion_id');
        }
        public function puestoTrabajo()
        {
            return $this->belongsTo(PuestosTrabajo::class, 'puesto_trabajo_id');
        }
        public function tipoDocumento()
        {
            return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
        }
}
