<?php

require_once '../models/Aula.php';

if (isset($_POST['op'])) {
  $aula = new Aula();

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  if ($_POST['op'] == 'obtener') {
    $datosSolicitados = [
      'grado'   => $_POST['grado'],
      'seccion' => $_POST['seccion']
    ];

    echo json_encode($aula->obtener($datosSolicitados));
  }



  // if ($_POST['op'] == 'listar') {
  //   echo json_encode($aula->listar(['turno' => $_POST['turno']]));
  // }


  /* <---------------- MÓDULO REPORTES ----------------> */
  if ($_POST['op'] == 'obtenerAsistenciaDiaria') {
    $datosSolicitados = [
      'grado'   => $_POST['grado'],
      'seccion' => $_POST['seccion']
    ];

    echo json_encode($aula->obtenerAsistenciaDiaria($datosSolicitados));
  }

  if ($_POST['op'] == 'obtenerAsistenciaFechas') {
    $datosSolicitados = [
      'grado'   => $_POST['grado'],
      'seccion' => $_POST['seccion'],
      'desde'   => $_POST['desde'],
      'hasta'   => $_POST['hasta']
    ];

    echo json_encode($aula->obtenerAsistenciaFechas($datosSolicitados));
  }
}
