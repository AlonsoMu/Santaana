<?php

require_once '../models/Seccion.php';

if (isset($_POST['op'])) {
  $seccion = new Seccion();

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  if ($_POST['op'] == 'listar') {
    echo json_encode($seccion->listar(['grado' => $_POST['grado']]));
  }
}


?>