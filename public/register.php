<?php

include('../config.php');
include('../functions.php');
include('../mailer.php');
include('../db.php');
session_start();


$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    if (empty($username) || empty($email) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Validación del correo
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Correo electrónico no válido.";
        } else {
            // Insertar el usuario en la base de datos
            $stmt = $conn->prepare("INSERT INTO Usuarios (nombre_usuario, correo_electronico, contraseña, rol, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, 'usuario', NOW(), NOW())");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                // Enviar correo de bienvenida
                $subject = "¡Bienvenido a Red Social!";
                $body = "Hola, $username!<br>Gracias por registrarte en nuestra plataforma. ¡Disfruta conectándote con tus amigos!";

                if (sendMail($email, $subject, $body)) {
                    header("Location: login.php?success=registrado");
                    exit();
                } else {
                    $error = "Usuario creado, pero no se pudo enviar el correo.";
                }
            } else {
                $error = "Error al registrar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Registrarse</h2>
        <form method="POST">
            <input type="text" name="username" class="w-full p-2 mb-4 border border-gray-300 rounded" placeholder="Nombre de usuario" required>
            <input type="email" name="email" class="w-full p-2 mb-4 border border-gray-300 rounded" placeholder="Correo electrónico" required>
            <input type="password" name="password" class="w-full p-2 mb-4 border border-gray-300 rounded" placeholder="Contraseña" required>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Registrarse</button>
        </form>
    </div>
</body>
</html>