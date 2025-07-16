<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'] ?? null;
$titulo = $data['titulo'] ?? '';
$contenido = $data['contenido'] ?? '';

if ($id && $titulo && $contenido) {
    $conn = new PDO("sqlite:" . __DIR__ . "/../db/database.sqlite");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, contenido = ? WHERE id = ?");
    $stmt->execute([$titulo, $contenido, $id]);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
}
