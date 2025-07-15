<?php
session_start();

// Solo permitir acceso a administradores
// if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
//     die("Acceso denegado.");
// }

$registros = [];  // Evita error si el try falla

try {
    // Ruta al archivo SQLite (ajustá la ruta si está en otra carpeta)
    $dbPath = __DIR__ . '/../database/auditoria.sqlite'; // o .db según tu caso

    // Conexión PDO a SQLite
    $conn = new PDO("sqlite:$dbPath");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta a la tabla auditoria
    $query = "SELECT * FROM auditoria ORDER BY fecha DESC LIMIT 100";
    $registros = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al cargar auditoría: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Auditoría - IDCultural</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      table-layout: fixed;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
      word-wrap: break-word;
    }
    th {
      background-color: #f2f2f2;
    }
    .scroll-x {
      overflow-x: auto;
    }
  </style>
</head>
<body>
  <h2>Panel de Auditoría del Sistema</h2>
  <div class="scroll-x">
    <table>
      <tr>
        <th>Fecha</th>
        <th>Usuario ID</th>
        <th>Componente</th>
        <th>Evento</th>
        <th>Descripción</th>
        <th>IP</th>
        <th>User Agent</th>
      </tr>
      <?php foreach ($registros as $fila): ?>
        <tr>
          <td><?= date('Y-m-d H:i:s', strtotime($fila['fecha'])) ?></td>
          <td><?= htmlspecialchars($fila['usuario_id']) ?></td>
          <td><?= htmlspecialchars($fila['componente']) ?></td>
          <td><?= htmlspecialchars($fila['evento']) ?></td>
          <td><?= htmlspecialchars($fila['descripcion']) ?></td>
          <td><?= htmlspecialchars($fila['ip_origen']) ?></td>
          <td><?= htmlspecialchars(substr($fila['user_agent'], 0, 70)) ?>...</td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
</html>
