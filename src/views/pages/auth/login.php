<?php
require_once(__DIR__ . '/procesar_login.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Login - DNI Cultural</title>
  <link rel="stylesheet" href="/ID-Cultural/static/css/main.css" />
  <link rel="stylesheet" href="/ID-Cultural/static/css/login.css" />
</head>
<body>
    <?php include("../../../../components/navbar.php"); ?>

  <main>
    <section class="login-box">
      <h2>Iniciar sesión</h2>

      <?php if (!empty($message)): ?>
        <p class="error-msg"><?= htmlspecialchars($message) ?></p>
      <?php endif; ?>

      <form action="login.php" method="post">
        <input type="hidden" name="token" value="<?= generar_token_csrf(); ?>">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" autocomplete="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" autocomplete="current-password" required>

        <input type="submit" value="Ingresar">
        <p class="forgot-pass"><a href="#">¿Olvidaste tu contraseña?</a></p>
      </form>
      <p id="mensaje-error" class="error-msg" hidden>Usuario o contraseña incorrectos.</p>
    </section>
  </main>

<?php include("../../../../components/footer.php"); ?>

  <script src="/ID-Cultural/static/js/main.js"></script>
  <script src="/ID-Cultural/static/js/navbar.js"></script>
  <script src="/ID-Cultural/static/js/login.js"></script>

</body>

</html>
