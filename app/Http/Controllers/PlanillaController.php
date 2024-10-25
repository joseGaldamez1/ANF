<?php

namespace App\Http\Controllers;

use App\Mail\CorreoReporte;
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
        $planilla = Planilla::with('pagoAdicional', 'observacion1', 'observacion2', 'empleado', 'empleador')->get();
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Mostrar un aplanilla por id
     */
    public function show($periodo, $id)
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
