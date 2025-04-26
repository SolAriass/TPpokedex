<?php

//verificar el id
if (isset($_GET['id'])){
    $id = $_GET['id'];
}
// Conexion base de datos pokedex
$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

// Obtener datos
$datos = mysqli_query($baseDeDatos, "SELECT * FROM pokemones WHERE id = $id");

//verificar si volvio algo
if ($datos && mysqli_num_rows($datos) > 0) {
    $poke= mysqli_fetch_assoc($datos);
}
?>

<!--

<?php if ($poke): ?>
    <img src="<?= $poke['imagen'] ?>" class="img-fluid m-4" style="max-height: 150px;">
    <img src="tiposPokemones/tipo<?= ucfirst($poke['tipo']) ?>.png" style="width: 28px">
    #<?= $poke['numero'] ?> -
    <?= $poke['nombre'] ?>
    <?= $poke['descripcionLarga'] ?>
<?php endif; ?>
-->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$poke['numero'] . ' - ' . $poke['nombre'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/colores.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-200 fuente">


<div class="container d-flex justify-content-between align-items-center py-3">
    <a href="index.php">
        <img src="logos/pokebola.png" class="img-fluid rounded" style="width: 50px; height: auto;" alt="Logo">
    </a>

    <h1 class="mb-0 flex-grow-1 text-center fw-bold">Pokedex</h1>

    <button> Volver al inicio </button>
</div>

<!-- Contenido principal -->
<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
    <!-- Resto del contenido -->
    <div class="card w-75" style="max-width: 1000px;">
        <div class="row g-0">
            <?php if ($poke): ?>
                <div class="col-md-4 d-flex flex-column align-items-center justify-content-center border-end pe-4">
                    <img src="<?= $poke['imagen'] ?>" class="img-fluid rounded-start" style="max-height: 400px; object-fit: contain; padding: 20px;">
                </div>
                <div class="col-md-8 ps-4 bg-gray-400 fuentelinda">
                    <div class="card-body">
                        <h5 class="card-title fs-3 fw-bold">#<?= $poke['numero'] ?> - <?= $poke['nombre'] ?></h5>
                        <p class="card-text"><?= $poke['descripcionLarga'] ?></p>
                        <p class="card-text">
                            <strong>Tipo:</strong>
                            <img src="tiposPokemones/tipo<?= ucfirst($poke['tipo']) ?>.png" style="width: 32px;">
                        </p>
                        <p class="card-text">
                            <strong>Región:</strong> <?= $poke['region'] ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>








</body>
</html>




<!--                <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
 -->

