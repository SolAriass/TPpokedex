<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}


$idPokemon = isset($_POST['idPoke']) ? $_POST['idPoke'] : 0;

$nombrepoke = isset($_POST['nombrepoke']) ? $_POST['nombrepoke'] : " ";

$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

if($idPokemon != 0){
    //CREAR QUERY DE ELIMINAR
    $query = "DELETE FROM pokemones WHERE id = '$idPokemon'";

    $resultado = mysqli_query($baseDeDatos, $query);

    $carpeta = "fotoPokemones/";
    $archivos = scandir($carpeta);

    foreach ($archivos as $archivo) {
        if(strpos($archivo, $nombrepoke) !== false){ //busco en ese archivo que contenga ese nombre, devuelve un valor entero si coincide, sino falso
            $rutaImagen = $carpeta.$archivo; //armo la ruta para verificar que exista
            if(file_exists($rutaImagen)){ //confirmo que exista realmente
                unlink($rutaImagen); //eliminar archivo
            }
            break; //corto el bucle
        }
    }

    header('location: index.php');
    exit();
}



