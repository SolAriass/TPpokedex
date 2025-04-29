
<?php

include_once 'config/ConexionBD.php';

use config\ConexionBD;

session_start();

$baseDeDatos = new ConexionBD();

$datos = $baseDeDatos->query("SELECT pokemones.*, tipo.* 
    FROM pokemones 
    JOIN tipo ON pokemones.tipo = tipo.idTipo");


$pokemones= [] ;


for ($i=0; $i < mysqli_num_rows($datos); $i++) {
    $fila = mysqli_fetch_array($datos);
    $pokemones[] = $fila;
}


function buscarPokemon($pokemones, $busqueda) {
    $pokemonesFiltrados = [];
    $mensaje = '';

    if ($busqueda !== '') {
        foreach ($pokemones as $poke) {
            if (stripos($poke['nombre'], $busqueda) === 0) {
                $pokemonesFiltrados[] = $poke;
            }
        }

        if (empty($pokemonesFiltrados)) {
            $mensaje = "Pokémon no encontrado. Mostrando todos los pokemones:";
        }
    }

    return array($pokemonesFiltrados, $mensaje);
}

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

    <!-- formu busqueda -->
    <form action="#" class="d-flex">
        <input type="text" name="buscador" id="buscador" placeholder="busque a el pokemon que desee" class="form-control me-2 border-ligth">
        <input type="submit" name="enviar" id="enviar" value="buscar" class="btn btn-dark">
    </form>

    <!-- Botón para agregar un nuevo Pokémon -->
    <?php if (isset($_SESSION['usuario'])): ?>
        <a href="crud/agregarPokemon.php" class="btn btn-outline-dark mt-3 w-100">Agregar Pokemon +</a>
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
                        #<?= $poke['numero'] ?> - <?= $poke['nombre'] ?> - <img src="imagenes/tiposPokemones/tipo<?= ucfirst($poke['nombreTipo']) ?>.png" style="width: 28px">
                    </h5>

                    <div class="d-flex justify-content-center align-items-center flex-grow-1 p-3">
                        <a href="vistaPokemon.php?id=<?= $poke['id'] ?>">
                        <img src="imagenes/<?= $poke['imagen'] ?>" class="img-fluid m-4" style="max-height: 150px;">
                        </a>
                    </div>

                    <div class="card-footer mt-auto">
                        <?php if (!isset($_SESSION['usuario'])): ?>
                        <p class="card-text text-center"><?= $poke['descripcion'] ?></p>

                        <?php endif; ?>
                        <!-- esto se deberia ver cuando inicia sesion -->
                        <?php if (isset($_SESSION['usuario'])): ?>
                        <div class="container d-flex justify-content-around">
                            <a href="crud/borrarPokemon.php?id=<?=$poke['id']?>" class="btn btn-outline-dark btn-eliminar"  data-id="<?= $poke['id'] ?>"">Eliminar</a>
                            <a href="crud/modificar.php?id=<?=$poke['id']?>" class="btn btn-outline-dark">Modificar</a>
                        </div>


                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<?php require("footer/footer.php")
?>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gray-700 text-white">
                <h5 class="modal-title" id="confirmarEliminarLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que querés eliminar este Pokémon?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white border rounded" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btnConfirmarEliminar" class="btn btn-dark">Eliminar</a>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const botonesEliminar = document.querySelectorAll(".btn-eliminar");
        const confirmarBtn = document.getElementById("btnConfirmarEliminar");
        const modal = new bootstrap.Modal(document.getElementById("confirmarEliminarModal"));

        let idSeleccionado = null;

        botonesEliminar.forEach(boton => {
            boton.addEventListener("click", function (e) {
                e.preventDefault();
                idSeleccionado = this.getAttribute("data-id");
                modal.show();
            });
        });

        confirmarBtn.addEventListener("click", function () {
            if (idSeleccionado) {
                window.location.href = `crud/borrarPokemon.php?id=${idSeleccionado}`;
            }
        });
    });
</script>



</body>
</html>