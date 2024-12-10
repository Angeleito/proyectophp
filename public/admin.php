<?php
include('../db.php');
include('../functions.php');
include('../config.php');

session_start();
checkAdmin(); // Verifica que el usuario sea administrador

$action = $_GET['action'] ?? 'dashboard';

switch ($action) {
    case 'dashboard':
        // Mostrar el panel de administración
        $posts = $conn->query("SELECT p.id, p.contenido, u.nombre_usuario FROM Publicaciones p INNER JOIN Usuarios u ON p.id_usuario = u.id");
        $comments = $conn->query("SELECT c.id, c.contenido, u.nombre_usuario FROM Comentarios c INNER JOIN Usuarios u ON c.id_usuario = u.id");
        $users = $conn->query("SELECT id, nombre_usuario, correo_electronico, rol FROM Usuarios");

        include 'views/admin-dashboard.php';
        break;

    case 'delete-post':
        $post_id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM Publicaciones WHERE id = ?");
        $stmt->bind_param("i", $post_id);

        if ($stmt->execute()) {
            header("Location: admin.php?action=dashboard");
        } else {
            echo "Error al eliminar la publicación.";
        }
        break;

    case 'delete-comment':
        $comment_id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM Comentarios WHERE id = ?");
        $stmt->bind_param("i", $comment_id);

        if ($stmt->execute()) {
            header("Location: admin.php?action=dashboard");
        } else {
            echo "Error al eliminar el comentario.";
        }
        break;

    case 'delete-user':
        $user_id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM Usuarios WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            header("Location: admin.php?action=dashboard");
        } else {
            echo "Error al eliminar el usuario.";
        }
        break;

    default:
        echo "Acción no válida.";
}
?>