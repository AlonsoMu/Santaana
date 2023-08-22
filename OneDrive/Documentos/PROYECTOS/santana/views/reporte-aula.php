<?php require_once './autorizacion.php'; ?>

<div class="container px-0 px-lg-4">
  <h1 class="text-center text-gray-900 pt-3" style="font-family: 'Oleo Script', cursive;">Aula</h1>
  <form action="" id="formulario-aula" autocomplete="off">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Asistencia</button>
        <!-- <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Fecha</button> -->
        <div class="flex-grow-1 d-flex justify-content-end">
          <button class="btn btn-secondary" type="reset" id="reiniciar-aula">Nuevo</button>
        </div>
      </div>
    </nav>

    <div class="card">
      <div class="card-header">
        <div class="row" style="row-gap: 15px;">
          <div class="col-md-6">
            <label for="gradoaula">Grado:</label>
            <select name="" id="gradoaula" class="custom-select" autofocus>
              <option value="" hidden disabled selected>Seleccione:</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="seccionaula">Seccion:</label>
            <select name="" id="seccionaula" class="custom-select">
              <option value="" hidden disabled selected>Seleccione:</option>
            </select>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <div class="d-flex justify-content-center m-0">
              <div class="col-lg-4 text-center p-0">
                <button class="btn btn-primary w-100" type="button" id="generarreporte">Generar Reporte</button>
              </div>
            </div>

            <hr>

            <div class="table-responsive">
              <table class="table table-striped table-borderless table-sm" id="tabla-asiaula">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th class="text-center">Entrada</th>
                    <th class="text-center">Salida</th>
                    <th class="text-center">Estado</th>
                  </tr>
                </thead>

                <tbody></tbody>
              </table>
            </div>
          </div>

          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="desdeaula">Desde:</label>
                <input type="date" class="form-control bg-light border-0" id="desdeaula">
              </div>

              <div class="form-group col-md-6">
                <label for="hastaaula">Hasta:</label>
                <input type="date" class="form-control bg-light border-0" id="hastaaula">
              </div>
            </div>

            <hr>

            <div class="d-flex justify-content-center m-0">
              <div class="col-lg-4 text-center p-0">
                <button class="btn btn-primary w-100" type="button" id="generarpdfaula">Generar Reporte</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  const btnasistalumna = document.getElementById('nav-home-tab');
  const selectgradoaul = document.getElementById('gradoaula');
  const selectseccaula = document.getElementById('seccionaula');
  const btnreiniciaula = document.getElementById('reiniciar-aula');
  const formularioaula = document.getElementById('formulario-aula');
  const tbodyasistaula = document.querySelector('#tabla-asiaula tbody');

  const inputdesdeaula = document.getElementById('desdeaula');
  const inputhastaaula = document.getElementById('hastaaula');

  const btngenerarrepo = document.getElementById('generarreporte');
  const btngenepdfaula = document.getElementById('generarpdfaula');


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

  function cargando(titulo = '') {
    let timerInterval
    Swal.fire({
      title: titulo,
      iconHtml: '<img src="./img/logo-sa.svg" style="height:135px; margin: 20px 0">',
      html: '<p style="color:#229954">Su reporte se está generando...</p>',
      timer: 1500,
      timerProgressBar: true,
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          // b.textContent = Swal.getTimerLeft()
        }, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {}
    })
  }

  /* <---------------- DIARIA ----------------> */
  function listarGrado() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listar');

    fetch('../controllers/grado.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        selectgradoaul.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';

        datos.forEach(element => {
          const optionTag = document.createElement('option');
          optionTag.value = element.grado;
          optionTag.text = `${element.grado}°`;
          selectgradoaul.appendChild(optionTag);
        });

      })
      .catch(e => {
        console.error(e);
      });
  }

  function listarSeccion() {

    const parametros = new URLSearchParams();
    parametros.append('op', 'listar');
    parametros.append('grado', selectgradoaul.value);

    fetch('../controllers/seccion.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        selectseccaula.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';

        datos.forEach(element => {
          const optionTag = document.createElement('option');
          optionTag.value = element.seccion;
          optionTag.text = element.seccion;

          selectseccaula.appendChild(optionTag);
        });

      })
      .catch(e => {
        console.error(e);
      })
  }

  function obtenerAsistenciaDiaria() {

    const parametros = new URLSearchParams();
    parametros.append('op', 'obtenerAsistenciaDiaria');
    parametros.append('grado', selectgradoaul.value);
    parametros.append('seccion', selectseccaula.value);

    fetch('../controllers/aula.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        let i = 1;
        tbodyasistaula.innerHTML = '';

        datos.forEach(element => {
          let horaentradaalu = (element.horaentradaalu == null) ? '' : element.horaentradaalu;
          let horasalidaalu = (element.horasalidaalu == null) ? '' : element.horasalidaalu;
          let fecharegistro = (element.fecharegistro == null) ? '' : element.fecharegistro;

          const fila = `
            <tr>
              <td>${i}</td>
              <td>${element.apepaterno} ${element.apematerno}</td>
              <td>${element.nombres}</td>
              <td class='text-center'>${horaentradaalu}</td>
              <td class='text-center'>${horasalidaalu}</td>
              <td class='text-center'>${element.estado}</td>
            </tr>
          `;

          tbodyasistaula.innerHTML += fila;
          i++;
        });

      })
      .catch(e => {
        console.error(e);
      });
  }

  function generarPDF() {
    if (selectgradoaul.value == '') {
      alertar('Elija un grado', 'error');
      tbodyasistaula.innerHTML = '';
      selectgradoaul.focus();

    } else if (selectseccaula.value == '') {
      alertar('Elija una sección', 'error');
      tbodyasistaula.innerHTML = '';
      selectseccaula.focus();

    } else {

      cargando('Asistencia');

      setTimeout(() => {

        const parametros = new URLSearchParams();
        parametros.append('grado', selectgradoaul.value);
        parametros.append('seccion', selectseccaula.value);
        parametros.append('titulo', selectgradoaul.value + '° ' + selectseccaula.value);

        window.open(`../reports/aula/reporte.php?${parametros}`, `_blank`);

      }, 1500);

    }
  }


  /* <---------------- PERSONALIZADA ----------------> */
  function generarPDFAula() {
    if (selectgradoaul.value == '') {
      alertar('Elija un grado', 'error');
      tbodyasistaula.innerHTML = '';
      selectgradoaul.focus();

    } else if (selectseccaula.value == '') {
      alertar('Elija una sección', 'error');
      tbodyasistaula.innerHTML = '';
      selectseccaula.focus();

    } else {

      if (inputdesdeaula.value == '') {
        alertar('Elija una fecha de inicio', 'error');
        inputdesdeaula.focus();

      } else if (inputhastaaula.value == '') {
        alertar('Elija una fecha de término', 'error');
        inputhastaaula.focus();

      } else {

        const parametros = new URLSearchParams();
        parametros.append('grado', selectgradoaul.value);
        parametros.append('seccion', selectseccaula.value);
        parametros.append('desde', inputdesdeaula.value);
        parametros.append('hasta', inputhastaaula.value);
        parametros.append('titulo', selectgradoaul.value + '° ' + selectseccaula.value);

        window.open(`../reports/aula/reporte-fechas.php?${parametros}`, `_blank`);

      }

    }
  }


  selectgradoaul.addEventListener('change', () => {
    selectseccaula.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';
    tbodyasistaula.innerHTML = '';
    listarSeccion();
  });

  selectseccaula.addEventListener('change', obtenerAsistenciaDiaria);

  btnreiniciaula.addEventListener('click', () => {
    selectseccaula.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';
    tbodyasistaula.innerHTML = '';
    formularioaula.reset();
    selectgradoaul.focus();
  })

  btnasistalumna.addEventListener('click', () => {
    selectgradoaul.focus();
  });

  btngenerarrepo.addEventListener('click', generarPDF);

  listarGrado();
</script>