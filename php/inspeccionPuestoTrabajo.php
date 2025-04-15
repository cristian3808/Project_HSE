<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEnviarCorreo']))
{
    $pdfPath = 'inspeccion_puesto_trabajo.pdf';
    $pdfData = base64_decode($_POST['pdfData']);
    
    if($pdfData === false) {
        echo "Error: PDF no válido";
        exit;
    }

    file_put_contents($pdfPath, $pdfData);

    header('Content-Type: text/plain');
    echo "El correo se está enviando en segundo plano...";
    header('Connection: close');
    header('Content-Lenght: ' . ob_get_length());
    ob_end_flush();
    flush();

    ignore_user_abort(true);

    $correos = ['cristian.mora3808@gmail.com'];

    $mail = new PHPMailer(true);
    try{
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pruebasoftwarerc@gmail.com';
        $mail->Password = 'abkgbjoekgsvhtnj'; // Use métodos seguros para almacenar credenciales en producción
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->SMTPKeepAlive = true;
    
        $mail->setFrom('tu_correo@gmail.com', 'HSE TF');
        $mail->isHTML(true);
        $mail->Subject = 'INSPECCION PUESTO DE TRABAJO';
        $mail->Body = "Inspeccion Puesto De Trabajo.";
        
        $mail->addAttachment($pdfPath, 'inspeccion_trabajo.pdf');

        // Enviar el correo a cada destinatario con el PDF adjunto
        foreach ($correos as $correo) {
            $mail->clearAddresses();
            $mail->addAddress($correo);
            echo "Correo enviado con éxito a: $correo <br>";

            if ($mail->send()){
                echo "Correo enviado con éxito a; $correo <br>";
            } else {
                echo "Error al enviar correo a: $correo <br>";
            }
        }
        $mail->smtpClose();
    } catch(Exception $e) {
        echo "Excepción capturada: {$mail->ErrorInfo} <br>";
    }
    
    if(file_exists($pdfPath)){
        unlink($pdfPath);
        echo "PDF eliminado del servidor";
    }
}
?>
