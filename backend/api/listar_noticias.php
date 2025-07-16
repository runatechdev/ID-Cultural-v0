<?php
header('Content-Type: application/json');

try {
  $dbPath = $_SERVER['DOCUMENT_ROOT'] . "/ID-Cultural/backend/db/database.sqlite";
  $conn = new PDO("sqlite:" . $dbPath);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Crear tabla si no existe
  $conn->exec("
    CREATE TABLE IF NOT EXISTS noticias (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      titulo TEXT NOT NULL,
      contenido TEXT NOT NULL,
      autor TEXT,
      imagen TEXT,
      fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
  ");

  // Listar noticias
  $stmt = $conn->query("SELECT id, titulo, contenido, autor, imagen, fecha FROM noticias ORDER BY fecha DESC");
  echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  
} catch (PDOException $e) {
  echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
