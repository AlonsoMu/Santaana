<page>
  <page_footer>
    <hr style="border: 0.25px solid gray;">
    <p class="text-center text-regular text-bold"><?= $piePagina ?></p>
  </page_footer>

  <page_header>
    <h1 class="text-lg text-center text-primary">I.E.E. Santa Ana</h1>
  </page_header>
  
  <div class="container text-center">
    <img src="./<?= $_GET['nrodocumento'] ?>">
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


    </table>
  </div>

</page>