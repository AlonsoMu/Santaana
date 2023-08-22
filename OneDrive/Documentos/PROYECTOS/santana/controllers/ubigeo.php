<?php

require_once '../models/Ubigeo.php';

if (isset($_POST['op'])) {
  $ubigeo = new Ubigeo();

  /* <---------------- MÓDULO ESTUDIANTES ----------------> */
  /* REGISTRO */
  if ($_POST['op'] == 'listar') {
    echo json_encode($ubigeo->listar());
  }
}
