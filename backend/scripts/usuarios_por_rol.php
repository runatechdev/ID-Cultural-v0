<?php
require_once __DIR__ . '/../config/connection.php';

try {
    // Crear tabla si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT UNIQUE,
        password TEXT,
        role TEXT
    )");

    // Usuarios por rol
    $usuarios = [
        [
            "email" => "admin@idcultural.com",
            "password" => password_hash("admin123", PASSWORD_DEFAULT),
            "role" => "admin"
        ],
        [
            "email" => "editor@idcultural.com",
            "password" => password_hash("editor123", PASSWORD_DEFAULT),
            "role" => "editor"
        ],
        [
            "email" => "validador@idcultural.com",
            "password" => password_hash("validador123", PASSWORD_DEFAULT),
            "role" => "validador"
        ]
    ];

    $stmt = $pdo->prepare("INSERT OR IGNORE INTO users (email, password, role) VALUES (:email, :password, :role)");

    foreach ($usuarios as $usuario) {
        $stmt->execute($usuario);
    }

    echo "✅ Usuarios cargados correctamente.";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
