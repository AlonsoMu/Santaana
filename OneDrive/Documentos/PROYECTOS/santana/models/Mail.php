<?php
//Load Composer's autoloader
require '../views/assets/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function enviarCorreo($destino, $asunto, $mensaje)
{
  $mail = new PHPMailer(true);

  try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'jacobo2015saravia@gmail.com';          //SMTP username
    // NO OLVIDAR EL TOKEN DEL EMAIL (CLAVE PARA ENVIAR CORREOS)
    $mail->Password   = 'qqmtjndqypgiyyln';                     //SMTP password
    $mail->CharSet    = 'UTF-8';                                //Codificación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('jacobo2015saravia@gmail.com', 'SANTA ANA | Área de Sistemas');
    // $mail->addAddress('1305642@senati.pe');                     //Destino  //Name is optional
    $mail->addAddress($destino);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $asunto;                             //Asunto
    $mail->Body    = $mensaje;                            //Soporta HTML
    $mail->AltBody = 'El mensaje requiere soporte HTML';  //No soporta HTML

    $mail->send();
    echo json_encode(["status" => true]);
  } catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo json_encode(["status" => false]);
  }
}
