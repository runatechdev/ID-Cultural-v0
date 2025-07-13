<?php
require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../src/models/Usuario.php';

$usuario = new Usuario($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validación de correo y contraseña
    if ($_POST["email"] !== $_POST["confirmarEmail"] || $_POST["password"] !== $_POST["confirmarPassword"]) {
        echo "❌ El correo o la contraseña no coinciden.";
        exit;
    }

    // Verificar si ya existe
    if ($usuario->emailExiste($_POST["email"])) {
        echo "⚠️ El correo ya está registrado.";
        exit;
    }

    // Datos para registrar
    $datos = [
        'nombre' => $_POST["nombre"],
        'apellido' => $_POST["apellido"],
        'fechaNacimiento' => $_POST["fechaNacimiento"],
        'genero' => $_POST["genero"],
        'pais' => $_POST["pais"],
        'provincia' => $_POST["provincia"],
        'municipio' => $_POST["municipio"],
        'email' => $_POST["email"],
        'password' => $_POST["password"],
        'rol' => 'usuario' // puedes cambiarlo por 'superusuario' o dinámico
    ];

    if ($usuario->registrar($datos)) {
        echo "✅ Registro exitoso";
    } else {
        echo "❌ Hubo un error al registrar el usuario.";
    }
}
?>
