<?php require_once './autorizacion.php'; ?>

<div class="row m-0 justify-content-center" style="row-gap: 15px;">
  <div class="col-12 alert alert-primary" role="alert">
    <strong>Datos de Perfil</strong>
  </div>

  <div class="col-xl-6 col-12">
    <div class="card shadow">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Información general:</h6>
      </div>
      <div class="card-body p-0">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action">
            <b>Apellidos Completo</b> <span class="float-right"><?= $_SESSION['login']['apepaterno'] ?> <?= $_SESSION['login']['apematerno'] ?></span>
          </a>
          <a href="#" class="list-group-item list-group-item-action"><b>Nombres Completo</b> <span class="float-right"><?= $_SESSION['login']['nombres'] ?></span></a>
          <a href="#" class="list-group-item list-group-item-action"><b>Fecha de Nacimiento</b></a>
          <a href="#" class="list-group-item list-group-item-action"><b>Sexo</b></a>
          <a href="#" class="list-group-item list-group-item-action disabled"><b>Tipo de documento</b></a>
          <a href="#" class="list-group-item list-group-item-action disabled"><b>Numero de documento</b></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Card -->
  <div class="col-xl-6 col-12">
    <div class="card shadow">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Información privilegiada:</h6>
      </div>
      <div class="card-body p-0">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action"><b>Teléfono</b></a>
          <a href="#" class="list-group-item list-group-item-action"><b>Correo Electrónico</b></a>
          <a href="#" class="list-group-item list-group-item-action"><b>Contraseña</b></a>
          <a href="#" class="list-group-item list-group-item-action"><b>Cuenta de usuario</b></a>
        </div>
      </div>
    </div>
  </div>
</div>