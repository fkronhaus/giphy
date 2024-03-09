<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido a Giphy API</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div id="login" class="container mt-4 d-none" >
    <div class="row justify-content-center align-items-center">
        <div class="col-6">
            <h4>Ingresa tus credenciales para acceder a los servicios de la API</h4>
        </div>
    </div>

    <div class="row justify-content-center align-items-center mt-4" >

        <div class="col-3 text-center">
            <div id="errorMessage" class="alert alert-primary d-none" role="alert"></div>
            <div class="form-group">
                <input type="text" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" id="password" required>
            </div>
            <button type="button" id="web-login" class="btn btn-primary">Iniciar Sesión</button>
            <button type="button" id="web-logout" class="btn btn-primary">Cerrar Sesión</button>

            
        </div>
    </div>
    
    <div class="row justify-content-center align-items-center">
        <div class="col-3 text-center">
            <hr>
            <button id="google-login" type="button" class="btn btn-primary">Acceder con google</button>
        </div>
    </div>
</div>
<div id="search" class="d-none">
 Buscar
</div>




<!-- Agregar script de Bootstrap al final del cuerpo del documento para un mejor rendimiento -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function setCookie(value,minutes) {
        var expires = "";
        if (minutes) {
            var date = new Date();
            date.setTime(date.getTime() + (minutes*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = "giphyToken=" + (value)  + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }


    function showErrorMessage(message) {
        $('#errorMessage').text(message).removeClass('d-none');
    }

    
    function hideErrorMessage() {
        $('#errorMessage').addClass('d-none');
    }

    function showLogin(){
        $('#login').removeClass('d-none');
        $('#search').addClass('d-none');
    }

    function showSearch(){
        $('#login').addClass('d-none');
        $('#search').removeClass('d-none');
    }

    function showLoginOrSearch(){
        if (getCookie('giphyToken') != null){
            showSearch();
        }else{
            showLogin();
        }
    }

    $(document).ready(function() {

        showLoginOrSearch();

        $('#google-login').click(function() {
            window.location.href = '/google-login';
        });

        $('#web-login').click(function() {
            
            var email = $('#email').val();
            var password = $('#password').val();
            hideErrorMessage();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route("authenticate")}}', 
                method: 'POST', 
                data: { 
                    email: email,
                    password: password,
                    
                },
                success: function(response) {
                    setCookie(response.token,30);
                    window.location.href = '/';
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON.message || 'Ha ocurrido un error.';
                    console.error('Error:', errorMessage);
                    showErrorMessage(errorMessage);
                }
            });
        });

        $('#web-logout').click(function() {
            
            $.ajax({
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer {{ $token }}');
                },
                url: '{{route("logout")}}', 
                method: 'POST', 
                success: function(response) {
                    window.location.href = '/';
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON.message || 'Ha ocurrido un error.';
                    console.error('Error:', errorMessage);
                    showErrorMessage(errorMessage);
                }
            });
        });
    });
</script>
</body>
</html>
