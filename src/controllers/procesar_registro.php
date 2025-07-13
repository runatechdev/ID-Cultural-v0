<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ✅ Asegurarse de que db.php devuelve la conexión
$db = require __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/Usuario.php';

// Instanciar modelo de Usuario
$usuario = new Usuario($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar coincidencia de email y contraseña
    if ($_POST["email"] !== $_POST["confirmarEmail"] || $_POST["password"] !== $_POST["confirmarPassword"]) {
        echo "❌ El correo o la contraseña no coinciden.";
        exit;
    }

    // Verificar si el email ya está registrado
    if ($usuario->emailExiste(trim($_POST["email"]))) {
        echo "⚠️ El correo ya está registrado.";
        exit;
    }

    // Armar datos del formulario
    $datos = [
        'nombre' => $_POST["nombre"] ?? '',
        'apellido' => $_POST["apellido"] ?? '',
        'fecha_nacimiento' => $_POST["fechaNacimiento"] ?? '',
        'genero' => $_POST["genero"] ?? '',
        'pais' => $_POST["pais"] ?? '',
        'provincia' => $_POST["provincia"] ?? '',
        'municipio' => $_POST["municipio"] ?? '',
        'email' => trim($_POST["email"] ?? ''),
        'password' => $_POST["password"] ?? ''
    ];

    // Validar que no haya campos vacíos (opcional)
    foreach ($datos as $key => $value) {
        if (empty($value)) {
            echo "❌ El campo '$key' está vacío.";
            exit;
        }
    }

    try {
        if ($usuario->registrar($datos)) {
            echo "✅ Registro exitoso";
        } else {
            echo "❌ Hubo un error al registrar el usuario.";
        }
    } catch (PDOException $e) {
        echo "❌ Error en SQL: " . $e->getMessage();
    }
}
