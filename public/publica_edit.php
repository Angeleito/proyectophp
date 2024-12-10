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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_content = $_POST['content'];

    // Verificar si el usuario es el propietario de la publicación
    $stmt = $conn->prepare("SELECT id_usuario FROM Publicaciones WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->bind_result($post_owner_id);
    $stmt->fetch();

    if ($post_owner_id != $user_id) {
        echo "No tienes permiso para editar esta publicación.";
        exit();
    }

    // Actualizar la publicación
    $stmt = $conn->prepare("UPDATE Publicaciones SET contenido = ?, fecha_actualizacion = NOW() WHERE id = ?");
    $stmt->bind_param("si", $new_content, $post_id);

    if ($stmt->execute()) {
        echo "Publicación actualizada correctamente.";
    } else {
        echo "Error al actualizar la publicación.";
    }
}

$stmt = $conn->prepare("SELECT contenido FROM Publicaciones WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$stmt->bind_result($current_content);
$stmt->fetch();
?>

<form method="POST">
    <textarea name="content"><?= $current_content ?></textarea>
    <button type="submit">Actualizar</button>
</form>