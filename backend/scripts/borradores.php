<?php
require_once __DIR__ . '/../config/connection.php'; // Asegurate que $pdo esté definido

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS borradores (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario_id INTEGER NOT NULL,
        titulo TEXT NOT NULL,
        descripcion TEXT NOT NULL,
        categoria TEXT NOT NULL,
        campos_extra TEXT,
        multimedia TEXT,
        estado TEXT DEFAULT 'borrador',
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (usuario_id) REFERENCES artistas(id) ON DELETE CASCADE
    );
    ";

    $pdo->exec($sql);

    echo "✅ Tabla 'borradores' creada exitosamente.";
} catch (PDOException $e) {
    echo "❌ Error al crear la tabla: " . $e->getMessage();
}
