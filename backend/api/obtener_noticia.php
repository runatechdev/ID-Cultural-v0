<?php
header('Content-Type: application/json');

// ⚙️ Conexión segura
$dbPath = $_SERVER['DOCUMENT_ROOT'] . "/ID-Cultural-noticias/ID-Cultural-noticias/backend/db/database.sqlite";
$conn = new PDO("sqlite:" . $dbPath);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 🔎 Recibir ID
$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'] ?? null;

if (!$id) {
  echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
  exit;
}

// 🔍 Buscar noticia
$stmt = $conn->prepare("SELECT id, titulo, contenido, autor, imagen, fecha FROM noticias WHERE id = ?");
$stmt->execute([$id]);
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

if ($noticia) {
  echo json_encode(['status' => 'success', 'noticia' => $noticia]);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Noticia no encontrada']);
}
?>
