<?php

class Conexion{
  private $server = "localhost";
  private $port = "3306";
  private $db = "dbsa";
  private $user = "root";
  private $password = "";

  public function getConexion(){
    try{
      $pdo = new PDO(
        "mysql:host={$this->server};
        port={$this->port};
        dbname={$this->db};
        charset=UTF8", 
        $this->user, 
        $this->password
      );

      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $pdo;
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}