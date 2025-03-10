<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Función para enviar correos electrónicos con archivo PDF adjunto
function enviarCorreoConPdf($correo, $pdfPath) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'pruebasoftwarerc@gmail.com';
    $mail->Password = 'abkgbjoekgsvhtnj'; // Asegúrate de usar credenciales seguras
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    try {
        echo "Intentando enviar correo a: $correo <br>"; // Depuración

        $mail->setFrom('tu_correo@gmail.com', 'HSE TF'); // Cambiar a tu correo
        $mail->addAddress($correo);
        $mail->isHTML(true);
        $mail->Subject = 'INSPECCION COMPORTAMENTAL';
        $mail->Body = "Inspección Comportamental.";
        $mail->addAttachment($pdfPath, 'inspeccion_comportamental.pdf');
        
        if ($mail->send()) {
            echo "Correo enviado con éxito a: $correo <br>";
            return 'El mensaje se envió correctamente a ' . $correo;
        } else {
            echo "Error al enviar correo a: $correo <br>";
            return "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
        }
    } catch (Exception $e) {
        echo "Excepción capturada: {$mail->ErrorInfo} <br>";
        return "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
    }
}

// Variable para almacenar el resultado del envío del correo
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEnviarCorreo'])) {
    echo "Solicitud POST recibida <br>"; // Depuración

    $correos = ['mario.acosta@tfauditores.c1om', 'cristian.mora3808@gmail.com']; // Agregar los correos deseados

    $pdfPath = 'inspeccion_comportamental.pdf';
    $pdfData = base64_decode($_POST['pdfData']);

    if ($pdfData === false) {
        echo "Error: PDF no válido <br>";
    } else {
        echo "PDF decodificado correctamente <br>";

        file_put_contents($pdfPath, $pdfData);
        echo "PDF guardado en el servidor <br>";

        foreach ($correos as $correo) {
            $resultado .= enviarCorreoConPdf($correo, $pdfPath) . '<br>';
        }

        if (file_exists($pdfPath)) {
            unlink($pdfPath);
            echo "PDF eliminado del servidor <br>";
        }
    }
}
?>
