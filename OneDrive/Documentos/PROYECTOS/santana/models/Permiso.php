<?php

require_once 'Conexion.php';

class Permiso extends Conexion {
  private $acceso;

  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO PERMISOS ----------------> */
  public function listarMotivos(){
    try{
      $consulta = $this->acceso->prepare("CALL spu_motivos_listar()");
      $consulta->execute();
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function registrar($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_permiso_registrar(?,?,?,?,?)");
      $consulta->execute(
        array(
         $data['idasistencia_fk'],
         $data['idmotivo_fk'],
         $data['idcolaboradorautoriza_fk'],
         $data['comentario'],
         $data['evidencia']
        )
      );
      
      return $consulta->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function obtenerPorFechas($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_alumna_obtenerpermisofechas(?,?,?)");
      $consulta->execute(
        array(
         $data['nrodocumento'],
         $data['desde'],
         $data['hasta']
        )
      );
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }



  // public function obtener($data = []){
  //   try{
  //     $consulta = $this->acceso->prepare("CALL spu_alumna_obtenerpermiso(?)");
  //     $consulta->execute(
  //       array(
  //        $data['idasistencia_fk']
  //       )
  //     );
      
  //     return $consulta->fetch(PDO::FETCH_ASSOC);
  //   }catch(Exception $e){
  //     die($e->getMessage());
  //   }
  // }

}
