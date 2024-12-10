<?php
use PHPmailer\PHPMailer\PHPMailer;


function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Cambiar según el servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'angelgap1112@gmail.com'; // Tu correo electrónico
        $mail->Password = 'ovop bmok dbcb hwmh'; // Tu contraseña o token de app
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('tu_correo@gmail.com', 'Red Social'); // Remitente
        $mail->addAddress($to); // Destinatario
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Enviar el correo
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Si ocurre un error, mostrar el mensaje de error
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>