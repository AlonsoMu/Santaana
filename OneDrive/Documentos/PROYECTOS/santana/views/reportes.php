<?php require_once './autorizacion.php'; ?>

<div class="container px-0 px-lg-4">
  <h1 class="text-center mb-3">Reportes</h1>

  <div class="d-flex justify-content-center" style="gap: 15px;">
    <div class="mb-3">
      <button class="btn btn-danger btn-sm" id="generarPDF">
        <i class="fa-solid fa-file-pdf"></i><span> PDF</span>
      </button>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4 col-12 mb-3">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="h-100 row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Turno:
              </div>
              <div class="m-0">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="turno" id="manhana" value="M" checked>
                  <label class="form-check-label" for="manhana">Mañana</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="turno" id="tarde" value="T">
                  <label class="form-check-label" for="tarde">Tarde</label>
                </div>
              </div>
            </div>
            <div class="col-auto d-none d-xl-block">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-8 col-12 mb-3">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="h-100 row no-gutters align-items-center" style="gap: 15px; flex-wrap: nowrap;">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                Grado y Sección:
              </div>
              <div class="row h5 mb-0 font-weight-bold text-gray-800" style="row-gap: 15px; flex-wrap: wrap;">
                <!-- $40,000 -->
                <div class="col-md-auto col-sm-6 col-12 flex-grow-1">
                  <select class="custom-select" id="grado" autofocus>
                    <!-- <option hidden disabled selected>Grado</option> -->
                  </select>
                </div>
                <div class="col-md-auto col-sm-6 col-12 flex-grow-1">
                  <select class="custom-select" id="seccion">
                    <option hidden disabled selected>Sección</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-auto d-none d-xl-block">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="table-responsive mt-3">
    <table class="table table-striped table-sm" id="tabla-reportes">
      <thead class="table-dark">
        <tr>
          <th>N°</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Nombres</th>
          <th>Hora Ingreso</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<script>
  const btnGenerarPDF = document.getElementById('generarPDF');
  const btnGenerarExcel = document.getElementById('generarExcel');
  const manhana = document.getElementById('manhana');
  const tarde = document.getElementById('tarde');
  let turno = document.getElementsByName('turno');
  const selectGrado = document.getElementById('grado');
  const selectSeccion = document.getElementById('seccion');
  const cuerpoTabla = document.querySelector('#tabla-reportes tbody');

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

  function listarGrado() {
    let turnoSeleccionado = '';
    turno.forEach(radio => {
      if (radio.checked) {
        turnoSeleccionado = radio.value
      }
    });

    const parametros = new URLSearchParams();
    parametros.append('op', 'listar');
    parametros.append('turno', turnoSeleccionado);

    fetch('../controllers/grado.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        selectGrado.innerHTML = '<option hidden disabled selected>Grado:</option>';
        datos.forEach(element => {
          const optionTag = document.createElement('option');
          optionTag.value = `${element.grado}`;
          optionTag.text = `${element.grado}°`;
          selectGrado.appendChild(optionTag);
        });

      })
  }

  function listarSeccion() {
    let turnoSeleccionado = '';
    turno.forEach(radio => {
      if (radio.checked) {
        turnoSeleccionado = radio.value
      }
    });

    const parametros = new URLSearchParams();
    parametros.append('op', 'listar');
    parametros.append('turno', turnoSeleccionado);
    parametros.append('grado', selectGrado.value);

    fetch('../controllers/seccion.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        let i = 1;
        selectSeccion.innerHTML = '<option hidden disabled selected>Sección:</option>';
        datos.forEach(element => {
          const optionTag = document.createElement('option');
          optionTag.value = `${i++}`;
          optionTag.text = `${element.seccion}`;
          selectSeccion.appendChild(optionTag);
        });
      })
  }

  function listarPorAula() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listarPorAula');
    parametros.append('grado', selectGrado.value);
    parametros.append('seccion', selectSeccion.options[selectSeccion.selectedIndex].text);

    fetch('../controllers/alumna.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        cuerpoTabla.innerHTML = '';
        let i = 1;
        datos.forEach(element => {
          let hora = (datos[i-1].horaentradaalu == null) ? '' : datos[i-1].horaentradaalu;
          const tableRow = `
            <tr>
              <td>${i++}</td>
              <td>${element.apepaterno}</td>
              <td>${element.apematerno}</td>
              <td>${element.nombres}</td>
              <td>${hora}</td>
            </tr>
          `;

          cuerpoTabla.innerHTML += tableRow;
        });
      })
  }

  function generarReportePDF() {
    if (selectGrado.value > 0) {
      if (selectSeccion.value > 0) {
        const parametros = new URLSearchParams();
        parametros.append('grado', selectGrado.value);
        parametros.append('seccion', selectSeccion.options[selectSeccion.selectedIndex].text);
        parametros.append('titulo', selectGrado.value + '° ' + selectSeccion.options[selectSeccion.selectedIndex].text);

        window.open(`../reports/asistencia/reporte.php?${parametros}`, `_blank`);
      } else {
        alertar('Elija una sección', 'error');
      }
    } else {
      alertar('Elija un grado', 'error');
    }
  }

  selectGrado.addEventListener('change', () => {
    selectSeccion.innerHTML = '';
    cuerpoTabla.innerHTML = '';
    listarSeccion();
  });

  selectSeccion.addEventListener('change', listarPorAula);

  manhana.addEventListener('click', () => {
    selectSeccion.innerHTML = '<option hidden disabled selected>Sección:</option>';
    cuerpoTabla.innerHTML = '';
    listarGrado();
  });

  tarde.addEventListener('click', () => {
    selectSeccion.innerHTML = '<option hidden disabled selected>Sección:</option>';
    cuerpoTabla.innerHTML = '';
    listarGrado();
  });

  btnGenerarPDF.addEventListener('click', generarReportePDF);

  listarGrado();
</script>