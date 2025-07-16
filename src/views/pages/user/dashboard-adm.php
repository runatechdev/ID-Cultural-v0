<?php
    // Se define la URL base para que todos los enlaces funcionen correctamente.
    define('BASE_URL', '/ID-Cultural');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Gestión - DNI Cultural</title>
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/static/css/normalize.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/static/css/main.css">
  <style>
    main {
      max-width: 800px;
      margin: 40px auto;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
    }

    main h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #D50032;
      text-align: center;
    }

    main ul {
      list-style: none;
      padding: 0;
    }

    main ul li {
      margin: 15px 0;
    }

    main ul li a {
      display: block;
      padding: 15px;
      background-color: #0075c4;
      color: #fff;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    main ul li a:hover {
      background-color: #005999;
      transform: scale(1.02);
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">
      <img src="<?php echo BASE_URL; ?>/static/img/SANTAGO-DEL-ESTERO-2022.svg" alt="Logo Santiago del Estero">
    </div>
    <nav>
      <ul>
        <li><a class="menu" href="<?php echo BASE_URL; ?>/index.php">Inicio</a></li>
        <li><a class="menu" href="<?php echo BASE_URL; ?>/src/views/pages/auth/login.php">Cerrar Sesión</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Panel de Gestión</h1>
    <ul>
      <li><a href="<?php echo BASE_URL; ?>/src/views/pages/user/abm_usuarios.php">
        <img src="<?php echo BASE_URL; ?>/static/img/perfil-del-usuario.png" alt="ABM de Usuarios" style="width:24px; height:24px; vertical-align: middle; margin-right: 10px;">
        ABM de Usuarios
      </a></li>
      <li><a href="<?php echo BASE_URL; ?>/src/views/pages/user/abm_artitistas.php">
        <img src="<?php echo BASE_URL; ?>/static/img/paleta-de-pintura.png" alt="ABM de Artistas" style="width:24px; height:24px; vertical-align: middle; margin-right: 10px;">
        ABM de Artistas
      </a></li>
      <li><a href="<?php echo BASE_URL; ?>/src/views/pages/user/blanqueo_clave_admin.php">
        <img src="<?php echo BASE_URL; ?>/static/img/candado.png" alt="Blanqueo de Clave" style="width:24px; height:24px; vertical-align: middle; margin-right: 10px;">
        Blanqueo de Clave (Admin)
      </a></li>
      <li><a href="<?php echo BASE_URL; ?>/src/views/pages/user/cambiar_clave.php">
        <img src="<?php echo BASE_URL; ?>/static/img/correo-electronico.png" alt="Cambiar Clave" style="width:24px; height:24px; vertical-align: middle; margin-right: 10px;">
        Cambiar Clave con Correo
      </a></li>
      <li><a href="<?php echo BASE_URL; ?>/src/views/pages/user/estado_solicitud.php">
        <img src="<?php echo BASE_URL; ?>/static/img/lectura.png" alt="Estado de Solicitud" style="width:24px; height:24px; vertical-align: middle; margin-right: 10px;">
        Ver Estado de Solicitud del Artista
      </a></li>
    </ul>
  </main>

  <div id="footer">
      <?php include __DIR__ . '/../../../../components/footer.php'; ?>
  </div>

  <script src="<?php echo BASE_URL; ?>/static/js/main.js"></script>
</body>
</html>