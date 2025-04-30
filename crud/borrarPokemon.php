<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

require ("../config/ConexionBD.php");

use config\ConexionBD;

$baseDeDatos = new ConexionBD();

$idPokemon = isset($_GET['id']) ? $_GET['id'] : 0;

if($idPokemon != 0){

    $resultado1 = $baseDeDatos->query("SELECT * FROM pokemones WHERE id = '$idPokemon'");

    $pokemon = mysqli_fetch_array($resultado1);

    //CREAR QUERY DE ELIMINAR

    $resultado = $baseDeDatos->query("DELETE FROM pokemones WHERE id = '$idPokemon'");

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

    $_SESSION['flash_msg']  = "¡Pokémon “{$pokemon['nombre']}” eliminado correctamente!";
    $_SESSION['flash_type'] = "danger";

    header('location: ../index.php');
    exit();
}



