
<?php

include_once 'config/ConexionBD.php';

use config\ConexionBD;

session_start();

//conexion base de datos pokedex
$baseDeDatos = new ConexionBD();

//obtener datos

$datos = $baseDeDatos->query("SELECT * FROM pokemones");


//conexion base de datos pokedex

$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

//obtener datos

//$datos = mysqli_query($baseDeDatos, "SELECT * FROM pokemones");

$pokemones= [] ;

for ($i=0; $i < mysqli_num_rows($datos); $i++) {
    $fila = mysqli_fetch_array($datos);
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
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        h1 {
            font-family: "Exo 2";
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }
        .hover-grow {
            transition: transform 0.3s ease;
        }
        .hover-grow:hover {
            transform: scale(1.05);
        }
        input::placeholder{
            color: black !important;
            opacity: 0.5 !important;
        }

    </style>
</head>
<body class="bg-gray-200 fuente">

<div class="container mt-4">
    <div class="container d-flex justify-content-between align-items-baseline my-4 flex-wrap gap-3">
        <a href="index.php">
            <img src="logos/pokebola.png" class="img-fluid rounded" style="width: 50px; height: auto;" alt="Logo">
        </a>

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

    <!-- formu busqueda -->
    <form action="#" class="d-flex">
        <input type="text" name="buscador" id="buscador" placeholder="busque a el pokemon que desee" class="form-control me-2 border-ligth">
        <input type="submit" name="enviar" id="enviar" value="buscar" class="btn btn-dark">
    </form>

    <!-- Botón para agregar un nuevo Pokémon -->
    <?php if (isset($_SESSION['usuario'])): ?>
        <a href="agregarPokemon.php" class="btn btn-outline-dark mt-3 w-100">Agregar Pokemon +</a>
    <?php endif; ?>

    <!-- Mensaje si no se encuentran resultados -->
    <?php if ($mensaje): ?>
        <div class="alert alert-warning mt-4 text-center"><?= $mensaje ?></div>
    <?php endif; ?>

    <!-- Mostrar los resultados de la búsqueda o todos los pokemones -->
    <div class="row mt-4">
        <?php foreach ($pokemonesFiltrados as $poke): ?>
            <div class="col-md-4 mb-4">
                <div class="card hover-grow h-100 shadow-lg d-flex flex-column bg-gray-400 fuentelinda">

                    <h5 class="card-header text-center fw-bold bg-white border-bottom-0">
                        #<?= $poke['numero'] ?> - <?= $poke['nombre'] ?> - <img src="tiposPokemones/tipo<?= ucfirst($poke['tipo']) ?>.png" style="width: 28px">
                    </h5>

                    <div class="d-flex justify-content-center align-items-center flex-grow-1 p-3">
                        <a href="vistaPokemon.php?id=<?= $poke['id'] ?>">
                        <img src="<?= $poke['imagen'] ?>" class="img-fluid m-4" style="max-height: 150px;">
                        </a>
                    </div>

                    <div class="card-footer mt-auto">
                        <p class="card-text text-center"><?= $poke['descripcion'] ?></p>

                        <!-- esto se deberia ver cuando inicia sesion -->
                        <?php if (isset($_SESSION['usuario'])): ?>
                        <div class="container d-flex justify-content-around">


                        <form action="borrarPokemon.php" method="post" enctype="multipart/form-data" class="" id="formEliminar" onsubmit="return confirm('¿Seguro que desea eliminar a <?=$poke['nombre'] ?>?')">
                            <input type="hidden" value="<?=$poke['id']?>" name="idPoke">
                            <input type="hidden" value="<?=$poke['nombre']?>" name="nombrepoke">

                            <input class="btn btn-outline-dark" type="submit" name="eliminar" id="eliminar" value="Eliminar">
                        </form>

                        <a href="modificar.php?id=<?=$poke['id']?>" class="btn btn-outline-dark">Modificar</a>
                        </div>


                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>