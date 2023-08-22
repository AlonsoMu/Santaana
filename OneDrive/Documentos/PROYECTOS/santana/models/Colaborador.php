<?php

require_once 'Conexion.php';

class Colaborador extends Conexion {
  private $acceso;

  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  /* <---------------- MÓDULO COLABORADORES ----------------> */
  public function login($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_colaborador_login(?)");
      $consulta->execute(
        array(
          $data['nombreusuario']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
  
  public function buscar($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_colaborador_buscar(?)");
      $consulta->execute(
        array(
          $data['nombreusuario']
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function registrarDesbloqueo($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_desbloqueo_registrar(?,?,?)");
      $consulta->execute(
        array(
          $data['idcolaborador_fk'],
          $data['email'],
          $data['clavegenerada']
        )
      );
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function validarTiempo($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_colaborador_validartiempo(?)");
      $consulta->execute(
        array(
          $data['idcolaborador_fk']
      ));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  //Retornará: PERMITIDO/DENEGADO
  //Se sugiere retornar bool/int/string
  public function validarClave($data = []){
    try{
      $consulta = $this->acceso->prepare("CALL spu_colaborador_validarclave(?,?)");
      $consulta->execute(
        array(
          $data['idcolaborador_fk'],
          $data['clavegenerada']
      ));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function actualizarClave($data = []){
    $resultado = ['status' => false];
    try{
      $consulta = $this->acceso->prepare("CALL spu_colaborador_actualizarclave(?,?)");
      $resultado['status'] = $consulta->execute(
        array(
          $data['idcolaborador'],
          $data['claveacceso']
      ));
      return $resultado;
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }


  /* <---------------- MÓDULO PERMISOS ----------------> */
  /* public function listar(){
    try{
      $consulta = $this->acceso->prepare("CALL spu_colaborador_listar()");
      $consulta->execute();

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  } */

}
