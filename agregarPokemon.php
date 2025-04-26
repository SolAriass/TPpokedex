
<?php

$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["tipo"]) && isset($_POST["region"]) &&
    isset($_POST["numero"]) && isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {

        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $tipo = $_POST["tipo"];

        $nombreImagen = $_FILES["imagen"]["name"]; //nombre archivo
        $rutaTemporal = $_FILES["imagen"]["tmp_name"];
        $carpetaNueva = 'fotoPokemones/';

        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nuevoNombreArchivo = ucfirst($nombre) . '.' . $extension;
        move_uploaded_file($rutaTemporal, $carpetaNueva.$nuevoNombreArchivo);

        $numero = $_POST["numero"];
        $region = $_POST["region"];

        $imagen = 'fotoPokemones/' . $_POST["nombre"] . ".png";


        $query = "INSERT INTO pokemones (numero, nombre, imagen, tipo, descripcion, region)
              VALUES ('$numero', '$nombre', '$imagen', '$tipo', '$descripcion', '$region')";

        mysqli_query($baseDeDatos, $query);


        header("Location: vistaAdmin.php");
        exit();
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar pokemon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/colores.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <style>
        h1 {
            font-family: 'Montserrat';
        }
        input::placeholder{
            color: white !important;
        }

    </style>
</head>
<body class="bg-green-200">
<h1 class="text-center m-4">Ingrese los datos para agregar a su pokemon!</h1>
<div class="container w-50">
<form action="agregarPokemon.php" method="post" enctype="multipart/form-data">
    <div class="mb-3 mt-3">
        <label for="numero" class="form-label fw-bold">PokeNumero:</label>
        <input type="number" class="form-control bg-black transparencia border-black text-white" id="numero" placeholder="ingrese el numero del pokemon" name="numero">
    </div>
    <div class="mb-3 mt-3">
        <label for="nombre" class="form-label fw-bold">PokeNombre:</label>
        <input type="text" class="form-control bg-black transparencia border-black text-white" id="nombre" placeholder="ingrese el nombre del pokemon" name="nombre">
    </div>
    <div class="mb-3 mt-3">
        <label for="imagen" class="form-label fw-bold">PokeImagen:</label>
        <input type="file" class="form-control bg-black transparencia border-black text-white" id="imagen" name="imagen">
    </div>
    <div class="mb-3 mt-3">
        <label for="descripcion" class="form-label fw-bold">PokeDescripcion:</label>
        <input type="text" class="form-control bg-black transparencia border-black text-white" id="descripcion" placeholder="ingrese la descripcion del pokemon" name="descripcion">
    </div>
    <div class="mb-3 mt-3">
        <label for="region" class="form-label fw-bold">PokeRegion:</label>
        <input type="text" class="form-control bg-black transparencia border-black text-white" id="region" placeholder="ingrese la region del pokemon" name="region">
    </div>
    <div class="mb-3 mt-3">
        <label for="tipo" class="form-label fw-bold ">PokeTipo:</label>
        <select class="form-select bg-black transparencia border-black text-white" name="tipo" id="tipo">
            <option value="0" selected disabled>seleccionar un tipo de pokemon</option>
            <option value="agua">agua</option>
            <option value="fuego">fuego</option>
            <option value="bicho">bicho</option>
            <option value="planta">planta</option>
            <option value="eléctrico">eléctrico</option>
            <option value="normal">normal</option>
            <option value="hada">hada</option>
            <option value="tierra">tierra</option>
            <option value="veneno">veneno</option>
        </select>

    </div>

    <button type="submit" class="btn btn-dark">Agregue su pokemon</button>
</form>
</div>
</body>
</html>
