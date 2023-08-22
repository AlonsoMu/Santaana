<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login']) {
  header('Location:./views/home.php');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>I.E.E. SANTA ANA | Iniciar Sesión</title>
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./views/assets/bootstrap-4.6.2/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./views/assets/fontawesome/css/all.css">
  <!--===============================================================================================-->
  <link rel="shortcut icon" href="./views/img/logo.svg" type="image/x-icon">
  <!--===============================================================================================-->
</head>

<body>
  <div class="row vh-100 w-100 h-100 m-0 p-0">
    <div class="h-100 d-none d-md-flex h-100 col-xl-8 col-lg-7 col-md-6 justify-content-center align-items-center m-0 p-0" style="background: center / cover no-repeat url('./views/img/fondo.png');"></div>

    <div class="bg-light d-flex h-100 col-xl-4 col-lg-5 col-md-6 justify-content-center align-items-center m-0 p-0">
      <div class="w-100 px-3 px-md-5" style="max-width: 450px;">
        <form class="w-100" action="" autocomplete="off">
          <div class="form-group text-center">
            <img class="" src="./views/img/logo-sa.svg" alt="logo" style="width: 60%;"><br>
          </div>
          <div class="form-group">
            <label for="nombreusuario">Nombre de usuario:</label>
            <input type="text" class="form-control" id="nombreusuario" spellcheck="false" autofocus>
          </div>
          <div class="form-group">
            <div class="d-flex flex-wrap m-0 justify-content-between">
              <label for="claveacceso">Contraseña:</label>
              <a href="./validar-usuario.php" style="outline: none;"><small>¿Olvidaste tu contraseña?</small></a>
            </div>
            <input type="password" class="form-control" id="claveacceso" spellcheck="false">
          </div>
          <div class="form-group">
            <div>
              <label for="manhana">Turno:</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="turno" id="manhana" value="M" checked>
              <label class="form-check-label" for="manhana">Mañana</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="turno" id="tarde" value="T">
              <label class="form-check-label" for="tarde">Tarde</label>
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary w-100" type="button" id="iniciarsesion">Iniciar sesión</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--===============================================================================================-->
  <script src="./views/assets/bootstrap-4.6.2/js/jquery.slim.min.js"></script>
  <!--===============================================================================================-->
  <script src="./views/assets/bootstrap-4.6.2/js/bootstrap.bundle.min.js"></script>
  <!--===============================================================================================-->
  <script src="./views/assets/bootstrap-4.6.2/js/popper.min.js"></script>
  <!--===============================================================================================-->
  <script src="./views/assets/bootstrap-4.6.2/js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="./views/assets/sweetalert2/sweetalert2.js"></script>
  <!--===============================================================================================-->

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const txtNombreUsuario = document.getElementById('nombreusuario');
      const txtClaveAcceso = document.getElementById('claveacceso');
      const manhana = document.getElementById('manhana');
      const tarde = document.getElementById('tarde');
      const btnIniciarSesion = document.getElementById('iniciarsesion');

      function alertar(textoMensaje = '', icon = '') {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });

        Toast.fire({
          icon: icon,
          title: textoMensaje
        });
      }

      function validarDatos() {
        const parametros = new URLSearchParams();
        parametros.append('op', 'login')
        parametros.append('nombreusuario', txtNombreUsuario.value)
        parametros.append('claveingresada', txtClaveAcceso.value)

        fetch('./controllers/colaborador.php', {
            method: 'POST',
            body: parametros
          })
          .then(res => res.json())
          .then(datos => {
            if (!datos.status) {
              if (txtNombreUsuario.value.trim() === '') {
                alertar('Nombre de usuario no puede estar vacío ni contener espacios', 'error');
                txtNombreUsuario.focus();
              } else {
                alertar(datos.mensaje, 'error');
              }
            } else {
              obtenerTurno();

              Swal.fire({
                icon: 'success',
                title: 'I.E.E. SANTA ANA',
                iconHtml: '<img src="./views/img/logo-sa.svg" style="height:135px; margin: 20px 0">',
                html: `<p style="color:#229954">Hola ${datos.nombres}, Bienvenido al sistema...</p>`,
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false
              });

              setTimeout(function() {
                window.location.href = './views/home.php';
              }, 1500);
            }
          })
          .catch(e => {
            console.error(e);
          });
      }

      function obtenerTurno() {
        let turno = manhana.checked ? 'M' : 'T';
        const parametros = new URLSearchParams();
        parametros.append('op', 'obtener');
        parametros.append('turno', turno);

        fetch('./controllers/turno.php', {
            method: 'POST',
            body: parametros
          })
          .then(res => res.json())
          .then(datos => {
            if (!datos.status) {
              console.log(!datos.status);
            }
          })
          .catch(e => {
            console.error(e);
          });
      }

      txtNombreUsuario.addEventListener('keypress', (evt) => {
        if (evt.charCode == 13) validarDatos()
      });

      txtClaveAcceso.addEventListener('keypress', (evt) => {
        if (evt.charCode == 13) validarDatos()
      });

      manhana.addEventListener('keypress', (evt) => {
        if (evt.charCode == 13) validarDatos()
      });

      tarde.addEventListener('keypress', (evt) => {
        if (evt.charCode == 13) validarDatos()
      });

      btnIniciarSesion.addEventListener('click', validarDatos);
    });
  </script>

</body>

</html>