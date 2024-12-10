<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Panel de Administración</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-5">Panel de Administración</h1>

        <!-- Gestionar Publicaciones -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold mb-3">Publicaciones</h2>
            <table class="table-auto w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Contenido</th>
                        <th class="px-4 py-2">Autor</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($post = $posts->fetch_assoc()): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $post['id'] ?></td>
                            <td class="border px-4 py-2"><?= $post['contenido'] ?></td>
                            <td class="border px-4 py-2"><?= $post['nombre_usuario'] ?></td>
                            <td class="border px-4 py-2">
                                <a href="admin.php?action=delete-post&id=<?= $post['id'] ?>" class="text-red-500">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Gestionar Comentarios -->
        <div class="mb-10">
            <h2 class="text-2xl font-semibold mb-3">Comentarios</h2>
            <table class="table-auto w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Contenido</th>
                        <th class="px-4 py-2">Autor</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($comment = $comments->fetch_assoc()): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $comment['id'] ?></td>
                            <td class="border px-4 py-2"><?= $comment['contenido'] ?></td>
                            <td class="border px-4 py-2"><?= $comment['nombre_usuario'] ?></td>
                            <td class="border px-4 py-2">
                                <a href="admin.php?action=delete-comment&id=<?= $comment['id'] ?>" class="text-red-500">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Gestionar Usuarios -->
        <div>
            <h2 class="text-2xl font-semibold mb-3">Usuarios</h2>
            <table class="table-auto w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Usuario</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Rol</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                        <tr>
                            <td class="border px-4 py-2"><?= $user['id'] ?></td>
                            <td class="border px-4 py-2"><?= $user['nombre_usuario'] ?></td>
                            <td class="border px-4 py-2"><?= $user['correo_electronico'] ?></td>
                            <td class="border px-4 py-2"><?= $user['rol'] ?></td>
                            <td class="border px-4 py-2">
                                <a href="admin.php?action=delete-user&id=<?= $user['id'] ?>" class="text-red-500">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>