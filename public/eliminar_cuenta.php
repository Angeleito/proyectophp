<?php
// public/delete-account.php
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
    // Eliminar publicaciones del usuario
    $stmt = $conn->prepare("DELETE FROM Publicaciones WHERE id_usuario = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Eliminar comentarios del usuario
    $stmt = $conn->prepare("DELETE FROM Comentarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Eliminar usuario
    $stmt = $conn->prepare("DELETE FROM Usuarios WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Cerrar sesión y redirigir a login
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>

<form method="POST">
    <p>¿Estás seguro de que deseas eliminar tu cuenta?</p>
    <button type="submit">Eliminar cuenta</button>
</form>