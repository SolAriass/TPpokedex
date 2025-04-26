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


//mostrar datos de pokemon(falta diseño)
<?php if ($poke): ?>
    <img src="<?= htmlspecialchars($poke['imagen']) ?>" class="img-fluid m-4" style="max-height: 150px;">
    <img src="tiposPokemones/tipo<?= ucfirst($poke['tipo']) ?>.png" style="width: 28px">
    #<?= $poke['numero'] ?> -
    <?= $poke['nombre'] ?>
    <?= $poke['descripcionLarga'] ?>
<?php endif; ?>