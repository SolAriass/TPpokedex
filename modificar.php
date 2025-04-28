<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}


$id = $_GET["id"];

$baseDeDatos = mysqli_connect("localhost", "root", "", "pokedex");

$sql = "SELECT * FROM pokemones WHERE id= '$id'";

$resultado = mysqli_query($baseDeDatos, $sql);

$pokemon = mysqli_fetch_assoc($resultado);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombrePokemon = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $numeroPokemon = isset($_POST['numero']) ? $_POST['numero'] : '';
    $descripcionPokemon = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $descripcionLarga = isset($_POST['descripcionLarga']) ? $_POST['descripcionLarga'] : '';
    $regionPokemon = isset($_POST['region']) ? $_POST['region'] : '';
    $tipoPokemon = isset($_POST['tipo']) ? $_POST['tipo'] : '';
    $imagenPokemon = isset($_FILES['imagen'] ) ? $_FILES['imagen'] : null;

    if($nombrePokemon != ''){
        $sql = "UPDATE pokemones SET nombre = '$nombrePokemon' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($numeroPokemon != ''){
        $sql = "UPDATE pokemones SET numero = '$numeroPokemon' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($descripcionPokemon != ''){
        $sql = "UPDATE pokemones SET descripcion = '$descripcionPokemon' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($descripcionLarga != ''){
        $sql = "UPDATE pokemones SET descripcionLarga = '$descripcionLarga' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($regionPokemon != ''){
        $sql = "UPDATE pokemones SET region = '$regionPokemon' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($tipoPokemon != ''){
        $sql = "UPDATE pokemones SET tipo = '$tipoPokemon' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($imagenPokemon != null){

        if($_FILES['imagen']['error'] === 0 && isset($_FILES['imagen'])){
            //$nombreImagen = $_FILES["imagen"]["name"]; //nombre archivo
            $rutaTemporal = $_FILES["imagen"]["tmp_name"];
            $carpetaNueva = 'fotoPokemones/';

            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nuevoNombreArchivo = ucfirst($nombrePokemon) . '.' . $extension;

            move_uploaded_file($rutaTemporal, $carpetaNueva.$nuevoNombreArchivo);

            $sql = "UPDATE pokemones SET imagen = '$nuevoNombreArchivo' WHERE id= '$id'";
            mysqli_query($baseDeDatos, $sql);
        }


    }



    header("location: index.php");
    exit();
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modificar pokemon</title>
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
        input::placeholder{
            color: black !important;
        }

    </style>
</head>
<body class="bg-gray-200 fuente">

<div class="container w-75 justify-content-center align-items-center">
    <form action="modificar.php?id=<?= $pokemon['id']?>" method="post" enctype="multipart/form-data" class="bg-gray-400 p-4 m-3 rounded d-flex justify-content-center flex-column">
        <div class="container d-flex justify-content-center">
            <img src="logos/pokebola.png" class="img-fluid" style="width: 3em; height: 3em;" alt="Logo">
            <h1 class="text-center px-3">Modificar datos de su pokemon</h1>
            <img src="logos/pokebola.png" class="img-fluid" style="width: 3em; height: 3em" alt="Logo">
        </div>
        <p class="text-center blockquote-footer m-2">modifique los datos que desee a su pokemon favorito</p>
        <div class="mb-3 mt-3">
            <label for="numero" class="form-label fw-bold">Número del pokemon</label>
            <input type="number" class="form-control transparencia border-black " id="numero" placeholder="Ej: 520, 200, etc..." name="numero" value="<?= $pokemon['numero'] ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="nombre" class="form-label fw-bold">Nombre del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="nombre" placeholder="Ej: pikachu, raichu, etc..." name="nombre" value="<?= $pokemon['nombre']?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="imagen" class="form-label fw-bold">Imagen del pokemon</label>
            <input type="file" class="form-control transparencia border-black" id="imagen" name="imagen">
        </div>
        <div class="mb-3 mt-3">
            <label for="descripcion" class="form-label fw-bold">Descripcion del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="descripcion" placeholder="Ej: es una criatura veloz..." name="descripcion" value="<?= $pokemon['descripcion']?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="descripcionLarga" class="form-label fw-bold">Descripcion del pokemon</label>
            <textarea name="descripcionLarga" id="descripcionLarga" cols="10" rows="3" class="form-control transparencia border-black" placeholder="Ej: Es la evolución de Slowpoke cuando una Shellder se aferra a su cola. Aunque parece distraído y lento, cuenta con poderes psíquicos notables y una gran resistencia. Es tranquilo por naturaleza y rara vez se altera...."><?= $pokemon['descripcionLarga']?></textarea>

        </div>
        <div class="mb-3 mt-3">
            <label for="region" class="form-label fw-bold">Region del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="region" placeholder="Ej: Kanto, Johto, etc..." name="region" value="<?= $pokemon['region']?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="tipo" class="form-label fw-bold ">Tipo del pokemon</label>
            <select class="form-select transparencia border-black" name="tipo" id="tipo"">
                <option value="0" selected disabled>Seleccionar un tipo de pokemon</option>
                <option value="agua" <?= $pokemon['tipo'] == 'agua' ? 'selected' : '' ?>>agua</option>
                <option value="fuego" <?= $pokemon['tipo'] == 'fuego' ? 'selected' : '' ?>>fuego</option>
                <option value="bicho" <?= $pokemon['tipo'] == 'bicho' ? 'selected' : '' ?>>bicho</option>
                <option value="planta" <?= $pokemon['tipo'] == 'planta' ? 'selected' : '' ?>>planta</option>
                <option value="eléctrico" <?= $pokemon['tipo'] == 'eléctrico' ? 'selected' : '' ?>>eléctrico</option>
                <option value="normal" <?= $pokemon['tipo'] == 'normal' ? 'selected' : '' ?>>normal</option>
                <option value="hada" <?= $pokemon['tipo'] == 'hada' ? 'selected' : '' ?>>hada</option>
                <option value="tierra" <?= $pokemon['tipo'] == 'tierra' ? 'selected' : '' ?>>tierra</option>
                <option value="veneno" <?= $pokemon['tipo'] == 'veneno' ? 'selected' : '' ?>>veneno</option>
            </select>

        </div>

        <button type="submit" class="btn btn-dark mb-2 mt-3 w-50 align-self-center">Modificar</button>
    </form>
</div>
</body>
</html>
