<?php
header('Content-Type: application/json');

// ⚙️ Conexión segura
$dbPath = $_SERVER['DOCUMENT_ROOT'] . "/ID-Cultural/backend/db/database.sqlite";
$conn = new PDO("sqlite:" . $dbPath);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 🔍 Obtener la última noticia
$stmt = $conn->query("SELECT * FROM noticias ORDER BY fecha DESC LIMIT 1");
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

if ($noticia) {
  echo json_encode(['status' => 'success', 'noticia' => $noticia]);
} else {
  echo json_encode(['status' => 'empty', 'message' => 'No hay noticias en la base']);
}
?>
