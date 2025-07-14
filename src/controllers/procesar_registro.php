<?php
echo "🟡 Iniciando registro...<br>";

require_once __DIR__ . '/../database/db.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../security/auditoria.php';

echo "🟢 Archivos requeridos OK.<br>";

$usuario = new Usuario($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "📩 Datos recibidos por POST.<br>";

    if ($_POST["email"] !== $_POST["confirmarEmail"] || $_POST["password"] !== $_POST["confirmarPassword"]) {
        echo "❌ El correo o la contraseña no coinciden.";
        exit;
    }

    if ($usuario->emailExiste($_POST["email"])) {
        echo "⚠️ El correo ya está registrado.";
        exit;
    }

    $datos = [
        'nombre' => $_POST["nombre"],
        'apellido' => $_POST["apellido"],
        'fecha_nacimiento' => $_POST["fechaNacimiento"],
        'genero' => $_POST["genero"],
        'pais' => $_POST["pais"],
        'provincia' => $_POST["provincia"],
        'municipio' => $_POST["municipio"],
        'email' => $_POST["email"],
        'password' => $_POST["password"]
    ];

    echo "🧩 Datos preparados. Intentando registrar usuario...<br>";

    if ($usuario->registrar($datos)) {
        echo "✅ Registro exitoso<br>";

        $conn_auditoria = conectarAuditoria();
        registrarAuditoria($conn_auditoria, null, 'Registro', 'Registro Exitoso', 'Todos los pasos completados para el email: ' . $_POST["email"]);
        echo "📝 Auditoría registrada.<br>";
    } else {
        echo "❌ Hubo un error al registrar el usuario.<br>";
    }
} else {
    echo "🚫 No se recibió POST.<br>";
}
?>
