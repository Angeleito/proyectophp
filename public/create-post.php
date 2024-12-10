<?php
// public/create-post.php
include('../includes/config.php');
include('../includes/functions.php');
include('../includes/db.php');
session_start();

checkLogin(); // Verificar si el usuario está logueado

$conn = getDBConnection();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content']);
    if (empty($content)) {
        $error = "El contenido no puede estar vacío.";
    } else {
        // Agregar la publicación
        $stmt = $conn->prepare("INSERT INTO Publicaciones (id_usuario, contenido, fecha_creacion, fecha_actualizacion) VALUES (?, ?, NOW(), NOW())");
        $stmt->bind_param("is", $user_id, $content);
        if ($stmt->execute()) {
            header("Location: index.php?success=publicacion_creada");
            exit();
        } else {
            $error = "Error al crear la publicación.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Publicación</title>
    <link href="../assets/css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Crear Publicación</h1>
        <?php if (!empty($error)): ?>
            <p class="text-red-500"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" class="bg-white shadow p-4 rounded">
            <textarea name="content" class="w-full border rounded p-2 mb-4" placeholder="Escribe algo..." required></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Publicar</button>
        </form>
        <a href="index.php" class="text-blue-500 mt-4 block">Volver a Inicio</a>
    </div>
</body>
</html>