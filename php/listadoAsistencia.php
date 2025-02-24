<?php
error_reporting(E_ALL & ~E_NOTICE);
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Función para enviar correos con un PDF adjunto
function enviarCorreoConPdf($correo, $pdfPath) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pruebasoftwarerc@gmail.com';
    $mail->Password = 'abkgbjoekgsvhtnj'; // Use métodos seguros para almacenar credenciales en producción
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    try {
        $mail->setFrom('tu_correo@gmail.com', 'HSE TF');
        $mail->addAddress($correo);
        $mail->isHTML(true);
        $mail->Subject = 'LISTA DE ASISTENCIA';
        $mail->Body = "Lista De Asistencia.";
        $mail->addAttachment($pdfPath, 'listado_asistencia.pdf');
        $mail->send();
        return 'El mensaje se envió correctamente a ' . $correo;
    } catch (Exception $e) {
        return "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}
// Variable para almacenar el resultado del envío de correo
$resultado = '';

// Verificar si se hizo clic en el botón de enviar correo
if (isset($_POST['btnEnviarCorreo'])) {
    // Lista de correos a los cuales se enviará el mensaje
    $correos = ['mario.acosta@tfauditores.cosm', 'cristian.mora3808@gmail.com']; // Agregar los correos deseados

    // Generar el PDF
    $pdfPath = 'listado_asistencia.pdf';
    $pdfData = base64_decode($_POST['pdfData']);
    
    // Verificar que los datos del PDF sean válidos
    if (strpos($pdfData, '%PDF') === 0) { // Comprueba si comienza con la firma de PDF
        file_put_contents($pdfPath, $pdfData);

        // Enviar el correo a cada destinatario con el PDF adjunto
        foreach ($correos as $correo) {
            $resultado .= enviarCorreoConPdf($correo, $pdfPath) . '<br>';
        }
    } else {
        $resultado = "Los datos del PDF son inválidos.";
    }

    // Limpiar el archivo PDF si se ha creado
    if (file_exists($pdfPath)) {
        unlink($pdfPath);
    }
}
?>
