<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Gestión - DNI Cultural</title>
  <link rel="stylesheet" href="../../../../static/css/normalize.css">
  <link rel="stylesheet" href="../../../../static/css/main.css">
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
<?php include("../../../../components/navbar.php"); ?>
  <header>
    <div class="logo">
      <img src="/ID-Cultural/static/img/SANTAGO-DEL-ESTERO-2022.svg" alt="Logo">
    </div>
    <nav>
      <ul>
        <li><a class="menu" href="/ID-Cultural/Index.php">Inicio </a></li>
        <li><a class="menu" href="../../../../src/views/pages/auth/login.php">Cerrar Sesión </a></li>
  <main>
    <h1>Panel de Gestión</h1>
    <ul>
  <li><a href="../../../../src/views/pages/user/abm_usuarios.html">
    <img src="../../../../static/img/perfil-del-usuario.png" alt="ABM de Usuarios" style="width:24px; height:24px;">
    ABM de Usuarios
  </a>
</li>

  <li><a href="../../../../src/views/pages/user/abm_artitistas.html">
    <img src="../../../../static/img/paleta-de-pintura.png" alt="ABM de Usuarios" style="width:24px; height:24px;">
    ABM de Artistas
  </a>
</li>

  <li><a href="../../../../src/views/pages/user/blanqueo_clave_admin.html">
    <img src="../../../../static/img/candado.png" alt="ABM de Usuarios" style="width:24px; height:24px;">
    Blanqueo de Clave(Admin)
  </a>
</li>

  
  <li><a href="../../../../src/views/pages/user/cambiar_clave.html">
    <img src="../../../../static/img/correo-electronico.png" alt="ABM de Usuarios" style="width:24px; height:24px;">
    Cambiar Clave con Correo
  </a>
</li>
    
<li><a href="../../../../src/views/pages/user/estado_solicitud.html">
    <img src="../../../../static/img/lectura.png" alt="ABM de Usuarios" style="width:24px; height:24px;">
    Ver Estado de Solicitud del Artista
  </a>

  <a class="panel-button" href="/src/views/pages/user/abm_artitistas.html">
    <img src="/static/img/paleta-de-pintura.png" alt="Artistas">
    Gestionar Artistas
  </a>

  <a class="panel-button" href="/src/views/pages/user/blanqueo_clave_admin.html">
    <img src="/static/img/candado.png" alt="Reiniciar Clave">
    Reiniciar Contraseña
  </a>

  <a class="panel-button" href="/src/views/pages/user/cambiar_clave.html">
    <img src="/static/img/correo-electronico.png" alt="Cambiar Clave">
    Cambiar por Correo
  </a>

  <a class="panel-button" href="/src/views/pages/user/estado_solicitud.html">
    <img src="/static/img/lectura.png" alt="Estado">
    Ver Solicitudes
  </a>

</div>



  </main>

 <?php include("../../../../components/footer.php"); ?>

  <script src="/ID-Cultural/static/js/main.js"></script>
  <script src="/ID-Cultural/static/js/navbar.js"></script>

</body>
</html>
