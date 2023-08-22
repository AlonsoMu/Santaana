<?php

require_once 'Conexion.php';

class Turno extends Conexion {
  private $acceso;

  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO COLABORADORES ----------------> */
  /* INICIO DE SESIÓN */
  public function obtener($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_turno_obtener(?)");
      $consulta->execute(
        array(
          $data['turno']
        )
      );
      
      return $consulta->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }

}

?>