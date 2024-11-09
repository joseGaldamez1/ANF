{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/custom/menu.css']) 
</head>
<body>

<!-- Checkbox y botón para abrir/cerrar el menú -->
<input type="checkbox" name="checkMenu" id="checkMenu">
<label for="checkMenu" class="labelBotonMenu">
    <i class="fa fa-navicon" id="btnMostrar"></i>
</label>

<!-- Barra lateral -->
<section class="sidebar">
    <header>
        <div class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="logo2">
        </div>
        <div class="titulo">Análisis financiero</div>

    </header>
    <ul>
        <li><a href="/inicio"><i class="fa fa-home"></i>Inicio</a></li>
        <li><a href="/puestosTrabajo"><i class="fa fa-shopping-bag"></i>Puestos de trabajo</a></li>
        <li><a href="/empleados"><i class="fa fa-calendar"></i>Empleados</a></li>
        <li><a href="/planilla"><i class="fa fa-link"></i>Planilla</a></li>
        <li><a href="/reportes"><i class="fa fa-cog"></i>Reportes</a></li>
        <li><a href="/ayuda"><i class="fa fa-question-circle-o"></i>Ayuda</a></li>      
    </ul>
</section>
<?php
/*<style>
    .fondoMenu {
        background-image: url('@php echo asset("img/fondoMenu.jpg"); @endphp');
        background-size: cover;
    }
</style>*/
?>

<section class="container fondoMenu">
    <!-- Contenido principal aquí -->
    <h1 style="text-align: center">Ayuda</h1>
    <img style="width: 10%; display: block; margin: 0 auto;" src="{{ asset('img/ayuda.png') }}" alt="logoEmpresa">
    <p style="text-align: center; ">
        En esta sección encontrará información útil para el uso del sistema de gestión de planillas.
    </p><br>
    <p style="text-align: center;">
      <strong>¿Como calcular la Renta?</strong><br>
    </p>
    <p style="text-align: center; font-size: 13px">
      Para el calculo del Impuesto de la renta se tienen 3 tramos de ingresos, los cuales se encuentran en la Ley de Impuesto sobre la Renta <br>
    </p>
    <img style="width: 45%; display: block; margin: 0 auto;" src="{{ asset('img/renta.png')}}" alt="tramoRenta">
    <div style="text-align: center;">
        <a href="https://elsalvador.eregulations.org/media/Ley%20de%20Impuesto%20sobre%20la%20Renta_1.pdf" target="_blank">Leer más aquí</a>
    </div><br>
    
    <p style="text-align: center;">
        <strong>¿Como calcular el aguinaldo?</strong><br>
    </p>
    <p style="text-align: center; font-size: 13px">
        El aguinaldo es un beneficio que se otorga a los empleados en el mes de diciembre, el cual se calcula de la siguiente manera:<br>
        <ol style="font-size: 13px; text-align: center">
            <li>- Si el empleado ha trabajado menos de un año, se le otorga un salario proporcional a los días trabajados.</li>
            <li>- Si el empleado ha trabajado todo el año, se le otorga un salario equivalente a 15 días de trabajo.</li>
            <li>- Si el empleado lleva entre 3 y años, se le otorga el salario equivalente a 19 dias de trabajo</li>
            <li> - Si el empleado lleva mas de 10 años, se le otorga el salario equivalente a 21 dias de trabjo</li>
        </ol>
        <div style="text-align: center;">
            <a href="https://ormusa.org/wp-content/uploads/2019/10/C%C3%93DIGO-DE-TRABAJO..pdf" target="_blank">Leer más aquí</a>
        </div><br>
    </p>    

</section>

</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkMenu").checked = true;
    });
</script>
