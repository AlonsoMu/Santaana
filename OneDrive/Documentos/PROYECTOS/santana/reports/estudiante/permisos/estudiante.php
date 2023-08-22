<page>
  <page_footer>
    <hr style="border: 0.25px solid gray;">
    <p class="text-center text-regular text-bold"><?= $piePagina ?></p>
  </page_footer>

  <div class="container text-center">
    <page_header>
      <img src="<?= $logo ?>" style="height: 100px;">
    </page_header>
    <h1 class="text-lg mb-2"><?= $_GET['apepaterno'] ?> <?= $_GET['apematerno'] ?></h1>
    <h1 class="text-lg mb-2"><?= $_GET['nombres'] ?></h1>
    <h2 class="text-lg mb-2"><?= $_GET['aula'] ?></h2>
  </div>

  <div class="container">
    <table class="table">
      <colgroup>
        <col style='width:5%;'>
        <col style='width:25%;'>
        <col style='width:23%;'>
        <col style='width:30%;'>
        <col style='width:17%;'>
      </colgroup>
      <thead>
        <tr class="bg-primary text-light text-center">
          <th class="pt-2 pb-2 text-sm">N°</th>
          <th class="pt-2 pb-2 text-sm">Motivo</th>
          <th class="pt-2 pb-2 text-sm">Fecha y hora</th>
          <th class="pt-2 pb-2 text-sm">Autoriza</th>
          <th class="pt-2 pb-2 text-sm">Cargo</th>
        </tr>
      </thead>

      <tbody>
        <?php
        $i = 1;
        foreach ($datos as $info) : ?>
          <tr>
            <td class="pt-2 pb-2 text-sm text-center"><?= $i++ ?></td>
            <td class="pl-3 pt-2 pb-2 text-sm"><?= $info['descripcionmotivo'] ?></td>
            <td class="pt-2 pb-2 text-sm text-center"><?= $info['fechahorapermiso'] ?></td>
            <td class="pl-3 pt-2 pb-2 text-sm">
              <?= $info['apepatcolaborador'] ?>
              <?= $info['apematcolaborador'] ?>,
              <?= $info['colaborador'] ?>
            </td>
            <td class="pl-3 pt-2 pb-2 text-sm"><?= $info['nombrecargo'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php if (count($datos) > 0) : ?>
      <h1 class="text-end text-sm mt-3">Total : <?= count($datos) ?></h1>
    <?php else : ?>
      <div class="container">
        <h4 class='mb-2 text-md'>Resumen</h4>

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
            <?php foreach ($datos as $info) : ?>
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

        <p class="text-sm mt-5">No se encontró ningún registro de permiso</p>
      </div>
    <?php endif; ?>

  </div>

</page>