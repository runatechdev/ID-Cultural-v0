<?php
header('Content-Type: application/json');

// ⚙️ Conexión segura
$dbPath = $_SERVER['DOCUMENT_ROOT'] . "/ID-Cultural/backend/db/database.sqlite";
$conn = new PDO("sqlite:" . $dbPath);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 📝 Validaciones
$titulo = $_POST['titulo'] ?? '';
$contenido = $_POST['contenido'] ?? '';
$autor = $_POST['autor'] ?? 'Editor';
$id = $_POST['id'] ?? null;
$errores = [];

if (!$titulo || !$contenido) {
  echo json_encode(['status' => 'error', 'message' => 'Título y contenido son obligatorios']);
  exit;
}

// 🖼️ Subida de imagen opcional
$imagenRuta = null;
if (!empty($_FILES['imagen']['name'])) {
  $tipo = $_FILES['imagen']['type'];
  $peso = $_FILES['imagen']['size'];
  $permitidos = ['image/jpeg', 'image/png', 'image/webp'];

  if (!in_array($tipo, $permitidos)) $errores[] = 'Formato de imagen inválido.';
  if ($peso > 2 * 1024 * 1024) $errores[] = 'Imagen demasiado grande. Máximo 2MB.';

  if (empty($errores)) {
    $nombreSeguro = uniqid('img_') . '_' . basename($_FILES['imagen']['name']);
    $rutaDestino = $_SERVER['DOCUMENT_ROOT'] . "/ID-Cultural-noticias/ID-Cultural-noticias/backend/uploads/" . $nombreSeguro;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
      $imagenRuta = "uploads/" . $nombreSeguro;
    } else {
      $errores[] = 'Error al subir la imagen.';
    }
  }
}

if (!empty($errores)) {
  echo json_encode(['status' => 'error', 'message' => implode(' ', $errores)]);
  exit;
}

// 🗃️ Guardar o actualizar
try {
  if ($id) {
    // Edición
    if ($imagenRuta) {
      $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, contenido = ?, autor = ?, imagen = ? WHERE id = ?");
      $stmt->execute([$titulo, $contenido, $autor, $imagenRuta, $id]);
    } else {
      $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, contenido = ?, autor = ? WHERE id = ?");
      $stmt->execute([$titulo, $contenido, $autor, $id]);
    }
    echo json_encode(['status' => 'success', 'message' => 'Noticia actualizada']);
  } else {
    // Alta
    $stmt = $conn->prepare("INSERT INTO noticias (titulo, contenido, autor, imagen) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titulo, $contenido, $autor, $imagenRuta]);
    echo json_encode(['status' => 'success', 'message' => 'Noticia guardada']);
  }
} catch (PDOException $e) {
  echo json_encode(['status' => 'error', 'message' => 'Base bloqueada o ruta incorrecta: ' . $e->getMessage()]);
}
?>
