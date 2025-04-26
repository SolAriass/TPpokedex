<?php
session_start();

// Si ya está logueado, redirigir a la página principal
if (isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit();
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesión - Pokedex</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/colores.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <style>
    body {
      background-color: #d1fae5;
      font-family: 'Montserrat', sans-serif;
    }

    .login-container {
      max-width: 600px;
      padding: 40px;
      background: white;
      border-radius: 15px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .logo {
      width: 80px;
      height: auto;
      margin-bottom: 20px;
    }

    .btn-login {
      background-color: #0d6efd;
      color: white;
    }

    .btn-login:hover {
      background-color: #0b5ed7;
    }
  </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="login-container text-center">
    <img src="logo.png" class="logo" alt="Logo Pokedex">

    <h2 class="fw-bold mb-4">Iniciar sesión</h2>

    <form action="procesar_login.php" method="POST">
      <div class="form-floating mb-3">
        <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario" required>
        <label for="usuario">Usuario</label>
      </div>

      <div class="form-floating mb-4">
        <input type="password" name="pass" class="form-control" id="pass" placeholder="Contraseña" required>
        <label for="pass">Contraseña</label>
      </div>

      <button type="submit" class="btn btn-login w-100">Entrar</button>
    </form>
    <?php if (isset($_GET['error'])): ?>
      <p class="mt-4">Usuario o contraseña incorrectos</p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
