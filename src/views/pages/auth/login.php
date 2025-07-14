<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../../../../security/auditoria.php');   // conecta a auditoria.sqlite
require_once(__DIR__ . '/../../../../security/funciones.php');
require_once(__DIR__ . '/../../../../security/csrf.php');
require_once(__DIR__ . '/../../../../security/detectar_sql.php');
//
$pathConexion = __DIR__ . '/../config/conexion.php';
if (!file_exists($pathConexion)) {
    die("Error: No existe el archivo $pathConexion");
}
$conn = require_once($pathConexion);

//

if (!$conn instanceof PDO) {
    die("Error: La conexión a la base de datos no es válida.");
}

$conn_auditoria = conectarAuditoria();
escanear_inyecciones($conn_auditoria);

$message = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verificar_token_csrf($_POST['token'] ?? '')) {
        die("Token CSRF inválido");
    }

    $email = limpiar_entrada($_POST['email'] ?? '');
    $password = limpiar_entrada($_POST['password'] ?? '');

    if (contiene_inyeccion($email) || contiene_inyeccion($password)) {
        registrarAuditoria($conn_auditoria, null, 'Inyección SQL', 'Intento en login', "Email: '$email'");
        die("Parámetros inválidos detectados");
    }

    $stmt = $conn->prepare('SELECT id, email, password FROM usuarios WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        registrarAuditoria($conn_auditoria, $user['id'], 'Login', 'Login exitoso', 'Usuario inició sesión');
        header("Location: ../../panel.php");
        exit;
    } else {
        $message = 'Usuario o contraseña incorrectos.';
        registrarAuditoria($conn_auditoria, null, 'Login', 'Login fallido', "Email: $email / clave incorrecta");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Login - DNI Cultural</title>
     <link rel="stylesheet" href="/ID-Cultural/static/css/main.css" />
     
  <link rel="stylesheet" href="/ID-Cultural/static/css/login.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <!-- <div id="navbar"></div> -->
  <?php include __DIR__ . '/../public/components/navbar.html'; ?>
  

  <main>
    <section class="login-box">
      <h2>Iniciar sesión</h2>

      <?php if (!empty($message)): ?>
        <p id="mensaje-error" class="error-msg animate__animated animate__shakeX"><?= htmlspecialchars($message) ?></p>
      <?php endif; ?>

      <form id="loginForm" action="login.php" method="post" novalidate>
        <input type="hidden" name="token" value="<?= generar_token_csrf(); ?>">

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" placeholder="Ingrese su correo" autocomplete="username" required>

        <label for="password">Contraseña:</label>
        <div class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" autocomplete="current-password" required>
        </div>

        <input type="submit" value="Ingresar">

        <p class="forgot-pass"><a href="#">¿Olvidaste tu contraseña?</a></p>
      </form>
    </section>
  </main>

    <!-- <div id="footer"></div> -->
<?php include __DIR__ . '/../public/components/footer.html'; ?>
<script src="/ID-Cultural/static/js/main.js"></script>
</body>
</html>
