<?php

require_once 'Conexion.php';

class Seccion extends Conexion {
  private $acceso;

  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* MATRÍCULA */
  public function listar($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_seccion_listar(?)");
      $consulta->execute(
        array(
          $data['grado']
        )
      );
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }

}

?>