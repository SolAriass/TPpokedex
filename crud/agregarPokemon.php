<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}


$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["nombre"]) && isset($_POST["descripcion"]) && isset($_POST["tipo"]) && isset($_POST["region"]) &&
    isset($_POST["numero"]) && isset($_POST['descripcionLarga']) && isset($_FILES["imagen"]) && isset($_POST["categoria"]) && isset($_POST["habilidad"]) && $_FILES["imagen"]["error"] == 0) {

        $nombre = $_POST["nombre"];
        $descripcion = $_POST["descripcion"];
        $tipo = $_POST["tipo"];
        $descripcionLarga = $_POST["descripcionLarga"];


        $importante = '../imagenes';
        $nombreImagen = $_FILES["imagen"]["name"]; //nombre archivo
        $rutaTemporal = $_FILES["imagen"]["tmp_name"];

        $carpetaNueva = '/fotoPokemones/';

        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nuevoNombreArchivo = ucfirst($nombre) . '.' . $extension;
        move_uploaded_file($rutaTemporal, $importante.$carpetaNueva.$nuevoNombreArchivo);

        $numero = $_POST["numero"];
        $region = $_POST["region"];
        $categoria = $_POST["categoria"];
        $habilidad = $_POST["habilidad"];

        $imagen = 'fotoPokemones/' . ucfirst($nombre) . ".png";


        $query = "INSERT INTO pokemones (numero, nombre, imagen, tipo, habilidad, categoria, descripcion, descripcionLarga ,region)
              VALUES ('$numero', '$nombre', '$imagen', '$tipo', '$habilidad', '$categoria', '$descripcion','$descripcionLarga' , '$region')";

        mysqli_query($baseDeDatos, $query);


        header("Location: ../index.php");
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
    <link href="../css/colores.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        h1 {
            font-family: "Exo 2";
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }
        input::placeholder{
            color: black !important;
        }

    </style>
</head>
<body class="bg-gray-200 fuente">

<div class="container w-75 justify-content-center align-items-center">
<form action="agregarPokemon.php" method="post" enctype="multipart/form-data" class="bg-gray-400 p-4 m-3 rounded d-flex justify-content-center flex-column">
    <div class="container d-flex justify-content-center">
        <img src="../imagenes/logos/pokebola.png" class="img-fluid" style="width: 3em; height: 3em;" alt="Logo">
        <h1 class="text-center px-3">Agregue su pokemon</h1>
        <img src="../imagenes/logos/pokebola.png" class="img-fluid" style="width: 3em; height: 3em" alt="Logo">
    </div>
    <p class="text-center blockquote-footer m-2">ingrese los datos requeridos para agregar a su pokemon con exito</p>
    <div class="mb-3 mt-3">
        <label for="numero" class="form-label fw-bold">Número del pokemon</label>
        <input type="number" class="form-control transparencia border-black " id="numero" placeholder="Ej: 520, 200, etc..." name="numero">
    </div>
    <div class="mb-3 mt-3">
        <label for="nombre" class="form-label fw-bold">Nombre del pokemon</label>
        <input type="text" class="form-control transparencia border-black" id="nombre" placeholder="Ej: pikachu, raichu, etc..." name="nombre">
    </div>
    <div class="mb-3 mt-3">
        <label for="imagen" class="form-label fw-bold">Imagen del pokemon</label>
        <input type="file" class="form-control transparencia border-black" id="imagen" name="imagen">
    </div>
    <div class="mb-3 mt-3">
        <label for="descripcion" class="form-label fw-bold">Descripcion del pokemon</label>
        <input type="text" class="form-control transparencia border-black" id="descripcion" placeholder="Ej: es una criatura veloz..." name="descripcion">
    </div>
    <div class="mb-3 mt-3">
        <label for="descripcionLarga" class="form-label fw-bold">Descripcion del pokemon</label>
        <textarea name="descripcionLarga" id="descripcionLarga" cols="10" rows="3" class="form-control transparencia border-black" placeholder="Ej: Es la evolución de Slowpoke cuando una Shellder se aferra a su cola. Aunque parece distraído y lento, cuenta con poderes psíquicos notables y una gran resistencia. Es tranquilo por naturaleza y rara vez se altera...."></textarea>

    </div>
    <div class="mb-3 mt-3">
        <label for="region" class="form-label fw-bold">Region del pokemon</label>
        <input type="text" class="form-control transparencia border-black" id="region" placeholder="Ej: Kanto, Johto, etc..." name="region">
    </div>
    <div class="mb-3 mt-3">
        <label for="habilidad" class="form-label fw-bold">Habilidad del pokemon</label>
        <input type="text" class="form-control transparencia border-black" id="habilidad" placeholder="Ej: Vista Lince, etc... " name="habilidad">
    </div>
    <div class="mb-3 mt-3">
        <label for="categoria" class="form-label fw-bold">Categoria del pokemon</label>
        <input type="text" class="form-control transparencia border-black" id="categoria" placeholder="Ej: Pajarito, etc... " name="categoria">
    </div>
    <div class="mb-3 mt-3">
        <label for="tipo" class="form-label fw-bold ">Tipo del pokemon</label>
        <select class="form-select transparencia border-black" name="tipo" id="tipo">
            <option value="0" selected disabled>Seleccionar un tipo de pokemon</option>
            <option value="1">agua</option>
            <option value="2">fuego</option>
            <option value="3">bicho</option>
            <option value="4">planta</option>
            <option value="5">eléctrico</option>
            <option value="6">normal</option>
            <option value="7">hada</option>
            <option value="8">tierra</option>
            <option value="9">veneno</option>
        </select>

    </div>

    <button type="submit" class="btn btn-dark mb-2 mt-3 w-50 align-self-center">Agregue su pokemon</button>
</form>
</div>



<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">
        <small>| &copy; <?= date("Y") ?> |
            <small class="fw-bold">
                Arias Sol - Bernacchia Julieta -
                Bon Nicolás - De Oro Martin - Recchia, Javier
            </small>
            | Trabajo Práctico N°1 - Pokedex |</small>
    </div>
</footer>

</body>
</html>
