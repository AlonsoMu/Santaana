<?php
session_start();

require_once '../models/Alumna.php';

if (isset($_POST['op'])) {
  $alumna = new Alumna();

  /* <---------------- MÓDULO INICIO ----------------> */
  if ($_POST['op'] == 'obtenerTotalAsistencia') {
    echo json_encode($alumna->obtenerTotalAsistencia());
  }


  /* <---------------- MÓDULO ASISTENCIA ----------------> */
  if ($_POST['op'] == 'obtener') {
    echo json_encode($alumna->obtener(['nrodocumento' => $_POST['nrodocumento']]));
  }

  if ($_POST['op'] == 'registrarAsistencia') {
    echo json_encode($alumna->registrarAsistencia(['idmatricula' => $_POST['idmatricula']]));
  }

  if ($_POST['op'] == 'listarAsistencia') {
    echo json_encode($alumna->listarAsistencia());
  }

  if ($_POST['op'] == 'buscar') {
    $resultado = [
      'status'      => false,
      'mensaje'     => ''
    ];

    $respuesta = $alumna->buscar(['nombres' => $_POST['nombres']]);

    if ($respuesta) {
      echo json_encode($respuesta);
    } else {
      $resultado = [
        'status'      => false,
        'mensaje'     => 'No se encontraron coincidencias'
      ];
      echo json_encode($resultado);
    }
  }


  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  if ($_POST['op'] == 'matricular') {
    $datosSolicitados = [
      'idubigeo_fk'   => $_POST['idubigeo_fk'],
      'tipodocumento' => $_POST['tipodocumento'],
      'nrodocumento'  => $_POST['nrodocumento'],
      'fechanac'      => $_POST['fechanac'],
      'apepaterno'    => $_POST['apepaterno'],
      'apematerno'    => $_POST['apematerno'],
      'nombres'       => $_POST['nombres'],
      'direccion'     => $_POST['direccion'],
      'telefono'      => $_POST['telefono'],
      'idgrupo_fk'    => $_POST['idgrupo_fk']
    ];

    echo json_encode($alumna->matricular($datosSolicitados));
  }


  /* INFORMACIÓN */
  if ($_POST['op'] == 'listarPorAula') {
    $datosSolicitados = [
      'grado'   => $_POST['grado'],
      'seccion' => $_POST['seccion']
    ];

    echo json_encode($alumna->listarPorAula($datosSolicitados));
  }

  if ($_POST['op'] == 'obtenerInfo') {
    echo json_encode($alumna->obtenerInfo(['idpersona' => $_POST['idpersona']]));
  }

  if ($_POST['op'] == 'actualizarFotografia') {
    $datosSolicitados = [
      'idpersona'   => $_POST['idpersona'],
      'fotografia'  => ''
    ];

    if (isset($_FILES['imagen'])) {
      $rutaDestino = '../views/img/alumnas/';
      $fechaActual = date('c');
      $nombreArchivo = sha1($fechaActual) . '.jpg';
      $rutaDestino .= $nombreArchivo;

      if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
        $datosSolicitados['fotografia'] = $nombreArchivo;
      }
    }

    echo json_encode($alumna->actualizarFotografia($datosSolicitados));
  }


  /* <---------------- MÓDULO REPORTES ----------------> */
  /* ESTUDIANTE */
  if ($_POST['op'] == 'obtenerAsistenciaFechas') {
    $datosSolicitados = [
      'nrodocumento'  => $_POST['nrodocumento'],
      'desde'         => $_POST['desde'],
      'hasta'         => $_POST['hasta']
    ];

    echo json_encode($alumna->obtenerAsistenciaFechas($datosSolicitados));
  }


  /* <---------------- MÓDULO PERMISOS ----------------> */
  if ($_POST['op'] == 'verificarAsistencia') {
    echo json_encode($alumna->verificarAsistencia(['nrodocumento' => $_POST['nrodocumento']]));
  }
  
  if ($_POST['op'] == 'obtenerPermiso') {
    echo json_encode($alumna->obtenerPermiso(['idasistencia' => $_POST['idasistencia']]));
  }
}
