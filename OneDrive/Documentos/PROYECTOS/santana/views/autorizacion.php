<?php
session_start();

//1. Obteniendo nivel de acceso (LOGIN)
$nivelacceso = $_SESSION['login']['nivelacceso'];

//2. Obtener el nombre de la vista
$url = $_SERVER['REQUEST_URI'];
$url_array = explode('/', $url);
$vistaActiva = $url_array[count($url_array) - 1];

//3. Definir los permisos
$permisos = [
  'DIRECTOR'       => ['asistencia.php', 'matricula.php', 'reporte-estudiante.php', 'reporte-aula.php', 'permisos.php', 'editarperfil.php'],
  'SUBDIRECTOR(A)' => ['asistencia.php', 'matricula.php', 'reporte-estudiante.php', 'reporte-aula.php', 'permisos.php', 'editarperfil.php'],
  'DOCENTE'        => ['reporte-estudiante.php', 'reporte-aula.php', 'editarperfil.php'],
  'AUXILIAR'       => ['asistencia.php', 'reporte-estudiante.php', 'reporte-aula.php', 'permisos.php', 'editarperfil.php'],
  'APODERADO'      => ['editarperfil.php']
];

//4. Validar el acceso
$autorizado = false;

//5. Comprobar los permisos
$vistasPermitidas = $permisos[$nivelacceso];

foreach($vistasPermitidas as $item){
  if ($item == $vistaActiva){
    $autorizado = true;
  }
}

if (!$autorizado){
  //Cargar una vista
  // echo '<h1>Acceso restringido</h1>';
  echo '
    <div class="d-flex justify-content-center align-items-center flex-column" style="height: calc(100vh - 190px)">
      <h1 class="text-center" data-text="" style="font-size: 55px; font-family: Impact;">Acceso Restringido</h1>
      <p class="text-center lead text-gray-800">Ud no tiene acceso a este módulo</p>
      <a href="./home.php">Volver al inicio</a>
    </div>
  ';
  exit();
}
