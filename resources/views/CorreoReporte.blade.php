<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            line-height: 1.5;
            color: #666;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Pago</h1>
        <p>Estimado/a {{ $nombre }},</p>
        <p>Por este medio se adjunta el reporte de la planilla correspondiente al periodo: <strong>{{ $periodo }}</strong>.</p>
        <p>Si tienes alguna pregunta, no dudes en ponerte en contacto.</p>
        <p>Saludos cordiales,</p>
        <p>Gerente de Recursos Humanos</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} ANALISIS FINANCIERO.</p>
        <P>ESTE CORREO FUE GENERADO AUTOMATICAMENTE POR EL SISTEMA DE PLANILLAS - ANF115</P>
        </div>
    </div>
</body>
</html>
