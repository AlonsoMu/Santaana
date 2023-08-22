<?php require_once './autorizacion.php'; ?>

<div class="container px-0 px-lg-4">
  <h1 class="text-center text-gray-900 pt-3" style="font-family: 'Oleo Script', cursive;">Estudiante</h1>
  <form action="" id="formulario-estudiante" autocomplete="off">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist" style="row-gap: 10px;">
        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Asistencias</button>
        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Permisos</button>

        <div class="flex-grow-1 d-flex justify-content-end">
          <button class="btn btn-secondary" type="reset" id="reiniciar-formulario">Nuevo</button>
        </div>
      </div>
    </nav>

    <div class="card">
      <div class="card-body">
        <div class="tab-content" id="nav-tabContent">
          <div class="row">
            <div class="col-12 form-group">
              <label for="numerodoc">DNI/C.E.:</label>
              <div class="input-group">
                <input type="number" class="form-control bg-light" maxlength="9" placeholder="Número de documento" id="numerodoc" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" autofocus>
                <div class="input-group-append">
                  <button class="btn btn-primary" type="button" id="buscarnumerodoc">Buscar</button>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-lg-6">
              <label for="apellidopat">Apellido paterno:</label>
              <input type="text" class="form-control border-0" id="apellidopat" readonly>
            </div>

            <div class="form-group col-lg-6">
              <label for="apellidomat">Apellido materno:</label>
              <input type="text" class="form-control border-0" id="apellidomat" readonly>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-lg-6">
              <label for="nomcompleto">Nombres:</label>
              <input type="text" class="form-control border-0" id="nomcompleto" readonly>
            </div>

            <div class="form-group col-lg-6">
              <label for="aulaalumna">Grado y Sección:</label>
              <input type="text" class="form-control border-0" id="aulaalumna" readonly>
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="desdealumna">Desde:</label>
              <input type="date" class="form-control bg-light" id="desdealumna">
            </div>

            <div class="form-group col-md-6">
              <label for="hastaalumna">Hasta:</label>
              <input type="date" class="form-control bg-light" id="hastaalumna">
            </div>
          </div>

          <hr>

          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="d-flex justify-content-center">
              <div class="col-lg-4 text-center p-0">
                <button class="btn btn-primary w-100" type="button" id="generarpdf">Generar Reporte</button>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="d-flex justify-content-center">
              <div class="col-lg-4 text-center p-0">
                <button class="btn btn-primary w-100" type="button" id="generarpdfpermiso">Generar Reporte</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </form>
</div>

<script>
  const btnasialumna = document.getElementById('nav-home-tab');
  const btnperalumna = document.getElementById('nav-profile-tab');
  const txtnumerodoc = document.getElementById('numerodoc');
  const btnbuscardoc = document.getElementById('buscarnumerodoc');
  const txtapellidop = document.getElementById('apellidopat');
  const txtapellidom = document.getElementById('apellidomat');
  const txtnomcomple = document.getElementById('nomcompleto');
  const txtaulaalumn = document.getElementById('aulaalumna');
  const txtdesdealum = document.getElementById('desdealumna');
  const txthastaalum = document.getElementById('hastaalumna');
  const formulalumna = document.getElementById('formulario-estudiante');
  const btnreiniciar = document.getElementById('reiniciar-formulario');
  // const tbodyasisalu = document.querySelector('#tabla-asialumna tbody');
  const btngenerapdf = document.getElementById('generarpdf');
  const btnpdfpermis = document.getElementById('generarpdfpermiso');

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

  function encontrar() {
    txtapellidop.classList.add('is-valid');
    txtapellidom.classList.add('is-valid');
    txtnomcomple.classList.add('is-valid');
    txtaulaalumn.classList.add('is-valid');
  }

  function denegar() {
    txtapellidop.classList.remove('is-valid');
    txtapellidom.classList.remove('is-valid');
    txtnomcomple.classList.remove('is-valid');
    txtaulaalumn.classList.remove('is-valid');
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
        timerInterval = setInterval(() => {}, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.timer) {}
    })
  }


  /* <---------------- ASISTENCIA ----------------> */
  function obtenerAlumna() {
    if (txtnumerodoc.value.trim() == '') {
      alertar('Ingrese número de documento', 'info');
      formulalumna.reset();
      denegar();

    } else {
      const parametros = new URLSearchParams();
      parametros.append('op', 'obtener');
      parametros.append('nrodocumento', txtnumerodoc.value);

      fetch('../controllers/alumna.php', {
          method: 'POST',
          body: parametros
        })
        .then(res => res.json())
        .then(datos => {

          if (!datos) {

            alertar('Número de documento no válido', 'error');
            formulalumna.reset();
            denegar();

          } else {
            txtapellidop.value = `${datos.apepaterno}`;
            txtapellidom.value = `${datos.apematerno}`;
            txtnomcomple.value = `${datos.nombres}`;
            txtaulaalumn.value = `${datos.grado}° ${datos.seccion}`;

            encontrar();

            nrodocumento = datos.nrodocumento;

            txtnumerodoc.value = '';
            txtdesdealum.value = '';
            txthastaalum.value = '';
            txtnumerodoc.focus();
            txtdesdealum.focus();
          }
        })
        .catch(e => {
          console.error(e);
        });
    }
  }

  function generarPDF() {
    if (txtapellidop.value == '' || txtapellidom.value == '' || txtnomcomple.value == '' || txtaulaalumn.value == '') {
      alertar('Ingrese número de documento y pulse ENTER', 'info');
      txtnumerodoc.focus();

    } else if (txtdesdealum.value == '') {
      alertar('Elija fecha de inicio', 'info');
      txtdesdealum.focus();

    } else if (txthastaalum.value == '') {
      alertar('Elija fecha de término', 'info');
      txthastaalum.focus();

    } else {

      cargando('Asistencia');

      setTimeout(() => {

        const parametros = new URLSearchParams();
        parametros.append('nrodocumento', nrodocumento);
        parametros.append('desde', txtdesdealum.value);
        parametros.append('hasta', txthastaalum.value);
        parametros.append('apepaterno', txtapellidop.value);
        parametros.append('apematerno', txtapellidom.value);
        parametros.append('nombres', txtnomcomple.value);
        parametros.append('aula', txtaulaalumn.value);

        window.open(`../reports/estudiante/asistencias/reporte.php?${parametros}`, `_blank`);

      }, 1500);

    }
  }

  /* <---------------- PERMISOS ----------------> */
  function generarPDFPermisos() {
    if (txtapellidop.value == '' || txtapellidom.value == '' || txtnomcomple.value == '' || txtaulaalumn.value == '') {
      alertar('Ingrese número de documento y pulse ENTER', 'info');
      txtnumerodoc.focus();

    } else if (txtdesdealum.value == '') {
      alertar('Elija fecha de inicio', 'info');
      txtdesdealum.focus();

    } else if (txthastaalum.value == '') {
      alertar('Elija fecha de término', 'info');
      txthastaalum.focus();

    } else {

      cargando('Permisos');

      setTimeout(() => {

        const parametros = new URLSearchParams();
        parametros.append('nrodocumento', nrodocumento);
        parametros.append('desde', txtdesdealum.value);
        parametros.append('hasta', txthastaalum.value);
        parametros.append('apepaterno', txtapellidop.value);
        parametros.append('apematerno', txtapellidom.value);
        parametros.append('nombres', txtnomcomple.value);
        parametros.append('aula', txtaulaalumn.value);

        window.open(`../reports/estudiante/permisos/reporte.php?${parametros}`, `_blank`);

      }, 1500);

    }
  }


  formulalumna.addEventListener('submit', (e) => {
    e.preventDefault();
  });

  btnreiniciar.addEventListener('click', () => {
    formulalumna.reset();
    txtnumerodoc.focus();
    denegar();
  });

  btnbuscardoc.addEventListener('click', () => {
    obtenerAlumna();
    txtnumerodoc.focus();
    denegar();
    formulalumna.reset();
  });

  txtnumerodoc.addEventListener('keypress', (e) => {
    if (e.charCode == 13) obtenerAlumna();
  });


  txtdesdealum.addEventListener('change', () => {
    if (nrodocumento != -1)
      if (txtdesdealum.value == '') {
        txtdesdealum.focus();

      } else {

        if (txthastaalum.value == '') {
          txthastaalum.focus();
        }
      }
  });

  txthastaalum.addEventListener('change', () => {
    if (nrodocumento != -1)
      if (txtdesdealum.value == '') {
        alertar('Elija fecha de inicio', 'info');
        txtdesdealum.focus();

      }
  });

  btnasialumna.addEventListener('click', () => {
    txtnumerodoc.focus()
  });

  btnperalumna.addEventListener('click', () => {
    txtnumerodoc.focus()
  });

  btngenerapdf.addEventListener('click', generarPDF);
  btnpdfpermis.addEventListener('click', generarPDFPermisos);
</script>