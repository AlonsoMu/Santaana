<?php require_once './autorizacion.php'; ?>

<div class="container px-0 px-lg-4">
  <h1 class="text-center text-gray-900 py-3" style="font-family: 'Oleo Script', cursive;">Permiso de Estudiante</h1>

  <form action="" id="formulario-permiso" autocomplete="off" enctype="multipart/form-data">
    <div class="card shadow">
      <div class="card-header d-flex justify-content-between align-items-center py-3" style="flex-wrap: wrap; row-gap: 15px;">
        <h6 class="m-0 font-weight-bold text-primary">Datos de Alumna:</h6>
        <button type="button" class="btn btn-secondary" id="nuevopermiso">Nuevo</button>
      </div>

      <div class="card-body">
        <div class="form-group">
          <label for="numerodocumento">DNI/C.E.</label>
          <div class="input-group">
            <input type="number" maxlength="9" class="form-control bg-light" id="numerodocumento" placeholder="Número documento" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autofocus>
            <div class="input-group-append">
              <button class="btn btn-primary" type="button" id="buscarestudiante">
                Buscar
              </button>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-lg-6">
            <label for="apellidopaterno">Apellido paterno:</label>
            <input type="text" class="form-control border-0" id="apellidopaterno" readonly>
          </div>

          <div class="form-group col-lg-6">
            <label for="apellidomaterno">Apellido materno:</label>
            <input type="text" class="form-control border-0" id="apellidomaterno" readonly>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-lg-6">
            <label for="nomalucompleto">Nombre completo:</label>
            <input type="text" class="form-control border-0" id="nomalucompleto" readonly>
          </div>

          <div class="form-group col-lg-6">
            <label for="aulaestudiante">Grado y Sección:</label>
            <input type="text" class="form-control border-0" id="aulaestudiante" readonly>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-lg-6">
            <label for="motivo">Motivo:</label>
            <select name="" id="motivo" class="custom-select bg-light">
              <option value="" hidden disabled selected>Seleccione</option>
            </select>
          </div>

          <div class="form-group col-lg-6">
            <label for="evidencia">Evidencia (Opcional):</label>
            <input type="file" class="form-control-file" id="evidencia" accept="image/*">
          </div>
        </div>

        <div class="form-group">
          <label for="comentario">Comentario:</label>
          <textarea class="form-control bg-light" name="" id="comentario" cols="30" rows="4" placeholder=""></textarea>
        </div>

        <hr>

        <div class="form-group text-justify">
          <label><b class="text-gray-900">Compromisos y responsabilidades durante la ausencia:</b></label>
          <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="primero" checked>
            <label class="form-check-label" for="primero">
              La alumna se compromete a ponerse al día con las tareas y trabajos asignados durante su ausencia.
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="segundo" checked>
            <label class="form-check-label" for="segundo">
              La alumna es responsable de obtener cualquier material o información adicional que se haya proporcionado durante su ausencia.
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="tercero" checked>
            <label class="form-check-label" for="tercero">
              La alumna entiende que cualquier ausencia sin permiso adecuado puede resultar en sanciones disciplinarias.
            </label>
          </div>
        </div>

        <hr>

        <div class="form-group">
          <label for="responsable"><b class="text-gray-900">Responsable del permiso durante la ausencia:</b></label>
          <input type="text" id="responsable" class="form-control border-0" value="<?= $_SESSION['login']['nombres'] ?> <?= $_SESSION['login']['apepaterno'] ?> <?= $_SESSION['login']['apematerno'] ?>" readonly>
        </div>
      </div>

      <div class="card-footer">
        <div class="d-flex justify-content-center">
          <div class="col-lg-4 text-center p-0">
            <button type="button" class="btn btn-primary w-100" id="registrarpermiso">Registrar Permiso</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  const formulariopermiso = document.getElementById('formulario-permiso');
  const btnnuevopermisoal = document.getElementById('nuevopermiso');
  const txtnumerodocument = document.getElementById('numerodocumento');
  const btnbuscarestudian = document.getElementById('buscarestudiante');
  const txtapellidopatern = document.getElementById('apellidopaterno');
  const txtapellidomatern = document.getElementById('apellidomaterno');
  const txtnomalucompleto = document.getElementById('nomalucompleto');
  const txtaulaestudiante = document.getElementById('aulaestudiante');
  const selectmotivopermi = document.getElementById('motivo');
  const txtevidenciapermi = document.getElementById('evidencia');
  const txtcomentarioperm = document.getElementById('comentario');
  const btnregistrarpermi = document.getElementById('registrarpermiso');

  let idasistencia = -1;
  let nrodocumento = -1;

  function alertar(mensaje = '', icono = '') {
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
      icon: icono,
      title: mensaje
    });
  }

  function cargando() {
    let timerInterval
    Swal.fire({
      title: 'Permiso',
      iconHtml: '<img src="./img/logo-sa.svg" style="height:135px; margin: 20px 0">',
      html: '<p style="color:#229954">Su reporte se está generando...</p>',
      timer: 1500,
      timerProgressBar: true,
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {}, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {}
    })
  }

  function encontrar() {
    txtapellidopatern.classList.add('is-valid');
    txtapellidomatern.classList.add('is-valid');
    txtnomalucompleto.classList.add('is-valid');
    txtaulaestudiante.classList.add('is-valid');
  }

  function denegar() {
    txtapellidopatern.classList.remove('is-valid');
    txtapellidomatern.classList.remove('is-valid');
    txtnomalucompleto.classList.remove('is-valid');
    txtaulaestudiante.classList.remove('is-valid');
  }

  function listarMotivos() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listarMotivos');

    fetch('../controllers/permiso.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        datos.forEach(element => {

          const optionTag = document.createElement('option');
          optionTag.value = `${element.idmotivo}`;
          optionTag.text = `${element.descripcionmotivo}`;
          selectmotivopermi.appendChild(optionTag);

        });

      })
      .catch(e => {
        console.error(e);
      })
  }

  function verificarAsistencia() {
    if (txtnumerodocument.value.trim() == '') {

      alertar('Ingrese número de documento', 'info');
      formulariopermiso.reset();
      txtnumerodocument.focus();
      denegar();

    } else {

      const parametros = new URLSearchParams();
      parametros.append('op', 'verificarAsistencia');
      parametros.append('nrodocumento', txtnumerodocument.value);

      fetch('../controllers/alumna.php', {
          method: 'POST',
          body: parametros
        })
        .then(res => res.json())
        .then(datos => {

          if (!datos) {

            alertar('No ha registrado su asistencia o documento inválido', 'error');
            formulariopermiso.reset();
            txtnumerodocument.focus();
            denegar();

          } else {

            idasistencia = datos.idasistencia;
            nrodocumento = datos.nrodocumento
            txtapellidopatern.value = `${datos.apepaterno}`;
            txtapellidomatern.value = `${datos.apematerno}`;
            txtnomalucompleto.value = `${datos.nombres}`;
            txtaulaestudiante.value = `${datos.grado}° ${datos.seccion}`;

            txtnumerodocument.value = '';
            selectmotivopermi.focus();
            encontrar();

          }
        })
        .catch(e => {
          console.error(e);
        });
    }
  }

  function registrarPermiso() {

    const parametros = new FormData();
    parametros.append('op', 'registrar');
    parametros.append('idasistencia_fk', idasistencia);
    parametros.append('idmotivo_fk', selectmotivopermi.value);
    parametros.append('comentario', txtcomentarioperm.value);
    parametros.append('evidencia', txtevidenciapermi.files[0]);

    fetch('../controllers/permiso.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        if (datos.status == 'DENEGAR') {
          alertar('Ya se ha registrado un permiso anteriormente', 'error');
          formulariopermiso.reset();
          txtnumerodocument.focus();
          denegar();

        } else if (datos.status == 'PERMISO') {
          alertar('Registrado correctamente', 'success');
          generarPDFPermiso();

        }

      })
      .catch(e => {
        console.error(e);
      });
  }

  function generarPDFPermiso() {

    if (
      txtapellidopatern.value == '' ||
      txtapellidomatern.value == '' ||
      txtnomalucompleto.value == '' ||
      txtaulaestudiante.value == ''
    ) {
      alertar('Ingrese número de documento y pulse ENTER', 'info');
      txtnumerodocument.focus();
      denegar();

    } else if (selectmotivopermi.value == '') {
      alertar('Elija el motivo de permiso', 'info');
      selectmotivopermi.focus();

    } else if (txtcomentarioperm.value == '') {
      alertar('Escriba un comentario acerca del permiso', 'info');
      txtcomentarioperm.focus();

    } else {
      cargando();

      setTimeout(() => {
        const parametros = new URLSearchParams();
        parametros.append('idasistencia', idasistencia);
        parametros.append('nrodocumento', nrodocumento);
        parametros.append('apepaterno', txtapellidopatern.value);
        parametros.append('apematerno', txtapellidomatern.value);
        parametros.append('nombres', txtnomalucompleto.value);
        parametros.append('aula', txtaulaestudiante.value);

        window.open(`../reports/permisos/reporte.php?${parametros}`, `_blank`);
      }, 1500);

    }
  }

  btnnuevopermisoal.addEventListener('click', () => {
    formulariopermiso.reset();
    txtnumerodocument.focus();
    denegar();
  });

  btnbuscarestudian.addEventListener('click', verificarAsistencia);
  txtnumerodocument.addEventListener('keypress', (e) => {
    if (e.charCode == 13) verificarAsistencia();
  });

  btnregistrarpermi.addEventListener('click', () => {
    if (
      txtapellidopatern.value == '' ||
      txtapellidomatern.value == '' ||
      txtnomalucompleto.value == '' ||
      txtaulaestudiante.value == ''
    ) {
      alertar('Por favor complete el formulario', 'info');
      txtnumerodocument.focus();
      denegar();

    } else if (selectmotivopermi.value == '') {
      alertar('Elija el motivo de permiso', 'info');
      selectmotivopermi.focus();

    } else if (txtcomentarioperm.value == '') {
      alertar('Escriba un comentario acerca del permiso', 'info');
      txtcomentarioperm.focus();

    } else {

      Swal.fire({
        title: 'Permiso',
        text: '¿Desea registrar el permiso?',
        // icon: 'question',
        iconHtml: '<img src="./img/logo-sa.svg" style="height:135px; margin: 20px 0">',
        footer: 'SENATI - Ingeniería de Software',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {

        if (result.isConfirmed) {
          registrarPermiso();
        }

      });

    }

  });

  listarMotivos();
</script>