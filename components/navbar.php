<?php
// Nos aseguramos de que la sesión esté iniciada.
// Esto debería estar en tu config.php para que se ejecute en todas las páginas.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluimos la configuración para tener acceso a BASE_URL
// La ruta puede variar dependiendo desde dónde incluyas el navbar.
// Una mejor práctica es definir una constante de ruta raíz en config.php
// define('ROOT_PATH', dirname(__DIR__));
// require_once(ROOT_PATH . '/config.php');
require_once(__DIR__ . '/../config.php');

?>

<header class="navbar">
    <div class="logo">
        <a href="<?php echo BASE_URL; ?>index.php">
            <img src="<?php echo BASE_URL; ?>static/img/SANTAGO-DEL-ESTERO-2022.svg" alt="Logo ID Cultural">
        </a>
    </div>
    <h1 class="title">ID Cultural</h1>
    <nav class="animate__animated animate__fadeInDown">
        <ul>
            <?php if (isset($_SESSION['user_id'])): // SI EL USUARIO INICIÓ SESIÓN ?>
                
                <li><a class="menu" href="<?php echo BASE_URL; ?>index.php">
                    <i data-lucide="house"></i> Inicio
                </a></li>

                <?php // Mostramos enlaces específicos según el ROL del usuario
                switch ($_SESSION['user_role']) {
                    case 'admin':
                        echo '<li><a class="menu" href="' . BASE_URL . 'src/views/pages/admin/dashboard-adm.php">Panel Admin</a></li>';
                        break;
                    case 'editor':
                        echo '<li><a class="menu" href="' . BASE_URL . 'src/views/pages/editor/panel_editor.php">Panel Editor</a></li>';
                        break;
                    case 'validador':
                        echo '<li><a class="menu" href="' . BASE_URL . 'src/views/pages/validator/panel_validador.php">Panel Validador</a></li>';
                        break;
                }
                ?>
                
                <li><a class="menu" href="<?php echo BASE_URL; ?>backend/controllers/logout.php">Cerrar Sesión</a></li>

            <?php else: // SI EL USUARIO ES UN INVITADO (NO INICIÓ SESIÓN) ?>

                <li><a class="menu" href="<?php echo BASE_URL; ?>index.php">
                    <i data-lucide="house"></i> Inicio
                </a></li>
                <li><a class="menu" href="<?php echo BASE_URL; ?>src/views/pages/public/wiki.php">Wiki de artistas</a></li>
                <li><a class="menu" href="<?php echo BASE_URL; ?>src/views/pages/auth/login.php">Iniciar Sesión</a></li>
                <li><a class="btn" href="<?php echo BASE_URL; ?>src/views/pages/auth/registro.php">Crear cuenta</a></li>

            <?php endif; ?>
        </ul>
    </nav>
</header>