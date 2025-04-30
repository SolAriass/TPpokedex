
<div class="container d-flex justify-content-between align-items-baseline my-4 flex-wrap gap-3">
  <a href="index.php">
    <img src="imagenes/logos/pokebola.png" class="img-fluid rounded" style="width: 50px; height: auto;" alt="Logo">
  </a>

  <h1 class="mb-0 flex-grow-1 text-center fw-bold">Pokedex</h1>

  <?php if (isset($_SESSION['usuario'])): ?>
    <p class="text-center"><?php echo $_SESSION['usuario']; ?></p>
    <form action="login/logout.php" method="post">
      <button type="submit" class="btn btn-dark">Cerrar sesión</button>
    </form>
  <?php else : ?>
    <a class="btn btn-dark" href="login/login.php">Iniciar sesión</a>
  <?php endif; ?>
</div>