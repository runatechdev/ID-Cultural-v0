<?php
header('Content-Type: application/json');
$conn = new PDO("sqlite:" . __DIR__ . "/../db/database.sqlite");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC");
echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
