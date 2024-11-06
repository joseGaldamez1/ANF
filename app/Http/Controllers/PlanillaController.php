<?php

namespace App\Http\Controllers;

use App\Mail\CorreoReporte;
use App\Models\Empleados;
use App\Models\PagoAdicional;
use App\Models\Planilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PlanillaController extends Controller
{

    protected $reportesController;

    public function __construct(ReportesController $reportesController)
    {
        $this->reportesController = $reportesController;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $planilla = Planilla::with('pagoAdicional', 'observacion1', 'observacion2', 'empleado', 'empleador')
        ->where('estado', 'Activa')
        ->get();

        if ($planilla->isEmpty()) {
            return response()->json([
                'message' => 'No hay planillas iniciadas'
            ]);
        }
        
        return response()->json([
            'message' => 'Planilla de pagos',   
            'data' => $planilla
        ]);
    }

    public function sendEmail($periodo)
    {
        // Obtiene todas las planillas del periodo especificado
        $planillas = Planilla::with('pagoAdicional', 'observacion1', 'observacion2', 'empleado', 'empleador')
                            ->where('periodo', $periodo)
                            ->get();
    
        foreach ($planillas as $planilla) {
            // Genera el PDF para cada empleado
            $reporte = $this->reportesController->empleadoPDF($periodo, $planilla->empleado_id);
            $pdf = $reporte->getContent();
    
            // Datos del empleado
            $email = $planilla->empleado->correo;
            $nombreCompleto = $planilla->empleado->nombre1 . ' ' . $planilla->empleado->nombre2 . ' ' . $planilla->empleado->apellido1 . ' ' . $planilla->empleado->apellido2 . ' ' . $planilla->empleado->apellido_casada;
    
            // Verifica si el correo es válido
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Enviar el correo al empleado
                Mail::to($email)->send(new CorreoReporte($nombreCompleto, $periodo, $pdf));
            } else {
                // Registrar en logs si el correo no es válido
                Log::warning("Correo no válido para el empleado: $nombreCompleto ($email)");
            }
        }
    
        return response()->json([
            'message' => 'Correos enviados a todos los empleados'
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create($periodo)
    {

        //Verificar si ya existe una planilla para el periodo
        $planillaExiste = Planilla::where('periodo', $periodo)->first();
        if ($planillaExiste) {
            return response()->json([
                'message' => 'Ya existe una planilla para el periodo ' . $periodo,
                'data' => $planillaExiste
            ]);
        }
        //Agregar todos los empleados a la planilla
        $empleados = Empleados::all();
        
        foreach ($empleados as $empleado) {

            $pagaAdicional = PagoAdicional::create([
                'periodo' => $periodo,
                'cantidad_hora_diurna' => 0,
                'monto_hora_diurna' => 0,
                'cantidad_hora_nocturna' => 0,
                'monto_hora_nocturna' => 0,
                'vacaciones' => 0,
                'aguinaldo' => 0,
                'empleado_id' => $empleado->id,
                'indemnizacion' => 0,
            ]);

            $planilla = Planilla::create([
                'periodo' => $periodo,
                'salario' => $empleado->salario,
                'pago_adicional_id' => $pagaAdicional->id,
                'monto_pago_adicional' => 0,
                'monto_vacaciones' => 0,
                'dias' => 30,
                'horas' => 176,
                'dias_vacaciones' => 0,
                'observacion1_id' => 1,
                'observacion2_id' => 1,
                'empleado_id' => $empleado->id,
                'empleador_id' => 1,
                'estado' => 'Activa',
            ]);
        }

        return response()->json([
            'message' => 'Planilla creada para el periodo ' . $periodo,
            'data' =>[ 
                'planilla' => $planilla,
                 'pago adicional' => $pagaAdicional
            ]


        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Mostrar unplanilla por id
     */
    public function show($periodo)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
