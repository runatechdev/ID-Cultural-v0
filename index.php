<?php
// 1. Define la ruta raíz del proyecto.
define('ROOT_PATH', __DIR__);

// 2. Incluye la configuración.
require_once(ROOT_PATH . '/config.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DNI Cultural</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/main.css" />
</head>
<body>
    
    <?php 
    // 3. Incluimos el navbar desde su ubicación REAL
    include(ROOT_PATH . '/components/navbar.php'); 
    ?>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Bienvenidos a ID Cultural</h1>
                <p><strong>ID Cultural</strong> es una plataforma digital dedicada a visibilizar, preservar y promover la identidad artística y cultural de Santiago del Estero...</p>
                <h2>¿Qué podés hacer en ID Cultural?</h2>
                <ul>
                    <li>Buscar artistas por nombre, disciplina, género o localidad.</li>
                    </ul>
            </div>
            <div class="hero-image">
                <picture>
                    <source srcset="<?php echo BASE_URL; ?>static/img/logo.jpg" type="image">
                    <img src="<?php echo BASE_URL; ?>static/img/logo.jpg" alt="Casa Castro" loading="lazy" />
                </picture>
            </div>
        </section>
        
        <section id="noticias-recientes" class="noticias-home">
            <h2>Últimas Noticias</h2>
            <div id="contenedor-noticias"></div>
        </section>
    </main>

    <?php
    // 4. Incluimos el footer desde su ubicación REAL
    include(ROOT_PATH . '/components/footer.php');
    ?>

    <script src="<?php echo BASE_URL; ?>static/js/main.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php /* El navbar.js no es necesario si la lógica ya está en otro lado o no se usa */ ?>
</body>
</html>