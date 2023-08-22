<?php
//Configurar la zona horaria
date_default_timezone_set('America/Lima');

//Librerías obtenidas COMPOSER
require '../../vendor/autoload.php';
require '../../models/Aula.php';

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
  $aula = new Aula();

  $datos = $aula->obtenerAsistenciaDiaria(
    [
      'grado'         => $_GET['grado'],
      'seccion'       => $_GET['seccion']
    ]
  );

  $titulo = $_GET['titulo'];
  $logo = '../../views/img/logo.jpg';
  $piePagina = "I.E.E. SANTA ANA - Reporte generado: {$fechaActual}";

  //Contenido (HTML) que renderizaremos como PDF
  $content = "";

  //Iniciamos la creación del binario
  ob_start();

  include '../estilos.html';
  include './aula.php';

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
