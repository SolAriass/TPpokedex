
<?php

//conexion base de datos pokedex

$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

//obtener datos

$datos = mysqli_query($baseDeDatos, "SELECT * FROM pokemones");

$pokemones= [] ;

for ($i=0; $i < mysqli_num_rows($datos); $i++) {
    $fila = mysqli_fetch_array($datos);
    // echo "Numero: " . $fila["numero"] . ' - ' . "Nombre: " . $fila["nombre"] . ' - ' . "Tipo: " . $fila["tipo"] . ' - ' . "Descripcion: " . $fila["descripcion"] . ' - ' . "Region: " . $fila["region"] . "<br />";
    $pokemones[] = $fila;
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
        <img src="logo.png" class="img-fluid rounded" style="width: 80px; height: auto;" alt="Logo">
        <h1 class="mb-0 flex-grow-1 text-center fw-bold">Pokedex</h1>
        <!--<button class="btn btn-outline-secondary">Login</button> -->
        <!-- ACA TENDRIA QUE VERSE EL USUARIO QUE SE REGISTRO Y LOGUEO -->
        <p>NOMBRE USUARIO</p>
    </div>
    <form action="#" class="d-flex">
        <input type="text" name="buscador" id="buscador" placeholder="busque a el pokemon que desee" class="form-control me-2">
        <input type="submit" name="enviar" id="enviar" value="buscar" class="btn btn-dark">
    </form>

    <a href="agregarPokemon.php">Agregar Pokemon</a>
    <div class="row mt-4">
        <?php foreach ($pokemones as $poke): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow d-flex flex-column bg-teal-300 ">
                    <h5 class="card-header text-center fw-bold bg-dark border-bottom-0 text-teal-500">
                        #<?= $poke['numero'] ?> - <?= $poke['nombre'] ?> - <img src="tiposPokemones/tipo<?= ucfirst($poke['tipo']) ?>.png" style="width: 28px">
                    </h5>

                    <div class="d-flex justify-content-center align-items-center flex-grow-1 p-3">
                        <img src="<?= $poke['imagen'] ?>" class="img-fluid m-4" style="max-height: 150px;">
                    </div>

                    <div class="card-footer mt-auto">
                        <!-- <img src="tiposPokemones/tipo<?= ucfirst($poke['tipo']) ?>.png" class="w-25">-->

                        <p class="card-text text-center"><?= $poke['descripcion'] ?></p>
                        <div class="container d-flex justify-content-around">
                            <button class="btn btn-outline-secondary">Eliminar</button>
                            <button class="btn btn-outline-secondary">Modificar</button>
                        </div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>





