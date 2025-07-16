<?php
// Incluimos la configuración central para la conexión y las sesiones
require_once __DIR__ . '/../config/connection.php';

// Indicamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// --- 1. Verificación de Seguridad ---
// Solo un 'validador' o 'admin' pueden ejecutar esta acción.
if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'validador'])) {
    echo json_encode(['status' => 'error', 'message' => 'Acceso no autorizado.']);
    exit();
}

// --- 2. Obtención de Datos ---
// Recibimos el ID del artista que viene desde el JavaScript
$id_artista = $_POST['id'] ?? null;

if (empty($id_artista) || !is_numeric($id_artista)) {
    echo json_encode(['status' => 'error', 'message' => 'ID de artista inválido.']);
    exit();
}

// --- 3. Operación en la Base de Datos ---
try {
    // Preparamos la consulta para actualizar el estado y la fecha de validación
    // Asumimos que la tabla se llama 'artistas', ajústalo si es necesario.
    $sql = "UPDATE artistas SET estado = ?, fecha_validacion = ? WHERE id = ?";
    
    // Obtenemos la fecha y hora actual
    $fecha_actual = date('Y-m-d H:i:s');
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['Aprobado', $fecha_actual, $id_artista]);

    // Verificamos si la actualización afectó a alguna fila
    if ($stmt->rowCount() > 0) {
        // Si se actualizó al menos una fila, la operación fue exitosa
        echo json_encode([
            'status' => 'ok', 
            'message' => 'Artista aprobado con éxito.'
        ]);
    } else {
        // Si no se afectó ninguna fila, puede que el ID no existiera
        echo json_encode([
            'status' => 'error', 
            'message' => 'No se encontró ningún artista con ese ID.'
        ]);
    }

} catch (PDOException $e) {
    // En caso de un error con la base de datos, lo registramos y devolvemos un error genérico
    error_log("Error al aprobar perfil: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Error en el servidor al procesar la solicitud.']);
}

?>