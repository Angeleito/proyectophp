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
$comment_id = $_GET['id'];

// Verificar si el usuario es el propietario del comentario
$stmt = $conn->prepare("SELECT id_usuario FROM Comentarios WHERE id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$stmt->bind_result($comment_owner_id);
$stmt->fetch();

if ($comment_owner_id != $user_id) {
    echo "No tienes permiso para eliminar este comentario.";
    exit();
}

// Eliminar el comentario
$stmt = $conn->prepare("DELETE FROM Comentarios WHERE id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();

echo "Comentario eliminado correctamente.";