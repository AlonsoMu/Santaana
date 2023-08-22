
<?php

//1. Necesitamos saber qué NIVEL DE ACCESO tiene el usuario
//Revise controlador...
$permiso = $_SESSION['login']['nivelacceso'];

//2. Array con los permisos por cada NIVEL DE ACCESO
$opciones = [];

//ADM - SPV - AST
switch ($permiso) {
  case "DIRECTOR":
    $opciones = [
      ["menu" => "Inicio", "url" => ['view' => "home.php"], 'icono' => "fa-home"],
      ["menu" => "Asistencia", "url" => ['view' => "home.php?view=asistencia.php"], 'icono' => "fa-clipboard"],
      ["menu" => "Matrícula", "url" => ['view' => "home.php?view=matricula.php"], 'icono' => "fa-users"],
      ["menu" => "Permisos", "url" => ['view' => "home.php?view=permisos.php"], 'icono' => "fa-person-walking-dashed-line-arrow-right"],
      [
        "menu" => "Reportes",
        "url" =>
        [
          'view1' => 'home.php?view=reporte-estudiante.php',
          'view2' => 'home.php?view=reporte-aula.php'
        ],
        'icono' => "fa-file-pdf"
      ]
    ];
    break;
  case "SUBDIRECTOR(A)":
    $opciones = [
      ["menu" => "Inicio", "url" => ['view' => "home.php"], 'icono' => "fa-home"],
      ["menu" => "Asistencia", "url" => ['view' => "home.php?view=asistencia.php"], 'icono' => "fa-clipboard"],
      ["menu" => "Matrícula", "url" => ['view' => "home.php?view=matricula.php"], 'icono' => "fa-users"],
      ["menu" => "Permisos", "url" => ['view' => "home.php?view=permisos.php"], 'icono' => "fa-person-walking-dashed-line-arrow-right"],
      [
        "menu" => "Reportes",
        "url" =>
        [
          'view1' => 'home.php?view=reporte-estudiante.php',
          'view2' => 'home.php?view=reporte-aula.php'
        ],
        'icono' => "fa-file-pdf"
      ]
    ];
    break;
  case "DOCENTE":
    $opciones = [
      ["menu" => "Inicio", "url" => ['view' => "home.php"], 'icono' => "fa-home"],
      [
        "menu" => "Reportes",
        "url" =>
        [
          'view1' => 'home.php?view=reporte-estudiante.php',
          'view2' => 'home.php?view=reporte-aula.php'
        ],
        'icono' => "fa-file-pdf"
      ]
    ];
    break;
  case "AUXILIAR":
    $opciones = [
      ["menu" => "Inicio", "url" => ['view' => "home.php"], 'icono' => "fa-home"],
      ["menu" => "Asistencia", "url" => ['view' => "home.php?view=asistencia.php"], 'icono' => "fa-clipboard"],
      ["menu" => "Permisos", "url" => ['view' => "home.php?view=permisos.php"], 'icono' => "fa-person-walking-dashed-line-arrow-right"],
      [
        "menu" => "Reportes",
        "url" =>
        [
          'view1' => 'home.php?view=reporte-estudiante.php',
          'view2' => 'home.php?view=reporte-aula.php'
        ],
        'icono' => "fa-file-pdf"
      ]
    ];
    break;
  case "APODERADO":
    $opciones = [
      ["menu" => "Inicio", "url" => ['view' => "home.php"], 'icono' => "fa-home"]
    ];
    break;
}


echo "<li class='nav-item'>";

//Renderizar los ítems del SIDEBAR
foreach ($opciones as $item) {
  if (isset($item['url']['view'])) {
    echo "
      <a class='nav-link' href='{$item['url']['view']}'>
        <i class='fa-solid {$item['icono']}'></i>
        <span>{$item['menu']}</span>
      </a>
    ";
  } else {
    echo "
      <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseTwo' aria-expanded='true' aria-controls='collapseTwo'>
        <i class='fa-solid {$item['icono']}'></i>
        <span>{$item['menu']}</span></a>
      </a>
      <div id='collapseTwo' class='collapse' aria-labelledby='headingTwo' data-parent='#accordionSidebar'>
        <div class='bg-white py-2 collapse-inner rounded'>
          <h6 class='collapse-header'>Lista de opciones:</h6>
          <a class='collapse-item' href='{$item['url']['view1']}'>Estudiante</a>
          <a class='collapse-item' href='{$item['url']['view2']}'>Aula</a>
        </div>
      </div>
    ";
  }
}

echo "</li>";