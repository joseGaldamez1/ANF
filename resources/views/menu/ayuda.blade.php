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
    <p>https://www.pisto.co/liquidacion-laboral-en-el-salvador/</p>
    <p>https://www.toptrabajos.com/blog/sv/calcular-vacaciones-de-ley/?</p>
</section>

</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkMenu").checked = true;
    });
</script>
