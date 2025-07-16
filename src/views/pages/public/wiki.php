<?php
// 1. DEFINIMOS LA RAÍZ Y CARGAMOS LA CONFIGURACIÓN
define('ROOT_PATH', realpath(__DIR__ . '/../../../../'));
require_once(ROOT_PATH . '/config.php');

// 2. LÓGICA DEL BACKEND: OBTENER Y PROCESAR ARTISTAS
// (Simulamos los datos por ahora)
$artistas_db = [
    ['id' => 1, 'nombre' => 'Juan Pérez', 'descripcion' => 'Guitarrista y compositor.', 'categoria' => 'Musica', 'imagen' => 'juanperez.jpg'],
    ['id' => 2, 'nombre' => 'Mercedes Sosa', 'descripcion' => 'Referente del folklore.', 'categoria' => 'Musica', 'imagen' => 'merce.jpg'],
    ['id' => 3, 'nombre' => 'María González', 'descripcion' => 'Escritora y poeta contemporánea.', 'categoria' => 'Literatura', 'imagen' => 'dem.jpg'],
    ['id' => 4, 'nombre' => 'Antonio Berni', 'descripcion' => 'Pintor y grabador destacado.', 'categoria' => 'Artesania', 'imagen' => 'berni.jpg'],
];

// Agrupamos los artistas por categoría
$artistas_por_categoria = [];
foreach ($artistas_db as $artista) {
    $artistas_por_categoria[$artista['categoria']][] = $artista;
}

$page_title = "Biblioteca Digital - ID Cultural";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="icon" href="<?php echo BASE_URL; ?>static/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/main.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/wiki.css" />
</head>
<body>

    <?php include(ROOT_PATH . '/components/navbar.php'); ?>

    <main class="container">

        <div class="wiki-header">
            <img src="<?php echo BASE_URL; ?>static/img/portada.png" alt="Portada Biblioteca Cultural" class="portada-wiki">
            <div class="search">
                <h2>Explora Nuestro Archivo Cultural</h2>
                <form id="form-busqueda" method="get">
                    <input type="text" placeholder="Buscar por nombre de artista..." id="search-input">
                    <select id="category-filter">
                        <option value="">Todas las categorías</option>
                        <option value="Musica">Música</option>
                        <option value="Literatura">Literatura</option>
                        <option value="Artesania">Artesanía</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="wiki-layout">

            <section class="main-content" id="biografias">
                <h2>Artistas Registrados</h2>
                <?php foreach ($artistas_por_categoria as $categoria => $artistas): ?>
                    <div class="categoria" data-category="<?php echo $categoria; ?>">
                        <h3><?php echo htmlspecialchars($categoria); ?></h3>
                        <div class="cards-container">
                            <?php foreach ($artistas as $artista): ?>
                                <div class="card" data-nombre="<?php echo strtolower(htmlspecialchars($artista['nombre'])); ?>">
                                    <img src="<?php echo BASE_URL; ?>static/img/<?php echo htmlspecialchars($artista['imagen']); ?>" alt="<?php echo htmlspecialchars($artista['nombre']); ?>">
                                    <div class="card-info">
                                        <h4><?php echo htmlspecialchars($artista['nombre']); ?></h4>
                                        <p><?php echo htmlspecialchars($artista['descripcion']); ?></p>
                                        <a href="<?php echo BASE_URL; ?>src/views/pages/public/artista.php?id=<?php echo $artista['id']; ?>" class="btn-biografia">Ver Perfil</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p id="no-results" class="no-results" hidden>No se encontraron artistas que coincidan con la búsqueda.</p>
            </section>

            <aside class="sidebar">
                <h2>🎨 Artistas Destacados</h2>
                <div class="famoso">
                    <img src="<?php echo BASE_URL; ?>static/img/merce.jpg" alt="Mercedes Sosa">
                    <div>
                        <h4>Mercedes Sosa</h4>
                        <p>Cantante y referente del folklore.</p>
                    </div>
                </div>
                <div class="famoso">
                    <img src="<?php echo BASE_URL; ?>static/img/berni.jpg" alt="Antonio Berni">
                    <div>
                        <h4>Antonio Berni</h4>
                        <p>Pintor y grabador de arte social.</p>
                    </div>
                </div>
            </aside>
            
        </div> </main>

    <?php include(ROOT_PATH . '/components/footer.php'); ?>

    <script src="<?php echo BASE_URL; ?>static/js/wiki.js"></script>
</body>
</html>