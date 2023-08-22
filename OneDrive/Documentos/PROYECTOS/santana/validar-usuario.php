<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>I.E.E. SANTA ANA | Validar Datos Usuario</title>
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./views/assets/bootstrap-4.6.2/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./views/assets/fontawesome/css/all.css">
  <!--===============================================================================================-->
  <link rel="shortcut icon" href="./views/img/logo.svg" type="image/x-icon">
  <!--===============================================================================================-->
</head>

<body>
  <div class="d-flex vh-100 w-100 h-100 justify-content-center align-items-center m-0 p-0">
    <div class="bg-light d-flex col-xl-4 col-lg-5 col-md-6 justify-content-center align-items-center m-0 p-0">
      <div class="w-100 p-3 px-md-5" style="max-width: 450px;">
        <form class="w-100" action="" autocomplete="off">
          <div class="form-group text-center">
            <h1>Valide sus datos</h1>
            <hr>
          </div>
          <div class="form-group text-center">
            <img class="w-50" src="./views/img/logo-sa.svg" alt="logo">
            <hr>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label for="nombreusuario" class="form-label">Nombre de usuario:</label>
                <input type="text" class="form-control" id="nombreusuario" spellcheck="false" autofocus>
              </div>
              <div class="d-none" id="datos">
                <div class="form-group">
                  <label for="apellidos">Apellidos y Nombres:</label>
                  <input type="text" class="form-control" id="apellidos" readonly>
                </div>
                <div class="form-group">
                  <label for="correo">Correo Electrónico:</label>
                  <input type="text" class="form-control" id="correo" readonly>
                </div>
              </div>
              <div class="d-flex justify-content-center">
                <a href="./">Inicie sesión</a>
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end" style="flex-wrap: wrap; gap: 15px;">
              <button class="btn btn-secondary" type="button" id="reiniciar">Reiniciar</button>
              <button class="btn btn-primary" type="button" id="buscar">Buscar</button>
              <button class="btn btn-primary d-none" type="button" id="enviar">Enviar mensaje de recuperación</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modal-validacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="staticBackdropLabel">Validar clave</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-light">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" autocomplete="off" id="formulario-validarclave">
            <div class="form-group">
              <label for="claveCorreo">Escriba la clave:</label>
              <input type="text" style="font-size: 4em; font-weight: bold;" maxlength="4" class="form-control text-center" id="claveCorreo">
            </div>
            <div id="claves" class="d-none">
              <div class="form-group">
                <label for="clave1">Escribe tu nueva contraseña:</label>
                <input type="password" class="form-control" id="clave1">
              </div>
              <div class="form-group">
                <label for="clave2">Vuelva a ingresar su contraseña:</label>
                <input type="password" class="form-control" id="clave2">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="comprobar">Comprobar</button>
          <button type="button" class="btn btn-primary d-none" id="actualizar">Actualizar clave</button>
        </div>
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
      //Objetos
      const txtNombreUsuario = document.getElementById('nombreusuario');
      const btnReiniciar = document.getElementById('reiniciar');
      const btnBuscar = document.getElementById('buscar');
      const divDatosColaborador = document.getElementById('datos');
      const txtApellidos = document.getElementById('apellidos');
      const txtCorreoElectronico = document.getElementById('correo');
      const btnEnviarClave = document.getElementById('enviar');
      const txtClaveCorreo = document.getElementById('claveCorreo');
      const btnComprobar = document.getElementById('comprobar');
      const divClaves = document.getElementById('claves');
      const txtClave1 = document.getElementById('clave1');
      const txtClave2 = document.getElementById('clave2');
      const btnActualizar = document.getElementById('actualizar');


      //Variable para almacenar IDUSUARIO
      let idcolaborador = -1;

      //Objeto para manipular al MODAL
      const modal = new bootstrap.Modal(document.getElementById('modal-validacion'));

      function alertar(textoMensaje = '', icon = '') {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2500,
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

        btnEnviarClave.classList.add('d-none');
        btnReiniciar.classList.remove('d-none');
        btnBuscar.classList.remove('d-none');

        txtNombreUsuario.value = '';
        txtNombreUsuario.focus();
      }

      function alertaModal(textoMensaje = '', icon = '') {
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 2500,
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

      function buscador() {
        let parametros = new URLSearchParams();
        parametros.set('op', 'buscar');
        parametros.set('nombreusuario', txtNombreUsuario.value);
        fetch('./controllers/colaborador.php', {
            method: 'POST',
            body: parametros
          })
          .then(res => res.text())
          .then(datos => {
            if (datos != '') {
              divDatosColaborador.classList.remove('d-none');
              txtNombreUsuario.classList.remove('is-invalid');
              txtNombreUsuario.classList.add('is-valid');
              btnEnviarClave.classList.remove('d-none');
              btnReiniciar.classList.add('d-none');
              btnBuscar.classList.add('d-none');
              const registro = JSON.parse(datos);
              //Enviando datos a formulario
              idcolaborador = `${registro.idcolaborador}`;
              txtApellidos.value = `${registro.apepaterno} ${registro.apematerno}, ${registro.nombres}`;
              txtCorreoElectronico.value = registro.email;
            } else {
              if (txtNombreUsuario.value.trim() == '') {
                txtNombreUsuario.classList.remove('is-valid');
                txtNombreUsuario.classList.add('is-invalid');
                divDatosColaborador.classList.add('d-none');
                alertar('Nombre de usuario no puede estar vacío ni contener espacios', 'error');
              } else {
                idcolaborador = -1;
                txtNombreUsuario.classList.add('is-invalid');
                divDatosColaborador.classList.add('d-none');
                txtApellidos.value = '';
                txtCorreoElectronico.value = '';
                alertar('Nombre de usuario no encontrado', 'error');
              }
            }
          });
      }

      function generarEnviarCodigo() {
        const parametros = new URLSearchParams();
        parametros.append('op', 'enviarCorreo');
        parametros.append('idcolaborador_fk', idcolaborador);
        parametros.append('email', txtCorreoElectronico.value);

        fetch('./controllers/colaborador.php', {
            method: 'POST',
            body: parametros
          })
          .then(res => res.text())
          .then(datos => {
            document.getElementById('formulario-validarclave').reset();
            alertaModal('Verifica tu correo por favor', 'info');
            txtClaveCorreo.removeAttribute('readonly', '');
            divClaves.classList.add('d-none');
          })
      }

      function validarClave() {
        const parametros = new URLSearchParams();
        parametros.append('op', 'validarClave');
        parametros.append('idcolaborador_fk', idcolaborador);
        parametros.append('clavegenerada', txtClaveCorreo.value);

        fetch('./controllers/colaborador.php', {
            method: 'POST',
            body: parametros

          })
          .then(res => res.json())
          .then(datos => {
            // console.log(datos);
            //Analizando los datos
            if (txtClaveCorreo.value.trim() == '') {
              alertaModal('Campo obligatorio', 'info');
              txtClaveCorreo.focus();
            } else {
              if (datos.status == 'PERMITIDO') {
                txtClaveCorreo.setAttribute('readonly', '');
                divClaves.classList.remove('d-none');
                btnComprobar.classList.add('d-none');
                btnActualizar.classList.remove('d-none');
                txtClave1.focus();
              } else {
                alertaModal('Clave incorrecta, revise su correo por favor', 'error');
                txtClaveCorreo.value = '';
                txtClaveCorreo.focus();
              }
            }
          });
      }

      function actualizarClave() {
        //Si ninguna caja esta vacia
        if (txtClave1.value.trim() == '') {
          alertaModal('Las contraseña no puede estar vacía ni contener espacios', 'error');
          txtClave1.value = '';
          txtClave1.focus();
          // modal.togle();
        } else if (txtClave2.value.trim() == '') {
          alertaModal('Las contraseña no puede estar vacía ni contener espacios', 'error');
          txtClave2.value = '';
          txtClave2.focus();
        } else {
          if (txtClave1.value != '' && txtClave2.value != '') {
            if (txtClave1.value == txtClave2.value) {
              const parametros = new URLSearchParams();
              parametros.append('op', 'actualizarClave');
              parametros.append('idcolaborador', idcolaborador);
              parametros.append('claveacceso', txtClave1.value);
              fetch('./controllers/colaborador.php', {
                  method: 'POST',
                  body: parametros
                })
                .then(res => res.json())
                .then(datos => {
                  console.log(datos);
                  alertaModal('Se actualizó su clave. Vuelva a inicar sesión', 'success');

                  setTimeout(() => {
                    window.location.href = './';
                  }, 2500);
                });
              modal.toggle();
            } else {
              alertaModal('Las contraseñas no coinciden', 'error');
              txtClave2.value = '';
              txtClave2.focus();
            }
          }
        }


      }

      $('#modal-validacion').on('shown.bs.modal', function() {
        $('#claveCorreo').trigger('focus');
      });

      //Evento click para botón
      btnReiniciar.addEventListener('click', () => {
        txtNombreUsuario.focus();
        txtNombreUsuario.classList.remove('is-invalid');
        txtNombreUsuario.classList.remove('is-valid');
      });

      btnBuscar.addEventListener('click', buscador);

      btnEnviarClave.addEventListener('click', () => {
        if (idcolaborador != -1) {
          generarEnviarCodigo();
          modal.toggle();
        } else {
          alertar('Ingrese nombre de usuario');
        }
      });

      btnComprobar.addEventListener('click', validarClave);

      btnActualizar.addEventListener('click', () => {
        actualizarClave();
      });

      //Evento ENTER teclado
      txtNombreUsuario.addEventListener('keypress', (key) => {
        if (key.keyCode == 13) buscador()
      });

      txtClaveCorreo.addEventListener('keypress', (key) => {
        if (key.keyCode == 13) validarClave()
      });

      txtClave1.addEventListener('keypress', (key) => {
        if (key.keyCode == 13) actualizarClave();
      });

      txtClave2.addEventListener('keypress', (key) => {
        if (key.keyCode == 13) actualizarClave();
      });
    });
  </script>

</body>

</html>