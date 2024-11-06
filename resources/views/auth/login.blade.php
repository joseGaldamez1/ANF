<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROYECTO ANF</title>

    <!-- CSS Bootstrap and Custom Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Your CSS styles here */
        @import url('https://fonts.googleapis.com/css?family=Mukta');

        body {
            font-family: 'Mukta', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #335066 !important;
            margin: 0;
            overflow-y: hidden;
        }

        .login-reg-panel {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            width: 70%;
            margin: auto;
            height: 400px;
            background-color: rgba(244, 244, 214, 1);
        }

        .white-panel {
            background-color: rgba(255, 255, 255, 1);
            height: 500px;
            position: absolute;
            top: -50px;
            width: 50%;
            right: calc(50% - 50px);
            transition: .3s ease-in-out;
            z-index: 0;
            box-shadow: 0 0 15px 9px #00000096;
        }

        .right-log {
            right: 50px !important;
        }

        .login-info-box,
        .register-info-box {
            width: 30%;
            padding: 0 50px;
            top: 20%;
            position: absolute;
            text-align: left;
        }

        .login-info-box {
            left: 0;
        }

        .register-info-box {
            right: 0;
        }

        .login-show,
        .register-show {
            z-index: 1;
            display: none;
            opacity: 0;
            transition: 0.3s ease-in-out;
            color: #242424;
            text-align: left;
            padding: 50px;
        }

        .show-log-panel {
            display: block;
            opacity: 0.9;
        }

        .login-show input,
        .register-show input {
            width: 100%;
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #b5b5b5;
            outline: none;
        }

        .login-show input[type="button"],
        .register-show input[type="button"] {
            max-width: 150px;
            width: 100%;
            background: #444444;
            color: #f9f9f9;
            border: none;
            padding: 10px;
            text-transform: uppercase;
            border-radius: 2px;
            cursor: pointer;
        }

        .credit {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: #3B3B25;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
            z-index: 99;
        }
    </style>

    <!-- jQuery and Bootstrap JavaScript -->
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
                    window.location.href = '/home';
                },
                error: function(err) {
                    alert('El inicio de sesión falló. Pida a Alfonso que revise que sucede.');
                }
            });
        }
    </script>
</body>

</html>