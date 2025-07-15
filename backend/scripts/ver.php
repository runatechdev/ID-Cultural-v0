<?php
require_once __DIR__ . '/../config/connection.php';

$result = $pdo->query("SELECT email, role FROM users");
foreach ($result as $row) {
  echo $row['email'] . ' (' . $row['role'] . ')<br>';
}
?>
