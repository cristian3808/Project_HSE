<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEnviarCorreo'])) {
    // Decodificar el PDF recibido en base64
    $pdfPath = 'inspeccion_comportamental.pdf';
    $pdfData = base64_decode($_POST['pdfData']);

    if ($pdfData === false) {
        echo "Error: PDF no válido";
        exit;
    }

    // Guardar el PDF temporalmente en el servidor
    file_put_contents($pdfPath, $pdfData);

    // Enviar respuesta inmediata al cliente para que no espere el envío del correo
    header('Content-Type: text/plain');
    echo "El correo se está enviando en segundo plano...";
    header('Connection: close');
    header('Content-Length: ' . ob_get_length());
    ob_end_flush();
    flush();
    
    // Permitir que el script continúe ejecutándose aunque el usuario se desconecte
    ignore_user_abort(true);

    // Definir los correos destinatarios
    $correos = ['mario.acosta@tfauditores.c1om', 'cristian.mora3808@gmail.com'];

    // Configurar PHPMailer una sola vez para reutilizar la conexión SMTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pruebasoftwarerc@gmail.com';
        $mail->Password   = 'abkgbjoekgsvhtnj'; // Usa credenciales seguras
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->SMTPKeepAlive = true; // Mantiene la conexión abierta para múltiples envíos

        $mail->setFrom('tu_correo@gmail.com', 'HSE TF'); // Cambia por el correo remitente real
        $mail->isHTML(true);
        $mail->Subject = 'INSPECCION COMPORTAMENTAL';
        $mail->Body    = "Inspección Comportamental.";
        // Adjuntar el PDF que se va a enviar
        $mail->addAttachment($pdfPath, 'inspeccion_comportamental.pdf');

        // Enviar correo a cada destinatario reutilizando la misma conexión
        foreach ($correos as $correo) {
            $mail->clearAddresses(); // Limpiar destinatarios anteriores
            $mail->addAddress($correo);
            echo "Intentando enviar correo a: $correo <br>"; // Depuración

            if ($mail->send()) {
                echo "Correo enviado con éxito a: $correo <br>";
            } else {
                echo "Error al enviar correo a: $correo <br>";
            }
        }
        $mail->smtpClose(); // Cierra la conexión SMTP al finalizar
    } catch (Exception $e) {
        echo "Excepción capturada: {$mail->ErrorInfo} <br>";
    }

    // Eliminar el PDF temporal del servidor
    if (file_exists($pdfPath)) {
        unlink($pdfPath);
        echo "PDF eliminado del servidor <br>";
    }
}
?>
