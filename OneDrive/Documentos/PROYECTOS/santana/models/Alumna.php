<?php

require_once 'Conexion.php';

class Alumna extends Conexion {
  private $acceso;

  public function __construct() {
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO INICIO ----------------> */
  public function obtenerTotalAsistencia(){
    try {
      $consulta = $this->acceso->prepare("CALL spu_asistenciadiaria_obtenerestado()");
      $consulta->execute();

      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }



  /* <---------------- MÓDULO ASISTENCIA ----------------> */
  public function obtener($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_obtener(?)");
      $consulta->execute(
        array(
          $data['nrodocumento']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
      
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function registrarAsistencia($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_asistencia_registrar(?)");
      $consulta->execute(
        array(
          $data['idmatricula']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function listarAsistencia() {
    try {
      $consulta = $this->acceso->prepare("CALL spu_asistencia_listar()");
      $consulta->execute();

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function buscar($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_buscar(?)");
      $consulta->execute(
        array(
          $data['nombres']
        )
      );

      return $consulta->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  public function matricular($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_matricular(?,?,?,?,?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idubigeo_fk'],
          $data['tipodocumento'],
          $data['nrodocumento'],
          $data['fechanac'],
          $data['apepaterno'],
          $data['apematerno'],
          $data['nombres'],
          $data['direccion'],
          $data['telefono'],
          $data['idgrupo_fk']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
      
    } catch (Exception $e) {
      die($e->getCode());
    }
  }

  /* INFORMACIÓN */
  public function listarPorAula($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumnas_listar(?,?)");
      $consulta->execute(
        array(
          $data['grado'],
          $data['seccion']
        )
      );

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function obtenerInfo($data = []){
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_obtenerinfo(?)");
      $consulta->execute(
        array(
          $data['idpersona']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function actualizarFotografia($data = []) {
    $respuesta = [
      'status'  => false,
      'mensaje' => ''
    ];

    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_actualizarfotografia(?,?)");
      $respuesta['status'] = $consulta->execute(
        array(
          $data['idpersona'],
          $data['fotografia']
        )
      );
    } catch (Exception $e) {
      // die($e->getMessage());
      $respuesta['mensaje'] = 'No se ha podido completar el proceso. Codigo error: '. $e->getCode();
    }

    return $respuesta;
  }


  /* <---------------- MÓDULO REPORTES ----------------> */
  /* ESTUDIANTE */
  public function obtenerAsistenciaFechas($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_obtenerasifechas(?,?,?)");
      $consulta->execute(
        array(
          $data['nrodocumento'],
          $data['desde'],
          $data['hasta']
        )
      );

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  /* <---------------- MÓDULO PERMISOS ----------------> */
  public function verificarAsistencia($data = []){
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_verificarasistencia(?)");
      $consulta->execute(
        array(
          $data['nrodocumento']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function obtenerPermiso($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_alumna_obtenerpermiso(?)");
      $consulta->execute(
        array(
          $data['idasistencia']
        )
      );

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
      die($e->getMessage());
    }
  }
}
