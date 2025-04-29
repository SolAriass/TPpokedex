<?php

require_once '../config/ConexionBD.php';
use config\ConexionBD;

session_start();

$baseDeDatos = new ConexionBD();

$usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : '';
$pass = isset($_POST["pass"]) ? $_POST["pass"] : '';

$query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$pass'";
$resultado = $baseDeDatos->query($query);

if (mysqli_num_rows($resultado) > 0) {
  $usuario = mysqli_fetch_assoc($resultado);
  $_SESSION['usuario'] = $usuario['usuario'];
  header('location: ../index.php');
  exit();
} else {
  header("Location: login.php?error=1");
  exit;
}



