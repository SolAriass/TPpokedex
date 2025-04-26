<?php

namespace config;
class ConexionBD
{
  private $connexion;

  function __construct()
  {
    $config = parse_ini_file("config.ini");

    $this->connexion = new \MySQLi(
      $config["host"],
      $config["user"],
      $config["pass"],
      $config["db"]
    );

    if ($this->connexion->connect_error) {
      die("Error al conectar a la base de datos");
    }
  }

  public function query($query)
  {
    return $this->connexion->query($query);
  }

  public function destroy()
  {
    $this->connexion->close();
  }

}
