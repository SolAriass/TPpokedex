<?php
$id = isset($_POST['id']) ? $_POST['id'] : "";
$nombrepoke = isset($_POST['nombrepoke']) ? $_POST['nombrepoke'] : "";

$baseDeDatos = mysqli_connect('localhost', 'root', '', 'pokedex') or die("Error al conectar a la base de datos");

//$modificar = $_POST['modificar'];
$eliminar = $_POST['eliminar'];
//if ($modificar){

  //  include("modificar.php");
    //mandar a otra vista para modificar los datos
//}
if ($eliminar){
    //CREAR QUERY DE ELIMINAR
    $query = "DELETE FROM pokemones WHERE id = '$id'";

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

    header('location: vistaAdmin.php');
    exit();
}

