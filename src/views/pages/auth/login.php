<?php
// 1. Definimos la ruta raíz del proyecto y cargamos la configuración
define('ROOT_PATH', realpath(__DIR__ . '/../../../../'));
require_once(ROOT_PATH . '/config.php');

$page_title = "Login - DNI Cultural";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/main.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>static/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>

    <?php 
    // 2. Incluimos el navbar con la ruta absoluta
    include(ROOT_PATH . '/components/navbar.php'); 
    ?>

    <main>
        <section class="login-box">
            <h2>Iniciar sesión</h2>
            <form id="loginForm" novalidate>
                <label for="email">Correo:</label>
                <input type="text" id="email" name="email" placeholder="Ingrese su correo" autocomplete="email" required />

                <label for="password">Contraseña:</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Ingrese su contraseña"
                           autocomplete="current-password" required>
                </div>

                <input type="submit" value="Ingresar">

                <p class="forgot-pass"><a href="#">¿Olvidaste tu contraseña?</a></p>
            </form>

            <p id="mensaje-error" class="error-msg" hidden>Usuario o contraseña incorrectos.</p>
        </section>
    </main>

    <?php 
    // 3. Incluimos el footer con la ruta absoluta
    include(ROOT_PATH . '/components/footer.php'); 
    ?>

    <script src="<?php echo BASE_URL; ?>static/js/main.js"></script>
    <script src="<?php echo BASE_URL; ?>static/js/login.js"></script>
</body>
</html>