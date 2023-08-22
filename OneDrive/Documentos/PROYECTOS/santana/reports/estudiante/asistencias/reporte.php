<?php
//Configurar la zona horaria
date_default_timezone_set('America/Lima');

//Librerías obtenidas COMPOSER
require '../../../vendor/autoload.php';
require '../../../models/Alumna.php';

//Obtener la fecha
$fechaActual = date('d-m-Y');

//Namespaces (espacios de nombres/contenedor de clase)
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

//¿Cómo estructurar el reporte?
//PDF = múltiples páginas / cada sección se construya de forma independiente
//Construcción reporte PDF
try {
  $alumna = new Alumna();

  $datos = $alumna->obtenerAsistenciaFechas(
    [
      'nrodocumento'  => $_GET['nrodocumento'],
      'desde'         => $_GET['desde'],
      'hasta'         => $_GET['hasta']
    ]
  );

  $apepaterno = $_GET['apepaterno'];
  $apematerno = $_GET['apematerno'];
  $nombres = $_GET['nombres'];
  $aula = $_GET['aula'];
  $logo = '../../../views/img/logo.jpg';
  $piePagina = "I.E.E. SANTA ANA - Reporte generado: {$fechaActual}";

  //Contenido (HTML) que renderizaremos como PDF
  $content = "";

  //Iniciamos la creación del binario
  ob_start();

  include '../../estilos.html';
  include './estudiante.php';

  //Cierre en el proceso de creación de binarios
  $content .= ob_get_clean();

  //Configuración del archivo PDF
  //P = Portrait(Vertical) / L = Landscape(Horizontal)
  $html2pdf = new Html2Pdf('P', 'A4', 'es', true, 'UTF-8', array(15, 15, 15, 15));
  $html2pdf->writeHTML($content);
  $html2pdf->output('reporte.pdf');
} catch (Html2PdfException $error) {
  $formatter = new ExceptionFormatter($error);
  echo $formatter->getHtmlMessage();
}
