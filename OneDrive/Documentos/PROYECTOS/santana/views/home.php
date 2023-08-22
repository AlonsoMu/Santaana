<?php
session_start();

if (!isset($_SESSION['login']) || !$_SESSION['login']) {
  header("Location:../");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>I.E.E. SANTA ANA | Bienvenido(a)</title>
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./assets/fonts/font02.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./assets/fonts/font01.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./assets/fonts/font03.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./assets/fonts/estilos.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./assets/fontawesome/css/all.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="./assets/sb-admin-2/css/sb-admin-2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" href="../vendor/lightbox/css/lightbox.min.css">
  <!--===============================================================================================-->
  <link rel="shortcut icon" href="./img/logo.svg" type="image/x-icon">
  <!--===============================================================================================-->
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- SIDEBAR -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./home.php">
        <div class="sidebar-brand-icon">
          <!-- <i class="fas fa-laugh-wink"></i> -->
          <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div class="sidebar-brand-text mx-3 animated--grow-in">Santa Ana</div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Módulos
      </div>
      <!-- OPCIONES QUE DEBEN SER FILTRADAS DE ACUERD AL PERFIL -->
      <?php require_once './sidebaroptions.php'; ?>
      <!-- FIN OPCIONES DEL SIDEBAR -->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <!-- Botón circular Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- FIN Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Search -->
          <div class="row m-0 w-100 align-items-center justify-content-center">
            <div class="col-md-auto text-center d-flex align-items-center flex-column justify-content-center">
              <h6 class="mb-0"><?= $_SESSION['login']['nivelacceso'] ?></h6>
              <h6 class="m-0 font-weight-bold text-primary" id="hora-tr"></h6>
            </div>

            <div class="col-md-auto d-none d-lg-block flex-grow-1 text-right h-100">
              <i class="fa-solid fa-maximize" id="icono" style="cursor: pointer;"></i>
            </div>
          </div>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-md-inline text-gray-600 small">
                  <?= $_SESSION['login']['nombres'] ?>
                </span>
                <img class="img-profile rounded-circle" src="./img/undraw_profile.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" data-toggle="modal" data-target="#modal-logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar sesión
                </a>
              </div>
            </li>

          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Aquí cargará el contenido dinámico -->
        <!-- Begin Page Content -->
        <div class="container-fluid py-3 animated--fade-in" id="content-dinamics">
          <div class="w-100 d-flex flex-column p-5" style="height: calc(100vh - 180px); gap: 15px;">
            <div class="flex-grow-1" style="background: center / contain no-repeat url('./img/logo-sa.svg');"></div>

            <div class="text-center">
              <h1 class="text-gray-900" style="font-family: 'Oleo Script', cursive;">Una santanina, una señorita de éxtito.</h1>
            </div>
          </div>
        </div>
        <!-- container-fluid -->
        <!-- Fin contenido dinámico -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Todos los derechos reservados &copy; SANTA ANA</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Modal -->
  <div class="modal fade" id="modal-logout" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-light">
          <h5 class="modal-title" id="staticBackdropLabel">I.E.E. SANTA ANA</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-light">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          <h6>¿Está seguro que desea finalizar la sesión?</h6>
          <p>Pulse en <strong class="text-danger">Cerrar sesión</strong>, si es que está seguro</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            <i class="fa-solid fa-thumbs-down"></i> Cancelar
          </button>
          <a class="btn btn-primary btn-sm" id="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
          </a>
        </div>
      </div>
    </div>
  </div>

  <!--===============================================================================================-->
  <script src="./assets/jquery/jquery.min.js"></script>
  <!--===============================================================================================-->
  <script src="./assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!--===============================================================================================-->
  <script src="./assets/sweetalert2/sweetalert2.js"></script>
  <!--===============================================================================================-->
  <script src="./assets/jquery-easing/jquery.easing.min.js"></script>
  <!--===============================================================================================-->
  <script src="./assets/sb-admin-2/js/sb-admin-2.min.js"></script>
  <!--===============================================================================================-->
  <script src="./assets/charts/chart.js"></script>
  <!--===============================================================================================-->
  <script src="../vendor/lightbox/js/lightbox.min.js"></script>
  <!--===============================================================================================-->


  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const btnlogout = document.getElementById('logout');
      const horaTR = document.getElementById('hora-tr');
      let myDocument = document.documentElement;
      let icono = document.getElementById('icono');

      function actualizarHora() {
        const local = new Date();

        horaTR.innerHTML = local.toLocaleTimeString([], {
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit'
        });

        setTimeout(() => actualizarHora(), 1000);
      }

      actualizarHora();

      function alternarPantalla() {
        if (icono.classList[1] == 'fa-maximize') {
          icono.classList.remove('fa-maximize');
          icono.classList.add('fa-minimize');

          if (myDocument.requestFullscreen) {
            myDocument.requestFullscreen();

          } else if (myDocument.msRequestFullscreen) {
            myDocument.msRequestFullscreen();

          } else if (myDocument.mozRequestFullscreen) {
            myDocument.mozRequestFullscreen();

          } else if (myDocument.webkitRequestFullscreen) {
            myDocument.webkitRequestFullscreen();
          }

        } else if (icono.classList[1] == 'fa-minimize') {
          icono.classList.remove('fa-minimize');
          icono.classList.add('fa-maximize');

          if (document.exitFullscreen) {
            document.exitFullscreen();

          } else if (document.msexitFullscreen) {
            document.msexitFullscreen();

          } else if (document.mozexitFullscreen) {
            document.mozexitFullscreen();

          } else if (document.webkitexitFullscreen) {
            document.webkitexitFullscreen();
          }
        }
      }

      icono.addEventListener('click', () => {
        alternarPantalla();
      });

      //Crearemos una función que obtenga la URL(vista)
      function getURL() {
        //1. Obtener la URL
        const url = new URL(window.location.href);
        //2. Obtener el valor enviado por la URL
        const vista = url.searchParams.get('view');
        //3. Crear un objeto que referencia contenedor
        const contenedor = document.querySelector('#content-dinamics');

        //Cuando el usuario elige una opción...
        if (vista != null) {
          fetch(vista)
            .then(res => res.text())
            .then(datos => {
              contenedor.innerHTML = datos;

              //Necesitamos recorrer todas las etiquetas <script> y 'reactivarlas'
              const scriptsTag = contenedor.getElementsByTagName('script');
              for (i = 0; i < scriptsTag.length; i++) {
                eval(scriptsTag[i].innerText);
              }
            });
        }
      }

      lightbox.option({
        'albumLabel': 'Imagen %1 de %2',
        'resizeDuration': 200,
        'wrapAround': true,
        'disableScrolling': true,
      })

      getURL();

      btnlogout.addEventListener('click', () => {

        let timerInterval
        Swal.fire({
          title: 'SANTA ANA',
          html: 'Cerrando sesión...',
          iconHtml: '<img src="./img/logo-sa.svg" style="height:135px; margin: 20px 0">',
          timer: 1600,
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


        setTimeout(() => {
          window.location.href = '../controllers/colaborador.php?op=destroy';
        }, 1500);

      });

    });
  </script>


</body>

</html>