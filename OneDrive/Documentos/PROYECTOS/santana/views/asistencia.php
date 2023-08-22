<?php require_once './autorizacion.php'; ?>

<div class="container px-0 px-lg-4">
  <div class="text-primary shadow rounded text-center mb-3" style="font-family: 'Poppins', sans-serif; font-size: 40px;">
    <?= $_SESSION['obtenerTurno']['turno'] ?>
  </div>

  <div class="card shadow mb-3">
    <form action="" id="formulario-asistencias" autocomplete="off">
      <div class="card-header py-3">
        <div class="col-md-auto flex-grow-1 p-0">
          <label class="font-weight-bold text-primary m-0">Datos de Estudiante:</label>
        </div>
      </div>
      <div class="card-body">
        <div class="row justtify-content-center align-items-center" style="row-gap: 15px;">
          <div class="col-12 col-xl-6">
            <div class="form-group">
              <label for="nrodocumento">DNI/C.E.</label>
              <div class="input-group">
                <input type="number" maxlength="9" class="form-control bg-light border-0 small" id="nrodocumento" placeholder="Número documento" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autofocus>
                <div class="input-group-append">
                  <button class="btn btn-secondary" type="button" id="obtener">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="text-center mx-auto" style="height: 15rem; width: 15rem; border-radius: 50%; overflow-x: hidden;">
              <img class="py-3 h-100" src="./img/undraw_profile_3.svg" alt="foto" id="fotografia">
            </div>
          </div>

          <div class="col-12 col-xl-6">
            <div class="h-100 text-center" style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;">
              <h1 id="apellidos" style="color: #1C0B87; font-size: 45px;">APELLIDOS</h1>
              <h1 id="nombres" style="color: #ed1b24; font-size: 45px;">NOMBRES</h1>
              <h1 id="gradoseccion" class="text-info" style="font-size: 45px;">Grado y Sección</h1>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="row m-0 justify-content-center px-0">
    <div class="card shadow col-12 col-lg-8 col-xl-6 px-0">
      <div class="card-header py-3">
        <div class="input-group">
          <input type="text" class="form-control border-0 small" id="nombrebuscado" placeholder="Nombre a buscar">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button" id="buscarasistencia">
              Buscar
            </button>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive" style="height: 100%; overflow-y: hidden;">
          <table class="table table-sm table-borderless table-striped display responsive nowrap" id="tabla-asistencia" style="width: 100%; border: 0;">
            <thead>
              <tr class="text-primary">
                <th>Nombres</th>
                <th class="text-center">Entrada</th>
                <th class="text-center">Salida</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-asistencias" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alumnas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-striped table-sm m-0" width="100%" id="tabla-resultados">
            <thead class="table-dark">
              <tr>
                <th>N°</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th class="text-center">Grado</th>
                <th class="text-center">Sección</th>
                <th class="text-center">Hora de Ingreso</th>
              </tr>
            </thead>

            <tbody></tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  const formularioasist = document.getElementById('formulario-asistencias');
  const txtnrodocumento = document.getElementById('nrodocumento');
  const btnobtenerregis = document.getElementById('obtener');
  const imagefotografia = document.getElementById('fotografia');
  const tituloapellidos = document.getElementById('apellidos');
  const titulonombresal = document.getElementById('nombres');
  const titulogradosecc = document.getElementById('gradoseccion');
  const txtnombrebuscad = document.getElementById('nombrebuscado');
  const btnbuscarasiste = document.getElementById('buscarasistencia');
  const tbodyasistencia = document.querySelector('#tabla-asistencia tbody');
  const tbodyresultados = document.querySelector('#tabla-resultados tbody');

  const modal = new bootstrap.Modal(document.getElementById('modal-asistencias'));

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

  function obtenerAlumna() {
    if (txtnrodocumento.value.trim() == '') {
      alertar('Ingrese número de documento', 'info');
      reiniciarTitulos();

    } else {
      const parametros = new URLSearchParams();
      parametros.append('op', 'obtener');
      parametros.append('nrodocumento', txtnrodocumento.value);

      fetch('../controllers/alumna.php', {
          method: 'POST',
          body: parametros
        })
        .then(res => res.json())
        .then(datos => {
          let imagen = (datos.fotografia == null) ? 'sin-imagen.png' : (datos.fotografia);

          if (!datos) {
            alertar('Número de documento no válido', 'error');
            txtnrodocumento.value = '';
            reiniciarTitulos();

          } else {
            registrarAsistencia(datos.idmatricula);

            imagefotografia.src = `./img/alumnas/${imagen}`;
            tituloapellidos.innerHTML = `${datos.apepaterno} ${datos.apematerno}`;
            titulonombresal.innerHTML = `${datos.nombres}`;
            titulogradosecc.innerHTML = `${datos.grado}° ${datos.seccion}`;

            txtnrodocumento.value = '';
            txtnrodocumento.focus();
          }
        })
        .catch(e => {
          console.error(e);
        });
    }
  }

  function reiniciarTitulos() {
    imagefotografia.src = './img/alumnas/sin-imagen.png';
    tituloapellidos.innerHTML = 'APELLIDOS';
    titulonombresal.innerHTML = 'NOMBRES';
    titulogradosecc.innerHTML = 'Grado y Sección';
  }

  function registrarAsistencia(idmatricula) {
    const parametros = new URLSearchParams();
    parametros.append('op', 'registrarAsistencia');
    parametros.append('idmatricula', idmatricula);

    fetch('../controllers/alumna.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        if (datos.status == 'Ausente') {
          alertar('Turno incorrecto, verifica tu horario', 'error');
          reiniciarTitulos();

        } else if (datos.status == 'Entrada') {
          alertar('ENTRADA registrada correctamente', 'success');

        } else if (datos.status == 'Salida') {
          alertar('SALIDA registrada correctamente', 'success');

        } else if (datos.status == 'Verificar') {
          alertar('ENTRADA registrada anteriormente, vuelva a marcar a la hora de salida', 'error');
          reiniciarTitulos();
        }

        listarAsistencia();

      })
      .catch(e => {
        console.error(e);
      });
  }

  function listarAsistencia() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listarAsistencia');

    fetch('../controllers/alumna.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        let i = 0;
        tbodyasistencia.innerHTML = '';

        datos.forEach(element => {
          let horasalidaalu = (element.horasalidaalu == null) ? '' : (element.horasalidaalu);
          let colortextoalu = (datos[i].estado == 'Puntual') ? '#117A65' : '#ed1b24';

          const fila = `
            <tr>
              <td>${element.nombres}</td>
              <td class='text-center' style='color: ${colortextoalu}'>${element.horaentradaalu}</td>
              <td class='text-center'>${horasalidaalu}</td>
            </tr>
          `;

          tbodyasistencia.innerHTML += fila;
          i++;
        });
      })
      .catch(e => {
        console.error(e);
      });
  }

  function buscarAlumna() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'buscar');
    parametros.append('nombres', txtnombrebuscad.value);

    fetch('../controllers/alumna.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        if (datos.status == false) {
          alertar('No hay coincidencias de la alumna', 'error');
          txtnombrebuscad.focus();

        } else {

          let i = 1;
          modal.toggle();
          tbodyresultados.innerHTML = '';

          datos.forEach(element => {
            const fila = `
              <tr>
                <td>${i++}</td>
                <td>${element.apepaterno} ${element.apematerno}</td>
                <td>${element.nombres}</td>
                <td class='text-center'>${element.grado}</td>
                <td class='text-center'>${element.seccion}</td>
                <td class='text-center'>${element.horaentradaalu}</td>
              </tr>
            `;

            tbodyresultados.innerHTML += fila;
          });
        }
      })
      .catch(e => {
        console.error(e);
      });
  }

  listarAsistencia();

  formularioasist.addEventListener('submit', (e) => {
    e.preventDefault();
  });

  btnobtenerregis.addEventListener('click', () => {
    obtenerAlumna();
    txtnrodocumento.focus();
  });

  btnbuscarasiste.addEventListener('click', () => {
    if (txtnombrebuscad.value == '') {
      alertar('Ingrese un nombre para buscar', 'error');
      txtnombrebuscad.focus();

    } else if (txtnombrebuscad.value.length < 3) {
      alertar('Ingrese al menos 3 caracteres para buscar', 'info');
      txtnombrebuscad.value = '';
      txtnombrebuscad.focus();

    } else {
      buscarAlumna();
      txtnombrebuscad.value = '';
    }
  });

  txtnrodocumento.addEventListener('keypress', (e) => {
    if (e.charCode == 13) obtenerAlumna();
  });

  txtnombrebuscad.addEventListener('keypress', (e) => {
    if (e.charCode == 13) {

      if (txtnombrebuscad.value == '') {
        alertar('Ingrese un nombre para buscar', 'error');
        txtnombrebuscad.focus();

      } else if (txtnombrebuscad.value.length < 3) {
        alertar('Ingrese al menos 3 caracteres para buscar', 'info');
        txtnombrebuscad.value = '';
        txtnombrebuscad.focus();

      } else {
        buscarAlumna();
        txtnombrebuscad.value = '';
      }
    }
  });
</script>