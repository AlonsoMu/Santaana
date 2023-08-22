<?php

session_start();
$_SESSION['obtenerTurno'] = [];
require_once '../models/Turno.php';

if (isset($_POST['op'])) {
  $turno = new Turno();

  /* <---------------- MÓDULO COLABORADORES ----------------> */
  /* INICIO DE SESIÓN */
  if ($_POST['op'] == 'obtener') {
    $datoObtenido = $turno->obtener(['turno' => $_POST['turno']]);

    $resultado = [
      'status'      => false,
      'turno'       => '',
      'horaentrada' => '',
      'horasalida'  => '',
      'tolerancia'  => '',
      'mensaje'     => ''
    ];

    if ($datoObtenido) {
      $resultado['status'] =  true;
      $resultado['turno'] = $datoObtenido['turno'];
      $resultado['horaentrada'] = $datoObtenido['horaentrada'];
      $resultado['horasalida'] = $datoObtenido['horasalida'];
      $resultado['tolerancia'] = $datoObtenido['toleranciamin'];
      $resultado['mensaje'] = "Has seleccionado el turno: {$datoObtenido['turno']}";
    } else {
      $resultado['status'] = false;
      $resultado['mensaje'] = 'Por favor selecciona un turno';
    }

    // var_dump($resultado['status']);
    $_SESSION['obtenerTurno'] = $resultado;
    echo json_encode($resultado);
  }
}

?>