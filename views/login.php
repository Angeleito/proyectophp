<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Iniciar Sesión</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold mb-5">Iniciar Sesión</h1>
        <form method="POST" action="rsocial.php?action=login" class="bg-white shadow rounded p-6">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">Contraseña:</label>
                <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>