<page>
  <page_footer class="mt-5">
    <hr style="border: 0.25px solid gray;">
    <p class="text-center text-sm text-bold"><?= $piePagina ?></p>
  </page_footer>



  <div class="container text-center">
    <page_header>
      <img src="<?= $logo ?>" style="height: 80px;">
    </page_header>
    <h2 class="text-lg mb-2">Aula</h2>
    <h2 class="text-xl"><?= $_GET['titulo'] ?></h2>
  </div>

  <div class="container">
    <?php

    //HELPERS
    function crearTabla($estado = "")
    {
      $nuevaTabla = "
    <h4 class='mb-2 text-md'>{$estado}</h4>

    <table class='table'>
      <colgroup>
        <col style='width:10%;'>
        <col style='width:25%;'>
        <col style='width:25%;'>
        <col style='width:25%;'>
        <col style='width:15%;'>
      </colgroup>
      <thead>
        <tr class='bg-primary text-light'>
          <th class='pl-3 pt-2 pb-2 text-sm'>N°</th>
          <th class='pl-3 pt-2 pb-2 text-sm'>Apellido Paterno</th>
          <th class='pl-3 pt-2 pb-2 text-sm'>Apellido Materno</th>
          <th class='pl-3 pt-2 pb-2 text-sm'>Nombres</th>
          <th class='pl-3 pt-2 pb-2 text-sm'>Entrada</th>
        </tr>
      </thead>

      <tbody>
    ";

      echo $nuevaTabla;
    }

    function agregarFila($i, $arreglo = [])
    {
      echo "
      <tr>
        <td class='pl-3 pt-2 pb-2 text-sm'>{$i}</td>
        <td class='pl-3 pt-2 pb-2 text-sm'>{$arreglo['apepaterno']}</td>
        <td class='pl-3 pt-2 pb-2 text-sm'>{$arreglo['apematerno']}</td>
        <td class='pl-3 pt-2 pb-2 text-sm'>{$arreglo['nombres']}</td>
        <td class='pl-3 pt-2 pb-2 text-sm'>{$arreglo['horaentradaalu']}</td>
      </tr>
    ";
    }

    function cerrarTabla($subtotal)
    {
      $cerrarTabla = "
        </tbody>
      </table>
    ";

      echo $cerrarTabla;
      echo "<h1 class='mt-2 mb-2 text-end text-sm'>Total: $subtotal</h1>";
    }

    //FIN HELPERS

    //Contabiliza / cuenta la cantidad de registros objetos
    if (count($datos) > 0) {
      $estadoActual = $datos[0]['estado'];
      $subtotal = 0;
      $contadorGlobal = 1;

      //Creamos la primera tabla/cabecera
      crearTabla($estadoActual);

      foreach ($datos as $registro) {

        if ($estadoActual == $registro['estado']) {
          //Agregamos a la tabla actual
          agregarFila($contadorGlobal, $registro);
          $subtotal++;
          $contadorGlobal++;
        } else {
          //Cerrar la tabla anterior, crear una nueva, actualizar $estadoActual
          cerrarTabla($subtotal);
          $estadoActual = $registro['estado'];
          $subtotal = 1;
          $contadorGlobal = 1;
          crearTabla($estadoActual);

          //Agregamos el registo a la nueva tabla
          agregarFila($contadorGlobal, $registro);
          $contadorGlobal++;
        }
      }

      cerrarTabla($subtotal);
    } else {
      echo "<h3 class='mt-3'>No encontramos registros</h3>";
    }

    ?>

  </div>

  <!-- <hr style="border: 0.25px solid gray;"> -->

  <div class="container mt-5">
    <h4 class='mb-2 text-md text-center'>Resumen</h4>
    <table class='table'>
      <colgroup>
        <col style='width: 70%;'>
        <col style='width: 30%;'>
      </colgroup>
      <thead>
        <tr class='bg-primary text-light'>
          <th class="pl-3 pt-2 pb-2 text-sm">Estado</th>
          <th class="text-center pt-2 pb-2 text-sm">Cantidad</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $resumenAlumnas = [];

        foreach ($datos as $registro) {
          $alumna = $registro['estado'];
          if (isset($resumenAlumnas[$alumna])) {
            $resumenAlumnas[$alumna]++;
          } else {
            $resumenAlumnas[$alumna] = 1;
          }
        }

        foreach ($resumenAlumnas as $alumna => $cantidad) : ?>
          <tr>
            <td class="pl-3 pt-2 pb-2 text-sm"><?= $alumna ?></td>
            <td class="text-center pt-2 pb-2 text-sm"><?= $cantidad ?></td>
          </tr>
        <?php endforeach; ?>

        <tr>
          <td class="pl-3 pt-2 pb-2 text-sm">Total:</td>
          <td class="text-center pt-2 pb-2 text-sm"><?= count($datos) ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</page>