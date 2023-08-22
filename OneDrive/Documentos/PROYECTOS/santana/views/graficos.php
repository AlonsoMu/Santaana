<?php require_once './autorizacion.php'; ?>

<div class="row">

  <!-- Bar Chart -->
  <div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Grafico de Barra</h6>
        <div class="dropdown no-arrow">
          <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header">Dropdown Header:</div>
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="container mt-3">
          <canvas id="migrafico"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie Chart -->
  <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Grafico Pie</h6>
        <div class="dropdown no-arrow">
          <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
            <div class="dropdown-header">Dropdown Header:</div>
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="container mt-3">
          <canvas id="piegrafico"></canvas>
        </div>
  
      </div>
    </div>
  </div>
</div>


<script>
  const lienzo = document.getElementById("migrafico")
  const coloresFondo = ['rgba(215, 189, 226, 0.4)', 'rgba(133, 193, 233, 0.4)', 'rgba(247, 220, 111, 0.4)', 'rgba(112, 123, 124, 0.4)', 'rgba(236, 112, 99, 0.4)'];
  const coloresBorde = ['rgba(215, 189, 226, 1)', 'rgba(133, 193, 233, 1)', 'rgba(247, 220, 111, 1)', 'rgba(112, 123, 124, 1)', 'rgba(236, 112, 99, 1)'];

  new Chart(lienzo, {
    type: 'bar',
    data: {
      labels: ['Temprano', 'Tarde', 'No Asistió'],
      datasets: [{
        label: 'cantidad de alumnas',
        data: [12, 5, 18],
        backgroundColor: coloresFondo,
        borderColor: coloresBorde,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<script>
  const lienzo2 = document.getElementById("piegrafico")

  new Chart(lienzo2, {
    type: 'pie',
    data: {
      labels: ['Temprano', 'Tarde', 'No Asistió'],
      datasets: [{
        label: ['Asistencias'],
        data: [12, 5, 18],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>