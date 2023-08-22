<?php

require_once 'Conexion.php';

class Aula extends Conexion {
  private $acceso;

  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  public function obtener($data = []){
    try {
      $consulta = $this->acceso->prepare("CALL spu_aula_obtener(?,?)");
      $consulta->execute(
        array(
          $data['grado'],
          $data['seccion']
        )
      );
      
      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  /* <---------------- MÓDULO REPORTES ----------------> */
  /* AULA */
  // public function listar($data = []){
  //   try {
  //     $consulta = $this->acceso->prepare("CALL spu_aulas_listar(?)");
  //     $consulta->execute(
  //       array(
  //         $data['turno']
  //       )
  //     );
      
  //     return $consulta->fetchAll(PDO::FETCH_ASSOC);
  //   } catch (Exception $e) {
  //     die($e->getMessage());
  //   }
  // }


  /* <---------------- MÓDULO REPORTES ----------------> */
  /* AULA */
  public function obtenerAsistenciaDiaria($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_aula_obtenerasidiaria(?,?)");
      $consulta->execute(array(
        $data['grado'],
        $data['seccion']
      ));
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function obtenerAsistenciaFechas($data = []) {
    try {
      $consulta = $this->acceso->prepare("CALL spu_aula_obtenerasifechas(?,?,?,?)");
      $consulta->execute(
        array(
          $data['grado'],
          $data['seccion'],
          $data['desde'],
          $data['hasta']
        )
      );
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

}
