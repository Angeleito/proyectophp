<?php

include('../config.php');
include('../functions.php');
include('../db.php');
session_start();

redirectIfLoggedIn(); // Redirige si ya está logueado

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar datos
    if (!validateEmail($email)) {
        echo "Correo inválido.";
        exit();
    }

    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT id, contrasena FROM Usuarios WHERE correo_electronico = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $hashedPassword);
        $stmt->fetch();

        // Verificar contraseña
        if (verifyPassword($password, $hashedPassword)) {
            $_SESSION['user_id'] = $userId;
            header("Location: index.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Iniciar sesión</h2>
        <form method="POST">
            <input type="email" name="email" class="w-full p-2 mb-4 border border-gray-300 rounded" placeholder="Correo electrónico" required>
            <input type="password" name="password" class="w-full p-2 mb-4 border border-gray-300 rounded" placeholder="Contraseña" required>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>