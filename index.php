<?php

include_once 'config/ConexionBD.php';

use config\ConexionBD;

session_start();

//conexion base de datos pokedex
$baseDeDatos = new ConexionBD();

//obtener datos
//$datos = mysqli_query($baseDeDatos, "SELECT * FROM pokemones");
$datos = $baseDeDatos->query("SELECT * FROM pokemones");

$pokemones = [];

for ($i = 0; $i < mysqli_num_rows($datos); $i++) {
  $fila = mysqli_fetch_array($datos);
  // echo "Numero: " . $fila["numero"] . ' - ' . "Nombre: " . $fila["nombre"] . ' - ' . "Tipo: " . $fila["tipo"] . ' - ' . "Descripcion: " . $fila["descripcion"] . ' - ' . "Region: " . $fila["region"] . "<br />";
  $pokemones[] = $fila;
}

include "buscar_pokemon.php";

// Variables por defecto
$pokemonesFiltrados = $pokemones;
$mensaje = '';

if (isset($_GET['buscador']) && $_GET['buscador'] !== '') {
  $resultados = buscarPokemon($pokemones, $_GET['buscador']);
  $pokemonesFiltrados = $resultados[0];
  $mensaje = $resultados[1];

  if (empty($pokemonesFiltrados)) {
    $mensaje = "Pokémon no encontrado. Mostrando todos los pokemones:";
    $pokemonesFiltrados = $pokemones;
  }
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pokedex</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/colores.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <style>
    h1 {
      font-family: 'Montserrat';
    }
  </style>
</head>
<body class="bg-green-200">

<div class="container mt-4">
  <div class="container d-flex justify-content-between align-items-center my-4 flex-wrap gap-3">
    <a href="index.php"><img src="logo.png" class="img-fluid rounded" style="width: 80px; height: auto;" alt="Logo"></a>
    <h1 class="mb-0 flex-grow-1 text-center fw-bold">Pokedex</h1>
    <?php if (isset($_SESSION['usuario'])): ?>
      <p class="text-center"><?php echo $_SESSION['usuario']; ?></p>
      <form action="logout.php" method="post">
        <button type="submit" class="btn btn-dark">Cerrar sesión</button>
      </form>
    <?php else : ?>
      <a class="btn btn-dark" href="login.php">Iniciar sesión</a>
    <?php endif; ?>
  </div>

  <!-- Formulario de búsqueda -->
  <form action="" class="d-flex">
    <input type="text" name="buscador" id="buscador" placeholder="Busque al Pokémon que desee"
           class="form-control me-2">
    <input type="submit" name="enviar" id="enviar" value="Buscar" class="btn btn-dark">
  </form>

  <!-- Mensaje si no se encuentran resultados -->
  <?php if ($mensaje): ?>
    <div class="alert alert-warning mt-4 text-center"><?= $mensaje ?></div>
  <?php endif; ?>

  <!-- Botón para agregar un nuevo Pokémon -->
  <?php if (isset($_SESSION['usuario'])): ?>
    <div class="d-flex justify-content-center mt-4">
      <a href="agregar_pokemon.php" class="btn btn-success">Agregar Nuevo Pokémon</a>
    </div>
  <?php endif; ?>

  <!-- Mostrar los resultados de la búsqueda o todos los pokemones -->
  <div class="row mt-4">
    <?php foreach ($pokemonesFiltrados as $poke): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow d-flex flex-column bg-teal-300 ">
          <h5 class="card-header text-center fw-bold bg-dark border-bottom-0 text-teal-500">
            #<?= $poke['numero'] ?> - <?= $poke['nombre'] ?> -
            <img src="tiposPokemones/tipo<?= ucfirst($poke['tipo']) ?>.png" style="width: 28px">
          </h5>

          <div class="d-flex justify-content-center align-items-center flex-grow-1 p-3">
            <img src="<?= $poke['imagen'] ?>" class="img-fluid m-4" style="max-height: 150px;">
          </div>

          <div class="card-footer mt-auto">
            <p class="card-text text-center"><?= $poke['descripcion'] ?></p>
            <?php if (isset($_SESSION['usuario'])): ?>
              <div class="container d-flex justify-content-around">
                <button class="btn btn-outline-secondary">Eliminar</button>
                <button class="btn btn-outline-secondary">Modificar</button>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>
