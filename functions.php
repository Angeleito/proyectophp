<?php
// Validar correo electrónico
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validar nombre de usuario
function validateUsername($username) {
    return preg_match("/^[a-zA-Z0-9_]{3,15}$/", $username);
}

// Validar contraseña
function validatePassword($password) {
    return preg_match("/^.{8,}$/", $password);
}

// Encriptar contraseña
function encryptPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Verificar contraseña
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Enviar correo de bienvenida
function sendWelcomeEmail($to, $username) {
    $subject = "Bienvenido a RSocial";
    $message = "Hola, $username. ¡Gracias por registrarte en RSocial!";
    mail($to, $subject, $message);  // Usar PHPMailer en un entorno real
}

// Generar código de seguridad para recuperación de contraseña
function generateRecoveryCode() {
    return bin2hex(random_bytes(16));
}

// Verificar código de seguridad
function verifyRecoveryCode($inputCode, $storedCode) {
    return hash_equals($inputCode, $storedCode);
}

// Redirigir si no está logueado
function checkLogin() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Redirigir si está logueado
function redirectIfLoggedIn() {
    session_start();
    if (isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
}

// Verificar si el usuario tiene rol de administrador
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrador';
}

// Redirigir si no es administrador
function checkAdmin() {
    if (!isAdmin()) {
        header("Location: home.php");
        exit();
    }
}

/**
 * Limpia una entrada del usuario para proteger contra ataques como inyección de código.
 * @param string $data - La entrada del usuario a limpiar.
 * @return string - La entrada limpia y segura.
 */
function cleanInput($data) {
    // Eliminar espacios adicionales al inicio y al final
    $data = trim($data);

    // Eliminar barras invertidas
    $data = stripslashes($data);

    // Convertir caracteres especiales a entidades HTML
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

    return $data;
}
?>