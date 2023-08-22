<?php

require_once 'Conexion.php';

class Grado extends Conexion {
  private $acceso;

  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  public function listar(){
    try{
      $consulta = $this->acceso->prepare("CALL spu_grado_listar()");
      $consulta->execute();
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }


  /* <---------------- MÓDULO REPORTES ----------------> */
  // public function obtenerReporteDiario($data = []){
  //   try {
  //     $consulta = $this->acceso->prepare("CALL spu_reportediario_grado(?)");
  //     $consulta->execute(
  //       array(
  //         $data['grado']
  //       )
  //     );
      
  //     return $consulta->fetchAll(PDO::FETCH_ASSOC);
  //   } catch (Exception $e) {
  //     die($e->getMessage());
  //   }
  // }

  // public function obtenerReportePersonalizado($data = []){
  //   try {
  //     $consulta = $this->acceso->prepare("CALL spu_reportepersonalizado_grado(?,?,?)");
  //     $consulta->execute(
  //       array(
  //         $data['grado'],
  //         $data['desde'],
  //         $data['hasta']
  //       )
  //     );
      
  //     return $consulta->fetchAll(PDO::FETCH_ASSOC);
  //   } catch (Exception $e) {
  //     die($e->getMessage());
  //   }
  // }

}

?>