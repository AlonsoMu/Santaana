<?php

session_start();
require_once '../models/Permiso.php';

if (isset($_POST['op'])) {
  $permiso = new Permiso();

  /* <---------------- MÓDULO PERMISOS ----------------> */
  if ($_POST['op'] == 'listarMotivos') {
    echo json_encode($permiso->listarMotivos());
  }

  if ($_POST['op'] == 'registrar') {

    $datosSolicitados = [
      'idasistencia_fk'           => $_POST['idasistencia_fk'],
      'idmotivo_fk'               => $_POST['idmotivo_fk'],
      'idcolaboradorautoriza_fk'  => $_SESSION['login']['idcolaborador'],
      'comentario'                => $_POST['comentario'],
      'evidencia'                 => ''
    ];

    if (isset($_FILES['evidencia'])) {

      $rutaDestino = '../views/img/evidencias/';
      $fechaActual = date('c');
      $nombreArchivo = sha1($fechaActual) . '.jpg';
      $rutaDestino .= $nombreArchivo;

      if (move_uploaded_file($_FILES['evidencia']['tmp_name'], $rutaDestino)) {
        $datosSolicitados['evidencia'] = $nombreArchivo;
      }
    }

    echo json_encode($permiso->registrar($datosSolicitados));
  }

  if ($_POST['op'] == 'obtenerPorFechas') {
    $datosSolicitados = [
      'nrodocumento'  => $_POST['nrodocumento'],
      'desde'         => $_POST['desde'],
      'hasta'         => $_POST['hasta']
    ];

    echo json_encode($permiso->obtenerPorFechas($datosSolicitados));
  }

  // if ($_POST['op'] == 'obtener') {

  //   echo json_encode($permiso->obtener(['idasistencia' => $_POST['idasistencia']]));
  // }

}
