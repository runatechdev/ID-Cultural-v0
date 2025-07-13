<?php
try {
    // Conexión a la base de datos
    $db = new PDO('sqlite:database/usuarios.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Eliminar todos los registros de usuarios
    $sqlUsuarios = "DELETE FROM usuarios";
    $stmtUsuarios = $db->prepare($sqlUsuarios);
    $stmtUsuarios->execute();

    // Eliminar todos los registros de intereses_usuario
    $sqlIntereses = "DELETE FROM intereses_usuario";
    $stmtIntereses = $db->prepare($sqlIntereses);
    $stmtIntereses->execute();

    echo "Todos los registros fueron eliminados correctamente.";
} catch (PDOException $e) {
    echo "Error al eliminar registros: " . $e->getMessage();
}
?>
