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
$post_id = $_GET['id'];

// Verificar si el usuario es el propietario de la publicación
$stmt = $conn->prepare("SELECT id_usuario FROM Publicaciones WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$stmt->bind_result($post_owner_id);
$stmt->fetch();

if ($post_owner_id != $user_id) {
    echo "No tienes permiso para eliminar esta publicación.";
    exit();
}

// Eliminar la publicación
$stmt = $conn->prepare("DELETE FROM Publicaciones WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();

echo "Publicación eliminada correctamente.";