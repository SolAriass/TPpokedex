<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
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
    $categoriaPokemon = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $habilidadPokemon = isset($_POST['habilidad']) ? $_POST['habilidad'] : '';

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
    if($categoriaPokemon != ''){
        $sql = "UPDATE pokemones SET categoria = '$categoriaPokemon' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($habilidadPokemon != ''){
        $sql = "UPDATE pokemones SET habilidad = '$habilidadPokemon' WHERE id= '$id'";
        mysqli_query($baseDeDatos, $sql);
    }
    if($imagenPokemon != null){

        //$nombreImagen = $_FILES["imagen"]["name"]; //nombre archivo
        $rutaTemporal = $_FILES["imagen"]["tmp_name"];
        $importante = '../imagenes';
        $carpetaNueva = '/fotoPokemones/';
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nuevoNombreArchivo = ucfirst($nombrePokemon) . '.' . $extension;


        $carpeta = "../imagenes/fotoPokemones/";
        $archivos = scandir($carpeta);



        if($_FILES['imagen']['error'] === 0 && isset($_FILES['imagen'])){

            if(!empty($pokemon['imagen'])){

                foreach ($archivos as $archivo) {
                    if(strpos($archivo, $pokemon['nombre']) !== false){ //busco en ese archivo que contenga ese nombre, devuelve un valor entero si coincide, sino falso
                        $rutaImagen = $carpeta.$archivo; //armo la ruta para verificar que exista
                        if(file_exists($rutaImagen)){ //confirmo que exista realmente
                            unlink($rutaImagen); //eliminar archivo
                        }
                        break; //corto el bucle
                    }


                }
            }


            move_uploaded_file($rutaTemporal, $importante.$carpetaNueva.$nuevoNombreArchivo);

            $url = 'fotoPokemones/'.$nuevoNombreArchivo;

            $sql = "UPDATE pokemones SET imagen = '$url' WHERE id= '$id'";
            mysqli_query($baseDeDatos, $sql);


            //agregar que se borre la imagen vieja que existia antes de la actualizada
        }


    }



    header("location: ../index.php");
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
    <form action="modificar.php?id=<?= $pokemon['id']?>" method="post" enctype="multipart/form-data" class="bg-gray-400 p-4 m-3 rounded d-flex justify-content-center flex-column">
        <div class="container d-flex justify-content-center">
            <img src="../imagenes/logos/pokebola.png" class="img-fluid" style="width: 3em; height: 3em;" alt="Logo">
            <h1 class="text-center px-3">Modificar datos de su pokemon</h1>
            <img src="../imagenes/logos/pokebola.png" class="img-fluid" style="width: 3em; height: 3em" alt="Logo">
        </div>
        <p class="text-center blockquote-footer m-2">modifique los datos que desee a su pokemon favorito</p>
        <div class="mb-3 mt-3">
            <label for="numero" class="form-label fw-bold">Número del pokemon</label>
            <input type="number" class="form-control transparencia border-black " id="numero" name="numero" value="<?= $pokemon['numero'] ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="nombre" class="form-label fw-bold">Nombre del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="nombre" name="nombre" value="<?= $pokemon['nombre']?>">
        </div>
        <div class="mb-3 mt-3">

            <?php if (!empty($pokemon['imagen'])): ?>
                <div class="mb-3">
                    <label class="form-label fw-bold mb-4">Imagen actual</label><br>
                    <div class="d-flex flex-column align-items-start g-2">
                        <img src="../imagenes/<?= $pokemon['imagen'] ?>" alt="Imagen actual" style="width: 150px;">
                        <br>
                        <a href="../imagenes/<?= $pokemon['imagen'] ?>" download class="link text-dark">Descargar imagen</a>
                    </div>

                </div>
            <?php endif; ?>

            <label for="imagen" class="form-label fw-bold">Imagen del pokemon</label>
            <input type="file" class="form-control transparencia border-black" id="imagen" name="imagen">
        </div>
        <div class="mb-3 mt-3">
            <label for="descripcion" class="form-label fw-bold">Descripcion del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="descripcion" name="descripcion" value="<?= $pokemon['descripcion']?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="descripcionLarga" class="form-label fw-bold">Descripcion del pokemon</label>
            <textarea name="descripcionLarga" id="descripcionLarga" cols="10" rows="3" class="form-control transparencia border-black"><?= $pokemon['descripcionLarga']?></textarea>

        </div>
        <div class="mb-3 mt-3">
            <label for="region" class="form-label fw-bold">Region del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="region" name="region" value="<?= $pokemon['region']?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="habilidad" class="form-label fw-bold">Habilidad del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="habilidad" name="habilidad" value="<?= $pokemon['habilidad'] ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="categoria" class="form-label fw-bold">Categoria del pokemon</label>
            <input type="text" class="form-control transparencia border-black" id="categoria" name="categoria" value="<?= $pokemon['categoria']?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="tipo" class="form-label fw-bold ">Tipo del pokemon</label>
            <select class="form-select transparencia border-black" name="tipo" id="tipo"">
                <option value="0" selected disabled>Seleccionar un tipo de pokemon</option>
                <option value="1" <?= $pokemon['tipo'] == '1' ? 'selected' : '' ?>>agua</option>
                <option value="2" <?= $pokemon['tipo'] == '2' ? 'selected' : '' ?>>fuego</option>
                <option value="3" <?= $pokemon['tipo'] == '3' ? 'selected' : '' ?>>bicho</option>
                <option value="4" <?= $pokemon['tipo'] == '4' ? 'selected' : '' ?>>planta</option>
                <option value="5" <?= $pokemon['tipo'] == '5' ? 'selected' : '' ?>>eléctrico</option>
                <option value="6" <?= $pokemon['tipo'] == '6' ? 'selected' : '' ?>>normal</option>
                <option value="7" <?= $pokemon['tipo'] == '7' ? 'selected' : '' ?>>hada</option>
                <option value="8" <?= $pokemon['tipo'] == '8' ? 'selected' : '' ?>>tierra</option>
                <option value="9" <?= $pokemon['tipo'] == '9' ? 'selected' : '' ?>>veneno</option>
            </select>

        </div>

        <button type="submit" class="btn btn-dark mb-2 mt-3 w-50 align-self-center">Modificar</button>
    </form>
</div>


<?php require("../footer/footer.php")
?>


</body>
</html>
