<?php
header('Content-Type: application/json');

// ⚙️ Conexión segura
$dbPath = $_SERVER['DOCUMENT_ROOT'] . "/ID-Cultural-noticias/ID-Cultural-noticias/backend/db/database.sqlite";
$conn = new PDO("sqlite:" . $dbPath);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 🗃️ Recibir ID
$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'] ?? null;

if (!$id) {
  echo json_encode(['status' => 'error', 'message' => 'ID no proporcionado']);
  exit;
}

// 🖼️ Obtener imagen antes de borrar
$stmtImg = $conn->prepare("SELECT imagen FROM noticias WHERE id = ?");
$stmtImg->execute([$id]);
$noticia = $stmtImg->fetch(PDO::FETCH_ASSOC);

// 🗑️ Eliminar noticia
$stmt = $conn->prepare("DELETE FROM noticias WHERE id = ?");
$stmt->execute([$id]);

// 🔥 Eliminar imagen si existe
if (!empty($noticia['imagen'])) {
  $rutaImg = $_SERVER['DOCUMENT_ROOT'] . "/ID-Cultural-noticias/ID-Cultural-noticias/backend/" . $noticia['imagen'];
  if (file_exists($rutaImg)) unlink($rutaImg);
}

echo json_encode(['status' => 'success', 'message' => 'Noticia eliminada']);
?>
