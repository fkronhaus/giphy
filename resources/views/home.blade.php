<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido a Giphy API</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Giphy API</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- Aquí puedes agregar otros elementos de menú si es necesario -->
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <!-- Aquí puedes mostrar el nombre del usuario logueado -->
        <span class="nav-link" id="loggedUser" user_id=""></span>
      </li>
      <li class="nav-item">
        <!-- Menú para salir -->
        <a class="nav-link" role="button" id="web-logout" >Salir</a>
      </li>
    </ul>
  </div>
</nav>
<div id="login" class="container mt-4 d-none" >
    <div class="row justify-content-center align-items-center">
        <div class="col-6">
            <h4>Ingresa tus credenciales para acceder a los servicios de la API</h4>
        </div>
    </div>

    <div class="row justify-content-center align-items-center mt-4" >

        <div class="col-3 text-center">
            <div id="errorMessage" class="alert alert-warning d-none" role="alert"> </div>
            <div class="form-group">
                <input type="text" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" id="password" required>
            </div>
            <button type="button" id="web-login" class="btn btn-primary">Iniciar Sesión</button>

            
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
@include('giphy/find')
</div>
@include('modal');

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function setCookie(name,value,minutes) {
        var expires = "";
        if (minutes) {
            var date = new Date();
            date.setTime(date.getTime() + (minutes*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value  + expires + "; path=/";
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
    
    function removeCookie(){
        document.cookie = "giphyToken=; expires=Thu, 18 Dec 2013 12:00:00 UTC; path=/";
    }

    function showErrorMessage(message) {
        $('#errorMessage').text(message).removeClass('d-none');
    }

    
    function hideErrorMessage() {
        $('#errorMessage').addClass('d-none');
    }

    function showLogin(){
        
        $('#login').removeClass('d-none');
        $('#navbar').addClass('d-none');
        $('#search').addClass('d-none');
    }

    function showSearch(){
        $('#login').addClass('d-none');
        $('#navbar').removeClass('d-none');
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
        $("#loggedUser").html(getCookie('username'));
        $("#loggedUser").attr('user_id', getCookie('user_id'));

        <?php if (isset($_GET["expired"]) && $_GET["expired"]){ ?>
            showErrorMessage('Expiró la sesion, ingrese nuevamente');
        <?php } ?>

        $('#google-login').click(function() {
            window.location.href = '/google-login';
        });

        $('#web-login').click(function() {
            
            var email = $('#email').val();
            var password = $('#password').val();
            hideErrorMessage();
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: '{{route("authenticate")}}', 
                method: 'POST', 
                data: { 
                    email: email,
                    password: password,
                },
                success: function(response) {
                    setCookie('giphyToken',response.token, {{env('TOKEN_EXPIRATION_TIME')}});
                    setCookie('username', response.username, {{env('TOKEN_EXPIRATION_TIME')}});
                    setCookie('user_id', response.user_id, {{env('TOKEN_EXPIRATION_TIME')}});
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
                url: '{{route("logout")}}', 
                method: 'POST', 
                success: function(response) {
                    removeCookie();
                    window.location.href = '/';
                },
                error: function(xhr, status, error) {
                if (xhr.status == 419){
                    console.log("Session expirada");
                    window.location.href = '/?expired=1';
                }else{
                    var errorMessage = xhr.responseJSON.message || 'Ha ocurrido un error.';
                    showErrorMessage(errorMessage);
                }
                }
            });
        });

        showLoginOrSearch();
    });
</script>
</body>
</html>
