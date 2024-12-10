<?php

include('../config.php');
include('../functions.php');
include('../db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    if (!validateUsername($new_username) || !validateEmail($new_email)) {
        echo "Datos inválidos.";
        exit;
    }

    // Actualizar datos del usuario
    $stmt = $conn->prepare("UPDATE Usuarios SET nombre_usuario = ?, correo_electronico = ? WHERE id = ?");
    $stmt->bind_param("ssi", $new_username, $new_email, $user_id);

    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.";
    } else {
        echo "Error al actualizar los datos.";
    }

    $conn->close();
}

$stmt = $conn->prepare("SELECT nombre_usuario, correo_electronico FROM Usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($current_username, $current_email);
$stmt->fetch();
?>

<form method="POST">
    <input type="text" name="username" value="<?= $current_username ?>" required>
    <input type="email" name="email" value="<?= $current_email ?>" required>
    <button type="submit">Actualizar</button>
</form>