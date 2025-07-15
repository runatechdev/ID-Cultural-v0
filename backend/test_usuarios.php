<?php
require_once __DIR__ . '/config/connection.php';

echo "<h2>Usuarios registrados</h2>";

try {
    $stmt = $pdo->query("SELECT id, email, password, role FROM users");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($usuarios) === 0) {
        echo "<p>No hay usuarios en la base de datos.</p>";
    } else {
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>ID</th><th>Email</th><th>Password (hash)</th><th>Rol</th></tr>";

        foreach ($usuarios as $u) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($u['id']) . "</td>";
            echo "<td>" . htmlspecialchars($u['email']) . "</td>";
            echo "<td style='font-family:monospace'>" . htmlspecialchars(substr($u['password'], 0, 30)) . "…</td>";
            echo "<td>" . htmlspecialchars($u['role']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
} catch (PDOException $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
}
?>
