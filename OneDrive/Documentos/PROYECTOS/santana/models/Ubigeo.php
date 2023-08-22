<?php

require_once 'Conexion.php';

class Ubigeo extends Conexion {
  private $acceso;

  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  public function listar(){
    try {
      $consulta = $this->acceso->prepare("CALL spu_ubigeos_listar()");
      $consulta->execute();
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

}
