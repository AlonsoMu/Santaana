<?php

require_once '../models/Grado.php';

if (isset($_POST['op'])) {
  $grado = new Grado();

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  if ($_POST['op'] == 'listar') {
    echo json_encode($grado->listar());
  }


  /* <---------------- MÓDULO REPORTES ----------------> */
  // if ($_POST['op'] == 'obtenerReporteDiario') {
  //   echo json_encode($grado->obtenerReporteDiario(['grado' => $_POST['grado']]));
  // }

  // if ($_POST['op'] == 'obtenerReportePersonalizado') {
  //   $datosSolicitados = [
  //     'grado'   => $_POST['grado'],
  //     'desde'   => $_POST['desde'],
  //     'hasta'   => $_POST['hasta']
  //   ];
    
  //   echo json_encode($grado->obtenerReportePersonalizado($datosSolicitados));
  // }
}

?>