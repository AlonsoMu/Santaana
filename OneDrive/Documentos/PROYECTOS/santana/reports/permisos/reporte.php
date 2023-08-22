<?php
//Configurar la zona horaria
date_default_timezone_set('America/Lima');

//Librerías obtenidas COMPOSER
require '../../vendor/autoload.php';
require '../../models/Alumna.php';

//Obtener la fecha
$meses = array(
  1   => 'Enero',
  2   => 'Febrero',
  3   => 'Marzo',
  4   => 'Abril',
  5   => 'Mayo',
  6   => 'Junio',
  7   => 'Julio',
  8   => 'Agosto',
  9   => 'Septiembre',
  10  => 'Octubre',
  11  => 'Noviembre',
  12  => 'Diciembre'
);

// Fecha actual en formato día-mes-año
$fecha_actual = date('d-m-Y');

// Obtener el día, mes y año de la fecha actual
list($dia, $mes_num, $anio) = explode('-', $fecha_actual);

// Obtener el nombre del mes en español
$mes = $meses[(int)$mes_num];

// Unir el día, mes y año en el formato deseado
$fecha_formateada = $dia . ' de ' . $mes . ' de ' . $anio;


//Namespaces (espacios de nombres/contenedor de clase)
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

//¿Cómo estructurar el reporte?
//PDF = múltiples páginas / cada sección se construya de forma independiente
//Construcción reporte PDF
try {
  $alumna = new Alumna();

  $datos = $alumna->obtenerPermiso(['idasistencia' => $_GET['idasistencia']]);

  $apepaterno = $_GET['apepaterno'];
  $apematerno = $_GET['apematerno'];
  $nombres = $_GET['nombres'];
  $aula = $_GET['aula'];
  $logo = '../../views/img/logo.jpg';
  $piePagina = "I.E.E. SANTA ANA";

  //Contenido (HTML) que renderizaremos como PDF
  $content = "";

  //Iniciamos la creación del binario
  ob_start();

  include '../estilos.html';
  include './estudiante.php';

  //Cierre en el proceso de creación de binarios
  $content .= ob_get_clean();

  //Configuración del archivo PDF
  //P = Portrait(Vertical) / L = Landscape(Horizontal)
  $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', array(20, 20, 20, 20));
  $html2pdf->writeHTML($content);
  $html2pdf->output('reporte.pdf');
} catch (Html2PdfException $error) {
  $formatter = new ExceptionFormatter($error);
  echo $formatter->getHtmlMessage();
}
