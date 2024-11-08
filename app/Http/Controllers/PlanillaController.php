<?php

namespace App\Http\Controllers;

use App\Mail\CorreoReporte;
use App\Models\Empleados;
use App\Models\PagoAdicional;
use App\Models\Planilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
            'data' => [
                'planilla' => $planilla,
                'pago adicional' => $pagaAdicional
            ]


        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function emitir()
    {
        // Obtener todas las planillas activas
        $planillas = Planilla::where('estado', 'Activa')->get();

        if ($planillas->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron planillas activas.',
            ], 404);
        }

        foreach ($planillas as $planilla) {
            $planilla->estado = 'Finalizada';
            $planilla->save();
        }

        return response()->json([
            'message' => 'Planillas finalizadas',
            'data' => $planillas, 
        ]);
    }


    /**
     * Mostrar unplanilla por id
     */
    public function show($periodo) {}

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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cantidad_hora_diurna' => 'required|numeric',
            'monto_hora_diurna' => 'required|numeric',
            'cantidad_hora_nocturna' => 'required|numeric',
            'monto_hora_nocturna' => 'required|numeric',
            'vacaciones' => 'required|numeric',
            'aguinaldo' => 'required|numeric',
            'indemnizacion' => 'required|numeric',
            'observacion1_id' => 'required|numeric',
            'observacion2_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        DB::beginTransaction();

        try {
            // Actualizar el detalle de pago adicional de la planilla
            $planilla = Planilla::find($id);
            $pagoAdicional = PagoAdicional::find($planilla->pago_adicional_id);

            $pagoAdicional->update([
                'cantidad_hora_diurna' => $request->cantidad_hora_diurna,
                'monto_hora_diurna' => $request->monto_hora_diurna,
                'cantidad_hora_nocturna' => $request->cantidad_hora_nocturna,
                'monto_hora_nocturna' => $request->monto_hora_nocturna,
                'vacaciones' => $request->vacaciones,
                'aguinaldo' => $request->aguinaldo,
                'indemnizacion' => $request->indemnizacion,
            ]);

            // Actualizar el detalle de la planilla
            $planilla->update([
                'monto_pago_adicional' => $request->pago_adicional,
                'monto_vacaciones' => $pagoAdicional->vacaciones,
                'dias' => $request->dias,
                'horas' => $request->horas,
                'dias_vacaciones' => '15',
                'observacion1_id' => $request->observacion1_id,
                'observacion2_id' => $request->observacion2_id,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'success',
                'data' => $planilla
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'error',
                'data' => $e->getMessage()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
