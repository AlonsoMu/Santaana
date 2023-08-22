<?php
session_start();

$_SESSION['login'] = [];
$_SESSION['datosPerfil'] = [];
require_once '../models/Colaborador.php';
require_once '../models/Mail.php';

if (isset($_POST['op'])) {
  $colaborador = new Colaborador();

  /* <---------------- MÓDULO COLABORADORES ----------------> */
  if ($_POST['op'] == 'login') {
    $datoObtenido = $colaborador->login(['nombreusuario' => $_POST['nombreusuario']]);

    $resultado = [
      'status'          => false,
      'idcolaborador'   => '',
      'apepaterno'      => '',
      'apematerno'      => '',
      'nombres'         => '',
      'nivelacceso'     => '',
      'mensaje'         => ''
    ];

    if ($datoObtenido) {
      $claveEncriptada = $datoObtenido['claveacceso'];

      if ($_POST['claveingresada'] == '') {
        $resultado['mensaje'] = 'La contraseña no puede estar vacía';
      } else {
        if (password_verify($_POST['claveingresada'], $claveEncriptada)) {
          $resultado['status'] =  true;
          $resultado['idcolaborador'] = $datoObtenido['idcolaborador'];
          $resultado['apepaterno'] = $datoObtenido['apepaterno'];
          $resultado['apematerno'] = $datoObtenido['apematerno'];
          $resultado['nombres'] = $datoObtenido['nombres'];
          $resultado['nivelacceso'] = $datoObtenido['nivelacceso'];

          $_SESSION['login'] = $resultado;
        } else {
          $resultado['mensaje'] = 'Contraseña incorrecta';
        }
      }
    } else {
      //No existe usuario
      $resultado['mensaje'] = 'El nombre de usuario no está registrado en el sistema';
    }

    //Enviando datos al view...
    echo json_encode($resultado);
  }

  if ($_POST['op'] == 'buscar') {
    $datoObtenido = $colaborador->buscar(['nombreusuario' => $_POST['nombreusuario']]);

    if ($datoObtenido) {
      echo json_encode($datoObtenido);
    }
  }

  if ($_POST['op'] == 'enviarCorreo') {
    //VALIDAR QUE ESTE PROCESO ¡NO! SE EJECUTE SINO HASTA DESPUÉS 15MIN
    $respuesta = $colaborador->validarTiempo(['idcolaborador_fk' => $_POST['idcolaborador_fk']]);
    // $retornoDatos = ['mensaje' => 'Ya se te envio una clave, revisa tu correo'];

    if ($respuesta['status'] == 'GENERAR') {
      //Crear un valor aleatorio de 4 dígitos
      $valorAleatorio = random_int(1000, 9999);

      //Cuerpo del mensaje a enviar por EMAIL
      $mensaje = "
        <h1>Recuperación de su cuenta</h1>
        <hr>
        <p>Estimado(a), para recuperar el acceso a su cuenta utilice la siguiente contraseña:</p>
        <h1 style='color:cornflowerblue;font-size:50px;'>{$valorAleatorio}</h1>
      ";

      //Arreglo con datos a guardar en la tabla de recuperación
      $data = [
        'idcolaborador_fk'  => $_POST['idcolaborador_fk'],
        'email'             => $_POST['email'],
        'clavegenerada'     => $valorAleatorio
      ];

      //Creando registro
      $colaborador->registrarDesbloqueo($data);

      //Enviando correo
      enviarCorreo($_POST['email'], 'Código de restauración', $mensaje);
      // $retornoDatos['mensaje'] = 'Se ha generado y enviado la clave al email indicado';
    }

    //Enviado a la vista
    echo json_encode($respuesta);
  }

  if ($_POST['op'] == 'validarClave') {
    $datos = [
      'idcolaborador_fk'  => $_POST['idcolaborador_fk'],
      'clavegenerada'     => $_POST['clavegenerada'] //modal
    ];

    echo json_encode($colaborador->validarClave($datos));
  }

  if ($_POST['op'] == 'actualizarClave') {
    $datos = [
      'idcolaborador'   => $_POST['idcolaborador'],
      'claveacceso'     => password_hash($_POST['claveacceso'], PASSWORD_BCRYPT)
    ];

    echo json_encode($colaborador->actualizarClave($datos));
  }


  /* <---------------- MÓDULO PERMISOS ----------------> */
  // if ($_POST['op'] == 'listar') {
  //   echo json_encode($colaborador->listar());
  // }
}

if (isset($_GET['op']) == 'destroy') {
  session_destroy();
  session_unset();
  header('location:../');
}