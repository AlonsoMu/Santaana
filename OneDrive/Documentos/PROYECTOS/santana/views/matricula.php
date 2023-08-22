<?php require_once './autorizacion.php'; ?>

<div class="container px-0 px-lg-4">
  <h1 class="text-center text-gray-900 pt-3" style="font-family: 'Oleo Script', cursive;">Estudiantes</h1>

  <form action="" id="formulario-matricula" autocomplete="off">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist" style="row-gap: 10px;">
        <button class="nav-link active" id="nav-registro-tab" data-toggle="tab" data-target="#nav-registro" type="button" role="tab" aria-controls="nav-registro" aria-selected="true">Registro</button>
        <button class="nav-link" id="nav-info-tab" data-toggle="tab" data-target="#nav-info" type="button" role="tab" aria-controls="nav-info" aria-selected="false">Información</button>

        <div class="flex-grow-1 d-flex justify-content-end py-1" style="gap: 10px;">
          <a href="https://www.cognex.com/resources/interactive-tools/free-barcode-generator" class="btn btn-primary" target="_blank">Codigo Barras</a>
          <button class="btn btn-secondary" type="reset" id="reiniciar">Nuevo</button>
        </div>
      </div>
    </nav>

    <div class="card">
      <div class="card-header">
        <div class="row" style="row-gap: 15px;">
          <div class="col-md-6">
            <label for="grado">Grado:</label>
            <select name="" id="grado" class="custom-select" autofocus>
              <option value="" hidden disabled selected>Seleccione:</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="seccion">Sección:</label>
            <select name="" id="seccion" class="custom-select">
              <option value="" hidden disabled selected>Seleccione:</option>
            </select>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="tab-content" id="nav-tabContent">
          <!----------------- MATRÍCULA ----------------->
          <div class="tab-pane fade show active" id="nav-registro" role="tabpanel" aria-labelledby="nav-home-tab">
            <!-- <form action="" id="formulario-matricula" autocomplete="off"> -->
            <div class="row">
              <div class="form-group col-lg-6">
                <label for="apepaterno">Apellido paterno:</label>
                <input type="text" class="form-control bg-light" id="apepaterno" style="text-transform: uppercase;">
              </div>
              <div class="form-group col-lg-6">
                <label for="apematerno">Apellido materno:</label>
                <input type="text" class="form-control bg-light" id="apematerno" style="text-transform: uppercase;">
              </div>
            </div>

            <div class="form-group">
              <label for="nombrecompleto">Nombre completo:</label>
              <input type="text" class="form-control bg-light" placeholder="" id="nombrecompleto" style="text-transform: capitalize;">
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="fechanac">Fecha nacimiento:</label>
                <input type="date" class="form-control bg-light" id="fechanac">
              </div>

              <div class="form-group col-md-6">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control bg-light" id="telefono" maxlength="9" placeholder="Opcional">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label for="tipodocumento">Tipo de documento:</label>
                <select name="" id="tipodocumento" class="custom-select bg-light">
                  <option value="D" selected>DNI</option>
                  <option value="C">Carnet de Extranjería</option>
                  <option value="P">Pasaporte</option>
                  <option value="V">VISA</option>
                  <option value="T">Otro</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="numdocumento">Número documento:</label>
                <input type="number" class="form-control bg-light small" maxlength="9" id="numdocumento" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
              </div>
            </div>

            <div class="row">
              <div class="form-group col-xl-6">
                <label for="ubigeos">Ubigeo:</label>
                <select name="" id="ubigeos" class="custom-select bg-light"></select>
              </div>

              <div class="form-group col-xl-6">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control bg-light" placeholder="Opcional" id="direccion" style="text-transform: capitalize;">
              </div>
            </div>

            <hr>
            <div class="d-flex justify-content-center">
              <div class="col-lg-4 text-center p-0">
                <button class="btn btn-primary w-100" type="button" id="matricular">Matricular</button>
              </div>
            </div>
          </div>
          <!------------- FIN DE MATRÍCULA -------------->


          <!---------------- INFORMACIÓN ---------------->
          <div class="tab-pane fade" id="nav-info" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="table-responsive">
              <table class="table table-striped table-borderless table-sm" id="tabla-informacion">
                <thead>
                  <tr>
                    <th>N°</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th class="text-center">Fotografía</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>

                <tbody></tbody>
              </table>
            </div>
          </div>
          <!------------- FIN DE INFORMACIÓN ------------>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-informacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="staticBackdropLabel">I.E.E. SANTA ANA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-light">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="apecompleto">Apellidos:</label>
          <input type="text" class="form-control" id="apecompleto" readonly>
        </div>
        <div class="form-group">
          <label for="nombrescomp">Nombres:</label>
          <input type="text" class="form-control" id="nombrescomp" readonly>
        </div>
        <div class="form-group">
          <label for="aula">Grado y Sección:</label>
          <input type="text" class="form-control" id="aula" readonly>
        </div>
        <div class="form-group">
          <label for="foto">Fotografía:</label>
          <input type="file" class="form-control-file" id="foto" accept="image/*">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelarfoto">
          <i class="fa-solid fa-thumbs-down"></i> Cancelar
        </button>
        <button type="button" class="btn btn-primary" id="guardar">
          <i class="fa-solid fa-floppy-disk"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  const btnasisalumna = document.getElementById('nav-registro-tab');
  const btninfoalumna = document.getElementById('nav-info-tab');
  const txtapepaterno = document.getElementById('apepaterno');
  const txtapematerno = document.getElementById('apematerno');
  const txtnombrecomp = document.getElementById('nombrecompleto');
  const txtfechanacim = document.getElementById('fechanac');
  const txttelefonoal = document.getElementById('telefono');
  const selecttipodoc = document.getElementById('tipodocumento');
  const txtnrodocumen = document.getElementById('numdocumento');
  const selectubigeos = document.getElementById('ubigeos');
  const txtdireccalum = document.getElementById('direccion');
  const selectgradoal = document.getElementById('grado');
  const selectseccion = document.getElementById('seccion');
  const btnmatricular = document.getElementById('matricular');
  const btnreiniciarf = document.getElementById('reiniciar');
  const formmatricula = document.getElementById('formulario-matricula');

  const modalapecompl = document.getElementById('apecompleto');
  const modalnomcompl = document.getElementById('nombrescomp');
  const modalaulaalum = document.getElementById('aula');
  const modalfotoalum = document.getElementById('foto');
  const btncancelainf = document.getElementById('cancelarfoto');
  const btnguardarinf = document.getElementById('guardar');
  const tbodyinformac = document.querySelector('#tabla-informacion tbody');

  let idpersona = '';

  const modal = new bootstrap.Modal(document.getElementById('modal-informacion'));

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


  /* <---------------- MATRÍCULA ----------------> */
  function listarUbigeos() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listar');

    fetch('../controllers/ubigeo.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        datos.forEach(element => {
          const optionTag = document.createElement('option');
          optionTag.value = element.idubigeo;
          optionTag.text = `${element.codubigeo} - ${element.departamento}, ${element.provincia}, ${element.distrito}`;

          selectubigeos.appendChild(optionTag);
        });
      })
      .catch(e => {
        console.error(e);
      });
  }

  function listarGrado() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listar');

    fetch('../controllers/grado.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        selectgradoal.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';

        datos.forEach(element => {
          const optionTag = document.createElement('option');
          optionTag.value = element.grado;
          optionTag.text = `${element.grado}°`;
          selectgradoal.appendChild(optionTag);
        });
      })
      .catch(e => {
        console.error(e);
      });
  }

  function listarSeccion() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listar');
    parametros.append('grado', selectgradoal.value);

    fetch('../controllers/seccion.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        selectseccion.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';

        datos.forEach(element => {
          const optionTag = document.createElement('option');
          optionTag.value = element.seccion;
          optionTag.text = element.seccion;

          selectseccion.appendChild(optionTag);
        });
      })
      .catch(e => {
        console.error(e);
      });
  }

  function matricularAlumna(idgrupo) {

    const parametros = new URLSearchParams();
    parametros.append('op', 'matricular');
    parametros.append('idubigeo_fk', selectubigeos.value);
    parametros.append('tipodocumento', selecttipodoc.value);
    parametros.append('nrodocumento', txtnrodocumen.value);
    parametros.append('fechanac', txtfechanacim.value);
    parametros.append('apepaterno', txtapepaterno.value);
    parametros.append('apematerno', txtapematerno.value);
    parametros.append('nombres', txtnombrecomp.value);
    parametros.append('direccion', txtdireccalum.value);
    parametros.append('telefono', txttelefonoal.value);
    parametros.append('idgrupo_fk', idgrupo);

    fetch('../controllers/alumna.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {

        if (datos === 23000) {
          alertar('El número de documento ya está registrado en el sistema', 'error');
          txtnrodocumen.value = '';
          txtnrodocumen.focus();

        } else {

          selectseccion.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';
          alertar('Registrado correctamente', 'success');
          formmatricula.reset();

        }
      })
      .catch(e => {
        console.error(e);
      });
  }


  /* <---------------- INFORMACIÓN ----------------> */
  function listarPorAula() {
    const parametros = new URLSearchParams();
    parametros.append('op', 'listarPorAula');
    parametros.append('grado', selectgradoal.value);
    parametros.append('seccion', selectseccion.value);

    fetch('../controllers/alumna.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        let i = 1;
        tbodyinformac.innerHTML = '';

        datos.forEach(element => {
          let imagen = (element.fotografia == null) ? 'sin-imagen.png' : (element.fotografia);

          const fila = `
          <tr>
            <td>${i++}</td>
            <td>${element.apepaterno} ${element.apematerno}</td>
            <td>${element.nombres}</td>
            <td class='text-center'>
              <a href='img/alumnas/${imagen}' class='ver' data-idpersona='${element.idpersona}' data-lightbox='demo' data-title='' title='${element.nombres}'>
                <i class="fa-solid fa-eye px-4 py-1" style='color:#1c294e'></i>
              </a>
            </td>
            <td class='text-center'>
              <a href='#' class='editar' data-idpersona='${element.idpersona}' title='Subir fotografía'>
                subir foto
              </a>
            </td>
          </tr>
        `;

          tbodyinformac.innerHTML += fila;
        });
      })
      .catch(e => {
        console.error(e);
      });
  }

  tbodyinformac.addEventListener('click', (e) => {

    if (e.target.classList[0] === 'editar') {
      idpersona = parseInt(e.target.dataset.idpersona);

      const parametros = new URLSearchParams();
      parametros.append('op', 'obtenerInfo');
      parametros.append('idpersona', idpersona);

      fetch('../controllers/alumna.php', {
          method: 'POST',
          body: parametros
        })
        .then(res => res.json())
        .then(datos => {

          let imagen = (datos.fotografia == null) ? 'sin-imagen.png' : (datos.fotografia);

          modalapecompl.value = `${datos.apepaterno} ${datos.apematerno}`;
          modalnomcompl.value = datos.nombres;
          modalaulaalum.value = `${datos.grado}° ${datos.seccion}`;
          modalfotoalum.src = `./img/alumnas/${datos.fotografia}`;

          modal.toggle();
        })
        .catch(e => {
          console.error(e);
        });
    }
  });

  function actualizarFotografia() {

    const parametros = new FormData();
    parametros.append('op', 'actualizarFotografia');
    parametros.append('idpersona', idpersona);
    parametros.append('imagen', modalfotoalum.files[0]);

    fetch('../controllers/alumna.php', {
        method: 'POST',
        body: parametros
      })
      .then(res => res.json())
      .then(datos => {
        if (datos) {
          alertar('Guardado correctamente', 'success');
          modal.toggle();
        }

        listarPorAula();
      })
      .catch(e => {
        console.error(e);
      });
  }


  formmatricula.addEventListener('submit', (e) => {
    e.preventDefault();
  });

  btnasisalumna.addEventListener('click', () => {
    selectgradoal.focus();
  });

  btninfoalumna.addEventListener('click', () => {
    selectgradoal.focus();
  });


  /* <---------------- LLAMADAS Y EVENTOS MATRÍCULA ----------------> */
  listarUbigeos();
  listarGrado();
  selectgradoal.addEventListener('change', () => {
    selectseccion.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';
    tbodyinformac.innerHTML = '';
    listarSeccion();
  });

  btnreiniciarf.addEventListener('click', () => {
    selectseccion.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';
    tbodyinformac.innerHTML = '';
    selectgradoal.focus();
  });

  btnmatricular.addEventListener('click', () => {
    if (selectgradoal.value === '') {
      alertar('Elija un grado por favor', 'info');
      selectgradoal.focus();

    } else if (selectseccion.value === '') {
      alertar('Elija una sección por favor', 'info');
      selectseccion.focus();

    } else if (txtapepaterno.value.trim() === '') {
      alertar('Por favor, ingrese apellido paterno de la estudiante', 'info');
      txtapepaterno.value = '';
      txtapepaterno.focus();

    } else if (txtapematerno.value.trim() === '') {
      alertar('Por favor, ingrese apellido materno de la estudiante', 'info');
      txtapematerno.value = '';
      txtapematerno.focus();

    } else if (txtnombrecomp.value.trim() === '') {
      alertar('Por favor, ingrese nombre completo de la estudiante', 'info');
      txtnombrecomp.value = '';
      txtnombrecomp.focus();

    } else if (txtfechanacim.value === '') {
      alertar('Por favor, ingrese fecha nacimiento de la estudiante', 'info');
      txtfechanacim.focus();

    } else if (selecttipodoc.value === '') {
      alertar('Por favor, elija tipo de documento de la estudiante', 'info');
      selecttipodoc.focus();

    } else if (txtnrodocumen.value.trim() === '') {
      alertar('Por favor, ingrese numero documento de la estudiante', 'info');
      txtnrodocumen.value = '';
      txtnrodocumen.focus();

    } else if (selectubigeos.value === '') {
      alertar('Por favor, ingrese ubigeo', 'info');
      selectubigeos.focus();

    } else {

      const parametros = new URLSearchParams();
      parametros.append('op', 'obtener');
      parametros.append('grado', selectgradoal.value);
      parametros.append('seccion', selectseccion.value);

      fetch('../controllers/aula.php', {
          method: 'POST',
          body: parametros
        })
        .then(res => res.json())
        .then(datos => {

          Swal.fire({
            title: 'Estudiante',
            text: '¿Desea guardar los datos?',
            iconHtml: '<img src="./img/logo-sa.svg" style="height:135px; margin: 20px 0">',
            footer: 'I.E.E. Santa Ana',
            confirmButtonText: 'Aceptar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {

            if (result.isConfirmed) {

              selectseccion.innerHTML = '<option value="" hidden disabled selected>Seleccione:</option>';
              matricularAlumna(datos.idgrupo);
              tbodyinformac.innerHTML = '';

            }
          });

        })
        .catch(e => {
          console.error(e);
        });

    }
  });

  txtapepaterno.addEventListener('keypress', (e) => {
    if (e.charCode == 13) txtapematerno.focus();
  });

  txtapematerno.addEventListener('keypress', (e) => {
    if (e.charCode == 13) txtnombrecomp.focus();
  });

  txtnombrecomp.addEventListener('keypress', (e) => {
    if (e.charCode == 13) txtfechanacim.focus();
  });

  txtfechanacim.addEventListener('keypress', (e) => {
    if (e.charCode == 13) txttelefonoal.focus();
  });

  txttelefonoal.addEventListener('keypress', (e) => {
    if (e.charCode == 13) txtnrodocumen.focus();
  });


  /* <---------------- LLAMADAS Y EVENTOS INFORMACIÓN ----------------> */
  selectseccion.addEventListener('change', listarPorAula);
  btnguardarinf.addEventListener('click', () => {
    if (!modalfotoalum.files.length) {
      alertar('Por favor, seleccione una fotografía', 'error');
      return;

    } else if (modalfotoalum.files.length) {

      Swal.fire({
        title: 'Estudiante',
        text: '¿Desea guardar la fotografía?',
        iconHtml: '<img src="./img/logo-sa.svg" style="height:135px; margin: 20px 0">',
        footer: 'I.E.E. Santa Ana',
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {

        if (result.isConfirmed) {
          actualizarFotografia();
          modalfotoalum.value = '';
        }
      });

    }

  });

  btncancelainf.addEventListener('click', () => {
    modalfotoalum.value = '';
  });
</script>