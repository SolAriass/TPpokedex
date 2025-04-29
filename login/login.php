<?php
session_start();

// Si ya está logueado, redirigir a la página principal
if (isset($_SESSION['usuario'])) {
  header("Location: ../index.php");
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
  <link href="../css/colores.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
        background: linear-gradient(to bottom, #eeeeee, #aaaaaa);
    }

    .login-container {
      max-width: 600px;
      padding: 40px;
      border-radius: 15px;
    }

    .logo {
      width: 80px;
      height: auto;
      margin-bottom: 20px;
    }

  </style>
</head>

<body class="bg-gray-200">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="login-container text-center bg-gray-400 shadow-lg">
    <a href="../index.php">
        <img src="../imagenes/logos/pokemonLogo.png" class="logo" alt="Logo Pokedex">
    </a>


    <h2 class="fw-bold mb-4">Iniciar sesión</h2>
<!--
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

-->
      <form action="procesar_login.php" method="POST">
          <div class="form-group">
              <label for="usuario">Usuario</label>
              <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Usuario" required>
          </div>
          <div class="form-group">
              <label for="pass" class="pt-2">Contraseña</label>
              <input type="password" name="pass" class="form-control" id="pass" placeholder="Contraseña" required>
          </div>
          <br>
          <button type="submit" class="btn btn-dark w-100">Entrar</button>
      </form>


      <?php if (isset($_GET['error'])): ?>
          <p class="mt-4">Usuario o contraseña incorrectos</p>
          <a href="../index.php" class="link">Volver al home</a>
      <?php endif; ?>
  </div>
</div>

</body>
</html>
