<page>
  <page_header>

  </page_header>

  <page_footer>
    <hr style="border: 0.25px solid gray;">
    <p class="text-center text-regular text-bold"><?= $piePagina ?></p>
  </page_footer>

  <div class="container">
    <h1 class="text-center text-lg mb-5">SOLICITUD DE PERMISO</h1>


    <p class="text-regular mt-2 mb-2">Sr. Miguel Arturo Yataco Saravia</p>
    <p class="text-regular mb-5">Director de la I.E.E. Santa Ana</p>

    <p class="mt-5 mb-5 text-regular text-justify" style="line-height: 30px;">
      &nbsp; &nbsp; &nbsp;
      Yo, <?= $_GET['apepaterno'] ?> <?= $_GET['apematerno'] ?> <?= $_GET['nombres'] ?>, identificado con DNI Nº <?= $_GET['nrodocumento'] ?>,
      domiciliado en __________________________________________________, provincia y departamento de _____________________. Ante Ud. respetuosamente me presento y expongo:
    </p>

    <p class="mt-5 text-regular text-justify" style="line-height: 30px;">
      &nbsp; &nbsp; &nbsp; &nbsp;
      Que, en mi calidad de estudiante del nivel secundario de su prestigiosa Institución, solicito permiso por motivos ________________________________,
      para lo cual adjunto copias de constancias de atención de ESSALUD, recetas médicas y otros.
    </p>


    <p class="text-regular mb-2 mt-5">Por lo expuesto:</p>
    <p class="text-regular mb-5">Ruego a usted Sr. Director Acceder a mi solicitud por ser de justicia.</p>

    <p class="text-end text-regular mb-5">Chincha Alta, <?= $fecha_formateada ?></p>

    <br><br><br><br>
    <br><br><br><br>
    <br><br><br><br>

    <table class="table">
      <colgroup>
        <col style='width:40%;'>
        <col style='width:20%;'>
        <col style='width:40%;'>
      </colgroup>

      <thead>
        <tr class="text-center">
          <th style="border: 0;">___________________________________</th>
          <th style="border: 0;"></th>
          <th style="border: 0;">___________________________________</th>
        </tr>
      </thead>
      <tbody>
        <tr class="text-center">
          <td class="text-regular" style="border: 0;">DIRECTOR</td>
          <td class="text-regular" style="border: 0;"></td>
          <td class="text-regular" style="border: 0;">APODERADO</td>
        </tr>
        <tr class="text-center">
          <td class="text-regular" style="border: 0;">YATACO SARAVIA</td>
          <td class="text-regular" style="border: 0;"></td>
          <td class="text-regular" style="border: 0;"></td>
        </tr>
        <tr class="text-center">
          <td class="text-regular" style="border: 0;">Miguel Arturo</td>
          <td class="text-regular" style="border: 0;"></td>
          <td class="text-regular" style="border: 0;"></td>
        </tr>
        <tr class=" pl-2">
          <td class="text-regular pl-2" style="border: 0;">DNI:</td>
          <td class="text-regular pl-2" style="border: 0;"></td>
          <td class="text-regular pl-2" style="border: 0;">DNI:</td>
        </tr>
      </tbody>
    </table>
  </div>
</page>