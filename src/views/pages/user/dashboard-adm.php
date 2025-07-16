<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Gestión - DNI Cultural</title>
  <link rel="stylesheet" href="/ID-Cultural/static/css/normalize.css">
  <link rel="stylesheet" href="/ID-Cultural/static/css/main.css">
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

  <main>
    <h1>Panel de Gestión</h1>
    <ul>
      <li>
        <a href="/ID-Cultural/src/views/pages/user/abm_usuarios.html">
          <img src="/ID-Cultural/static/img/perfil-del-usuario.png" alt="ABM de Usuarios" style="width:24px; height:24px; vertical-align:middle; margin-right:8px;">
          ABM de Usuarios
        </a>
      </li>
      <li>
        <a href="/ID-Cultural/src/views/pages/user/abm_artitistas.html">
          <img src="/ID-Cultural/static/img/paleta-de-pintura.png" alt="ABM de Artistas" style="width:24px; height:24px; vertical-align:middle; margin-right:8px;">
          ABM de Artistas
        </a>
      </li>
      <li>
        <a href="/ID-Cultural/src/views/pages/user/blanqueo_clave_admin.html">
          <img src="/ID-Cultural/static/img/candado.png" alt="Blanqueo de Clave" style="width:24px; height:24px; vertical-align:middle; margin-right:8px;">
          Blanqueo de Clave (Admin)
        </a>
      </li>
      <li>
        <a href="/ID-Cultural/src/views/pages/user/cambiar_clave.html">
          <img src="/ID-Cultural/static/img/correo-electronico.png" alt="Cambiar Clave" style="width:24px; height:24px; vertical-align:middle; margin-right:8px;">
          Cambiar Clave con Correo
        </a>
      </li>
      <li>
        <a href="/ID-Cultural/src/views/pages/user/estado_solicitud.html">
          <img src="/ID-Cultural/static/img/lectura.png" alt="Estado de Solicitud" style="width:24px; height:24px; vertical-align:middle; margin-right:8px;">
          Ver Estado de Solicitud del Artista
        </a>
      </li>
    </ul>
  </main>

  <?php include("../../../../components/footer.php"); ?>

  <script src="/ID-Cultural/static/js/main.js"></script>
  <script src="/ID-Cultural/static/js/navbar.js"></script>
</body>
</html>
