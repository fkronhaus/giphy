<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido a Giphy API</title>
    <!-- Agregar enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<div class="container mt-4" style="">
    <div class="row justify-content-center align-items-center">
        <div class="col-6">
            <h4>Ingresa tus credenciales para acceder a los servicios de la API</h4>
        </div>
    </div>

    <div class="row justify-content-center align-items-center mt-4" >

        <div class="col-3 text-center">
            
            <form id="loginForm" action="{{route('login')}}" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
                <button type="button" id="loginButton" class="btn btn-primary">Iniciar Sesión</button>
            </form>
        </div>
    </div>
    
    <div class="row justify-content-center align-items-center">
        <div class="col-3 text-center">
            <hr>
            <button id="google-login" type="button" class="btn btn-primary">Acceder con google</button>
        </div>
    </div>
</div>


<!-- Agregar script de Bootstrap al final del cuerpo del documento para un mejor rendimiento -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    
    
    $(document).ready(function() {
        $('#google-login').click(function() {
            window.location.href = '/google-login';
        });
    });
</script>
</body>
</html>
