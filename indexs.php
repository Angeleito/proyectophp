<?php
include("../config.php");
include("../functions.php");
include("../mailer.php");
include("../db.php");
session_start();

// Verificar si el usuario está logueado
$is_logged_in = isset($_SESSION['user_id']);
$user_role = $_SESSION['user_role'] ?? null;

// Determinar la acción a ejecutar
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'login':
        if ($is_logged_in) {
            header("Location: index.php");
            exit();
        }
        include 'views/login.php';
        break;

    case 'register':
        if ($is_logged_in) {
            header("Location: index.php");
            exit();
        }
        include 'views/register.php';
        break;

    case 'logout':
        session_destroy();
        header("Location: index.php");
        exit();

    case 'home':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit();
        }
        $posts = $conn->query("SELECT p.id, p.contenido, p.fecha_creacion, u.nombre_usuario 
                              FROM Publicaciones p 
                              INNER JOIN Usuarios u ON p.id_usuario = u.id 
                              ORDER BY p.fecha_creacion DESC");
        include 'views/home.php';
        break;

    case 'add-post':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = cleanInput($_POST['content']);
            $user_id = $_SESSION['user_id'];

            if (!empty($content)) {
                $stmt = $conn->prepare("INSERT INTO Publicaciones (id_usuario, contenido, fecha_creacion) VALUES (?, ?, NOW())");
                $stmt->bind_param("is", $user_id, $content);
                if ($stmt->execute()) {
                    header("Location: index.php?action=home");
                } else {
                    $error = "Error al publicar. Intenta nuevamente.";
                }
            } else {
                $error = "El contenido no puede estar vacío.";
            }
        }
        include 'views/add-post.php';
        break;

    case 'add-comment':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_id = intval($_POST['post_id']);
            $content = cleanInput($_POST['content']);
            $user_id = $_SESSION['user_id'];

            if (!empty($content)) {
                $stmt = $conn->prepare("INSERT INTO Comentarios (id_publicacion, id_usuario, contenido, fecha_creacion) VALUES (?, ?, ?, NOW())");
                $stmt->bind_param("iis", $post_id, $user_id, $content);
                if ($stmt->execute()) {
                    header("Location: index.php?action=home");
                } else {
                    $error = "Error al comentar. Intenta nuevamente.";
                }
            } else {
                $error = "El comentario no puede estar vacío.";
            }
        }
        break;

    case 'admin':
        if (!$is_logged_in || $user_role !== 'administrador') {
            header("Location: index.php?action=home");
            exit();
        }
        header("Location: admin.php");
        break;

    default:
        header("Location: index.php?action=home");
        break;
}
?>