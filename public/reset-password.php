<?php

include('../config.php');
include('../functions.php');
include('../db.php');
session_start();

$conn = getDBConnection();

$reset_code = $_GET['code'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['password']);
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    if (empty($new_password)) {
        $error = "La nueva contraseña no puede estar vacía.";
    } else {
        $stmt = $conn->prepare("UPDATE Usuarios SET contraseña = ?, reset_code = NULL WHERE reset_code = ?");
        $stmt->bind_param("ss", $hashed_password, $reset_code);
        if ($stmt->execute()) {
            header("Location: login.php?success=contraseña_restablecida");
            exit();
        } else {
            $error = "Error al restablecer la contraseña.";
        }
    }
}
?>