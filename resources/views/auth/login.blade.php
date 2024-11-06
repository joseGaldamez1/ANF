<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO ANF</title>

    <!-- para Bootstrap y estilos personalizados -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @vite(['resources/css/custom/login.css', 'resources/js/app.js'])

    <!-- para jQuery y Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.login-info-box').fadeOut();
            $('.login-show').addClass('show-log-panel');

            $('.login-reg-panel input[type="radio"]').on('change', function() {
                if ($('#log-login-show').is(':checked')) {
                    $('.register-info-box').fadeOut();
                    $('.login-info-box').fadeIn();

                    $('.white-panel').addClass('right-log');
                    $('.register-show').addClass('show-log-panel');
                    $('.login-show').removeClass('show-log-panel');
                } else if ($('#log-reg-show').is(':checked')) {
                    $('.register-info-box').fadeIn();
                    $('.login-info-box').fadeOut();

                    $('.white-panel').removeClass('right-log');

                    $('.login-show').addClass('show-log-panel');
                    $('.register-show').removeClass('show-log-panel');
                }
            });
        });
    </script>
</head>

<body>
    <div class="login-reg-panel">
        <div class="login-info-box">
            <label id="label-register" for="log-reg-show">Iniciar sesión</label>
            <input type="radio" name="active-log-panel" id="log-reg-show" checked="checked">
        </div>

        <div class="register-info-box">
            <h2>Bienvenidos al proyecto de ANF</h2>
            <label id="label-login" for="log-login-show">Ver integrantes</label>
            <input type="radio" name="active-log-panel" id="log-login-show">
        </div>

        <div class="white-panel">
            <div class="login-show">
                <h2>INICIAR SESIÓN</h2>
                <input type="text" id="identity" placeholder="Usuario o correo electrónico">
                <input type="password" id="password" placeholder="Password">
                <input type="button" value="Login" onclick="handleLogin()">
            </div>
            <div class="register-show">
                <h2>Universidad de El Salvador</h2>
                <h2>Análisis Financiero</h2>
                <h3>Licda. Xiomara Vasquez</h3>
                <hr></hr>
                <ul>
                <li><h3>Luis Merino Quintanilla</h3></li>
                <li><h3>José Alfonso Galdámez</h3></li>
                <li><h3>Gabriela Stefani Miranda </h3></li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function handleLogin() {
            const identity = $('#identity').val();
            const password = $('#password').val();

            $.ajax({
                url: '/api/auth/signin',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    identity,
                    password
                }),
                success: function(data) {
                    localStorage.setItem('access_token', data.access_token);
                    window.location.href = '/menu';
                },
                error: function(err) {
                    alert('Acceso incorrecto.');
                }
            });
        }
    </script>
</body>

</html>
