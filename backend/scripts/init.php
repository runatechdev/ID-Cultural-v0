<?php
require_once __DIR__ . '/../config/connection.php';

try {
    $sql = "
        CREATE TABLE IF NOT EXISTS artistas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            apellido TEXT NOT NULL,
            fecha_nacimiento TEXT NOT NULL,
            genero TEXT,
            pais TEXT,
            provincia TEXT,
            municipio TEXT,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT DEFAULT 'artista'
        );

        CREATE TABLE IF NOT EXISTS intereses_artista (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            artista_id INTEGER,
            interes TEXT,
            FOREIGN KEY (artista_id) REFERENCES artistas(id)
        );
    ";

    $pdo->exec($sql);
    echo "✅ Tablas creadas correctamente";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
