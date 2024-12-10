<?php

include('../config.php');
include('../functions.php');
include('../mailer.php');
include('../db.php');
session_start();

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    if (empty($email)) {
        $error = "El correo electrónico es obligatorio.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM Usuarios WHERE correo_electronico = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error = "El correo electrónico no está registrado.";
        } else {
            // Generar un código de recuperación único
            $reset_code = bin2hex(random_bytes(16));
            $stmt = $conn->prepare("UPDATE Usuarios SET reset_code = ? WHERE correo_electronico = ?");
            $stmt->bind_param("ss", $reset_code, $email);
            if ($stmt->execute()) {
                $reset_link = "http://localhost/rsocial/public/reset-password.php?code=$reset_code";
                $subject = "Recuperación de contraseña";
                $body = "Hola,<br>Haz clic en el siguiente enlace para restablecer tu contraseña: <br><a href='$reset_link'>Restablecer Contraseña</a>";

                if (sendMail($email, $subject, $body)) {
                    $success = "Se ha enviado un correo para restablecer tu contraseña.";
                } else {
                    $error = "No se pudo enviar el correo de recuperación.";
                }
            } else {
                $error = "Error al generar el código de recuperación.";
            }
        }
    }
}
?>