<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$idPokemon = isset($_GET['id']) ? $_GET['id'] : 0;

$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

if($idPokemon != 0){

    $query1 = "SELECT * FROM pokemones WHERE id = '$idPokemon'";

    $resultado1 = mysqli_query($baseDeDatos, $query1);

    $pokemon = mysqli_fetch_array($resultado1);

    //CREAR QUERY DE ELIMINAR
    $query = "DELETE FROM pokemones WHERE id = '$idPokemon'";

    $resultado = mysqli_query($baseDeDatos, $query);

    $carpeta = "../imagenes/fotoPokemones/";
    $archivos = scandir($carpeta);

    foreach ($archivos as $archivo) {
        if(strpos($archivo, $pokemon['nombre']) !== false){ //busco en ese archivo que contenga ese nombre, devuelve un valor entero si coincide, sino falso
            $rutaImagen = $carpeta.$archivo; //armo la ruta para verificar que exista
            if(file_exists($rutaImagen)){ //confirmo que exista realmente
                unlink($rutaImagen); //eliminar archivo
            }
            break; //corto el bucle
        }
    }

    header('location: ../index.php');
    exit();
}



