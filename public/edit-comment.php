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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_content = $_POST['content'];

    // Verificar si el usuario es el propietario del comentario
    $stmt = $conn->prepare("SELECT id_usuario FROM Comentarios WHERE id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $stmt->bind_result($comment_owner_id);
    $stmt->fetch();

    if ($comment_owner_id != $user_id) {
        echo "No tienes permiso para editar este comentario.";
        exit();
    }

    // Actualizar el comentario
    $stmt = $conn->prepare("UPDATE Comentarios SET contenido = ?, fecha_actualizacion = NOW() WHERE id = ?");
    $stmt->bind_param("si", $new_content, $comment_id);

    if ($stmt->execute()) {
        echo "Comentario actualizado correctamente.";
    } else {
        echo "Error al actualizar el comentario.";
    }
}

$stmt = $conn->prepare("SELECT contenido FROM Comentarios WHERE id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$stmt->bind_result($current_content);
$stmt->fetch();
?>

<form method="POST">
    <textarea name="content"><?= $current_content ?></textarea>
    <button type="submit">Actualizar</button>
</form>