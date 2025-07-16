<?php
// 1. Definimos la ruta raíz y cargamos la configuración
define('ROOT_PATH', realpath(__DIR__ . '/../../../../'));
require_once(ROOT_PATH . '/config.php');

// 2. Lógica de seguridad: solo validadores y administradores pueden ver esta página
if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'validador'])) {
    header('Location: ' . BASE_URL . 'index.php');
    exit();
}

// 3. Obtenemos los datos desde el backend (simulamos por ahora)
// $pendientes = require_once(ROOT_PATH . '/backend/controllers/obtener_pendientes.php');
$pendientes = [
    ['id' => 101, 'nombre' => 'Artista Pendiente 1', 'disciplina' => 'Música', 'localidad' => 'La Banda'],
    ['id' => 105, 'nombre' => 'Artista Pendiente 2', 'disciplina' => 'Pintura', 'localidad' => 'Capital'],
    ['id' => 108, 'nombre' => 'Artista Pendiente 3', 'disciplina' => 'Danza', 'localidad' => 'Termas de Río Hondo'],
];

$page_title = "Panel del Validador - ID Cultural";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/main.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/dashboard.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/panel_validador.css" />
</head>

<body>

    <?php
    // 3. Incluimos el navbar desde su ubicación REAL
    include(ROOT_PATH . '/components/navbar.php');
    ?>

    <main class="container">
        <h1>Artistas Pendientes de Aprobación</h1>
        <p>Revisa los perfiles enviados por los editores y apruébalos o recházalos.</p>

        <div class="tabla-container">
            <table class="tabla-datos">
                <thead>
                    <tr>
                        <th>Nombre del Artista</th>
                        <th>Disciplina</th>
                        <th>Localidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-pendientes-body">
                    <?php if (empty($pendientes)): ?>
                        <tr>
                            <td colspan="4">No hay perfiles pendientes de validación. ¡Buen trabajo!</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pendientes as $artista): ?>
                            <tr data-id="<?php echo $artista['id']; ?>" data-nombre="<?php echo htmlspecialchars($artista['nombre']); ?>">
                                <td><?php echo htmlspecialchars($artista['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($artista['disciplina']); ?></td>
                                <td><?php echo htmlspecialchars($artista['localidad']); ?></td>
                                <td class="acciones">
                                    <button class="btn-accion btn-aprobar">Aprobar</button>
                                    <button class="btn-accion btn-rechazar">Rechazar</button>
                                    <a href="<?php echo BASE_URL; ?>src/views/pages/public/artista.php?id=<?php echo $artista['id']; ?>" class="btn-accion btn-ver" target="_blank">Ver Perfil</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="modal-rechazo" class="modal hidden">
        <div class="modal-content">
            <h2>Motivo del rechazo para <span id="nombre-artista-modal"></span></h2>
            <textarea id="input-motivo" placeholder="Es importante explicar por qué se rechaza el perfil..."></textarea>
            <div class="modal-buttons">
                <button id="btn-cancelar-modal" class="btn cancel">Cancelar</button>
                <button id="btn-confirmar-rechazo" class="btn confirm">Confirmar Rechazo</button>
            </div>
        </div>
    </div>

    <?php
    // 4. Incluimos el footer desde su ubicación REAL
    include(ROOT_PATH . '/components/footer.php');
    ?>

    <script>
        // Pasamos los datos iniciales de PHP a JavaScript
        const initialData = <?php echo json_encode($pendientes); ?>;
    </script>
    <script src="<?php echo BASE_URL; ?>static/js/panel_validador.js"></script>
</body>

</html>