<?php

namespace App\Http\Controllers;

use App\Models\Planilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Csv as WriterCsv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function planillaPDF(string $periodo)
    {
        $planilla = Planilla::with('pagoAdicional', 'observacion1', 'observacion2', 'empleado', 'empleador')->where('periodo', $periodo)->get();
        $pdf = new \TCPDF();
        $pdf->AddPage();
        $pdf->setPageOrientation('L');



        $pdf->writeHTML('<h1>ANALISIS FINANCIERO, S.A DE C.V.</h1>', 0, 0, 0, 0, 'C');
        $pdf->writeHTML('<h2>PLanilla de Pagos</h2>', 0, 0, 0, 0, 'C');
        $pdf->Cell(70, 5, 'Periodo:' . $periodo, 0, 0, 'L');
        $pdf->Cell(200, 5, 'Fecha de generación: ' . date('Y-m-d'), 0, 0, 'R');
        $pdf->Ln(10);

        $tablaPlanilla = '
        <table  border="0" cellpading="0" cellspacing="0" style="border-collapse: collapse; width: 100%;" >
    <thead>
        <tr style="text-align: center; font-weight: bold; background-color: #f4f2ef; height: 50px; font-size: 9px">
            <th style="border: 1px solid black; width: 20px; height: 40px">N°</th>
            <th style="border: 1px solid black; width: 155px">Empleado</th>
            <th style="border: 1px solid black; width: 60px; font-size: 10px">Numero de documento</th>
            <th style="border: 1px solid black; align: center; width: 55px">Salario</th>
            <th style="border: 1px solid black; font-size: 10px; width: 45px">Horas Diurnas</th>
            <th style="border: 1px solid black; width: 57px">Horas Nocturnas</th>
            <th style="border: 1px solid black; width: 45px">Vacaciones</th>
            <th style="border: 1px solid black; width: 50px">Indemnizacion</th>
            <th style="border: 1px solid black; width: 45px">Aguinaldo</th>
            <th style="border: 1px solid black; width: 50px">Total</th>
            <th style="border: 1px solid black; width: 45px">AFP Laboral</th>
            <th style="border: 1px solid black; width: 40px">ISSS Laboral</th>
            <th style="border: 1px solid black; font-size: 10px; width: 50px">Renta</th>
            <th style="border: 1px solid black; width: 60px">Total a Pagar</th>
            
        </tr>
    </thead>
    <tbody>';

        $contador = 1;
        $total = 0;
        $totalPlanilla = 0;
        foreach ($planilla as $plan) {
            $total = $plan->salario + $plan->pagoAdicional->monto_hora_diurna + $plan->pagoAdicional->monto_hora_nocturna + $plan->pagoAdicional->vacaciones + $plan->pagoAdicional->indemnizacion + $plan->pagoAdicional->aguinaldo;
            $renta = $this->calcularRenta($total);
            $totalPagar = $total - ($total * 0.0725) - (($total > 1000) ? 30  : $total * 0.03) - $renta;
            $totalPlanilla += $totalPagar;
            $tablaPlanilla .= '
        <tr style="font-size: 9px; border: 1px dotted black">
            <td style="border: 1px dashed gray; text-align: center; width: 20px; height: 20px;">' . $contador++ . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 155px">' . $plan->empleado->nombre1 . ' ' . $plan->empleado->nombre2 . ' ' . $plan->empleado->apellido1 . ' ' . $plan->empleado->apellido2 . ' ' . $plan->empleado->apellido_casada . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 60px">' . $plan->empleado->numero_documento . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 55px">$ ' . $plan->salario . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 45px">$ ' . $plan->pagoAdicional->monto_hora_diurna . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 57px">$ ' . $plan->pagoAdicional->monto_hora_nocturna . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 45px">$ ' . $plan->pagoAdicional->vacaciones . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 50px">$ ' . $plan->pagoAdicional->indemnizacion . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 45px">$ ' . $plan->pagoAdicional->aguinaldo . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 50px">$ ' . number_format($total, 2) . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 45px">$ ' . number_format($total * 0.0725, 2) . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 40px">$ ' . (($total > 1000) ? '30.00' : number_format($total * 0.03, 2)) . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 50px">' . number_format($renta, 2) . '</td>
            <td style="border: 1px dashed gray; text-align: center; width: 60px">$ ' . number_format($totalPagar, 2) . '</td>
        </tr>';
        }

        $tablaPlanilla .= '
    <tr>
        <td colspan="13" style=" border: 1px solid black; text-align: center; font-size: 10px; font-weight: bold; height: 23px">Total a Pagar</td>
        <td colspan="1" style="border: 1px solid black; text-align: center; font-size: 10px; font-weight: bold;">$ ' . number_format($totalPlanilla, 2) . '</td>
    </tr>
    </tbody>
</table>';

        // Ahora escribimos la tabla en el PDF
        $pdf->writeHTML($tablaPlanilla, true, false, true, false, '');


        return response($pdf->Output('Planilla - ' . $periodo . '.pdf', 'S'))
            ->header('Content-Type', 'application/pdf');
    }

    function calcularRenta($sueldo)
    {
        // Calcular AFP (7.25%) y ISSS (3% o $30 máximo)
        $afp = $sueldo * 0.0725;
        $isss = $sueldo > 1000 ? 30 : $sueldo * 0.03;
        $deduccionTotal = $afp + $isss;

        // Ajuste del ingreso tras las deducciones
        $ingresoAjustado = $sueldo - $deduccionTotal;

        // Definimos los tramos de la tabla de renta
        $tramos = [
            ['desde' => 472.01, 'hasta' => 895.24, 'porcentaje' => 0.10, 'exceso' => 472.00, 'cuotaFija' => 17.67],
            ['desde' => 895.25, 'hasta' => 2038.10, 'porcentaje' => 0.20, 'exceso' => 895.24, 'cuotaFija' => 60.00],
            ['desde' => 2038.11, 'hasta' => INF, 'porcentaje' => 0.30, 'exceso' => 2038.10, 'cuotaFija' => 288.57],
        ];

        // Encontramos el tramo correspondiente y calculamos la renta
        foreach ($tramos as $tramo) {
            if ($ingresoAjustado >= $tramo['desde'] && $ingresoAjustado <= $tramo['hasta']) {
                // Exceso sobre el límite del tramo
                $exceso = $ingresoAjustado - $tramo['exceso'];
                // Aplicar el porcentaje sobre el exceso y sumar la cuota fija
                $renta = ($exceso * $tramo['porcentaje']) + $tramo['cuotaFija'];
                return $renta; // Redondeamos solo al final
            }
        }

        return 0;
    }

    public function empleadoPDF($periodo, $id)
    {

        $planilla = Planilla::with('pagoAdicional', 'observacion1', 'observacion2', 'empleado', 'empleador')->where('periodo', $periodo)->where('empleado_id', $id)->get();

        $pdf = new \TCPDF();
        $pdf->AddPage();
        $pdf->setMargins(15, 15, 15);

        $pdf->writeHTML('<h1>ANALISIS FINANCIERO, S.A DE C.V.</h1>', 0, 0, 0, 0, 'C');
        $pdf->writeHTML('<h2>Constancia de Empleado</h2>', 0, 0, 0, 0, 'C');
        $pdf->Cell(70, 5, 'Periodo: ' . $periodo, 0, 0, 'L');
        $pdf->Cell(110, 5, 'Fecha de generación: ' . date('Y-m-d'), 0, 0, 'R');
        $pdf->Ln(10);


        $pdf->Ln(5);

        foreach ($planilla as $plan) {

            $total = $plan->salario + $plan->pagoAdicional->monto_hora_diurna + $plan->pagoAdicional->monto_hora_nocturna + $plan->pagoAdicional->vacaciones + $plan->pagoAdicional->indemnizacion + $plan->pagoAdicional->aguinaldo;
            $renta = $this->calcularRenta($total);
            $totalPagar = $total - ($total * 0.0725) - (($total > 1000) ? 30  : $total * 0.03) - $renta;

            $html = '
            <h3 style="text-align: left;">Información del Empleado</h3>
            <table style="width: 100%; font-size: 12px; border-collapse: collapse; border: 1px dotted gray;">
            <tr>
                <td style="width: 35%; font-weight: bold; border: 1px dotted gray; height: 25px">Nombre:</td>
                <td style="border: 1px dotted gray;">' . $plan->empleado->nombre1 . ' ' . $plan->empleado->nombre2 . ' ' . $plan->empleado->apellido1 . ' ' . $plan->empleado->apellido2 . ' ' . $plan->empleado->apellido_casada . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Número de Documento:</td>
                <td style="border: 1px dotted gray;">' . $plan->empleado->numero_documento . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Salario:</td>
                <td style="border: 1px dotted gray;">$ ' . $plan->salario . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Horas Diurnas:</td>
                <td style="border: 1px dotted gray;">$ ' . $plan->pagoAdicional->monto_hora_diurna . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Horas Nocturnas:</td>
                <td style="border: 1px dotted gray;">$ ' . $plan->pagoAdicional->monto_hora_nocturna . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Vacaciones:</td>
                <td style="border: 1px dotted gray;">$ ' . $plan->pagoAdicional->vacaciones . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Indemnización:</td>
                <td style="border: 1px dotted gray;">$ ' . $plan->pagoAdicional->indemnizacion . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Aguinaldo:</td>
                <td style="border: 1px dotted gray;">$ ' . $plan->pagoAdicional->aguinaldo . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Total mensual:</td>
                <td style="border: 1px dotted gray;">$ ' . number_format($total, 2) . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">AFP Laboral:</td>
                <td style="border: 1px dotted gray;">$ ' . number_format($total * 0.0725, 2) . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">ISSS Laboral:</td>
                <td style="border: 1px dotted gray;">$ ' . (($total > 1000) ? '30.00' : number_format($total * 0.03, 2)) . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Renta:</td>
                <td style="border: 1px dotted gray;">$ ' . number_format($renta, 2) . '</td>
            </tr>
            <tr>
                <td style="font-weight: bold; border: 1px dotted gray; height: 25px">Total a Pagar:</td>
                <td style="border: 1px dotted gray;">$ ' . number_format($totalPagar, 2) . '</td>
            </tr>
            </table>
            ';

            $pdf->writeHTML($html, true, false, true, false, '');
        }

        $pdf->writeHTML('<br><br><h4>F_______________________________________________________</h4>', 0, 0, 0, 0, '');
        $pdf->writeHTML('<h4>ANALISIS FINANCIERO, S.A DE C.V.</h4>');
        $pdf->writeHTML('<br><br><br><br>');

        $pdf->writeHTML('<p>Nota: Estimado empleado, por este medio se hace de su conocimiento que la tasa de cotización
         al Sistema será del 7.25% por parte del trabajador, mientras que el aporte del Insituto Salvadoreño del Seguro Social (ISSS)
         será del 3% o $30.00 si su sueldo es mayor a $1,000.00, de igual forma, por sueldos mayores a 472.01 se hará su 
         retención de renta respectiva.
        </p>');

        return response($pdf->Output('Empleado - ' . $id . '.pdf', 'S'))
            ->header('Content-Type', 'application/pdf');
    }

    public function planillaExcel($periodo)
    {
        $planilla = Planilla::with('pagoAdicional', 'observacion1', 'observacion2', 'empleado', 'empleador')->where('periodo', $periodo)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Data
        $data = [];
  
        // Llenar datos
        foreach ($planilla as $plan) {
            $data[] = [
                $plan->empleador->numero_documento,               // Numero de documento del empleador
                $plan->empleador->numero_patronal,                // Numero Patronal Empleador
                $periodo,                                         // Periodo
                $plan->empleador->centro_trabajo,                 // Correlativo Centro de Trabajo
                $plan->empleado->numero_documento,                // Numero de Documento Afiliado
                $plan->empleado->tipoDocumento->codigo,           // Tipo de Documento Afiliado
                $plan->empleado->numero_afiliado,                 // Numero Patronal del afiliado
                $plan->empleado->institucion->codigo,             // Institución Previsional
                $plan->empleado->nombre1,                         // Primer Nombre
                $plan->empleado->nombre2,                         // Segundo Nombre
                $plan->empleado->apellido1,                       // Primer Apellido
                $plan->empleado->apellido2,                       // Segundo Apellido
                $plan->empleado->apellido_casada,                 // Apellido de Casada
                $plan->salario,                                   // Salario
                $plan->monto_pago_adicional,                      // Pago Adicional
                $plan->monto_vacaciones,                          // Monto de Vacacion
                str_pad($plan->dias, 2, '0', STR_PAD_LEFT),   // Dias
                str_pad($plan->horas, 2, '0', STR_PAD_LEFT),  // Horas
                str_pad($plan->dias_vacaciones, 2, '0', STR_PAD_LEFT), // Dias Vacacion
                $plan->observacion1->codigo,                      // Codigo de observacion 1
                $plan->observacion2->codigo === '01' ? '00' : $plan->observacion2->codigo      // Codigo de Observacion 2
            ];
        }
        
        $sheet->fromArray($data, null, 'A1');

        $fileName = 'Planilla - ' . $periodo . '.csv';

        $writer = new WriterCsv($spreadsheet);
        $writer->setUseBOM(true);
        $writer->setDelimiter(',');
        $writer->setEnclosure('');
        $writer->setLineEnding("\r\n");

        // Configurar la respuesta como descarga
        $response = Response::streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName);

       

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$fileName\"");

        return $response;
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
