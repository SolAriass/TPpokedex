<?php


function buscarPokemon($pokemones, $busqueda) {
    $pokemonesFiltrados = [];
    $mensaje = '';

    if ($busqueda !== '') {
        foreach ($pokemones as $poke) {
            if (strcasecmp($poke['nombre'], $busqueda) === 0) {
                $pokemonesFiltrados[] = $poke;
                break;
            }
        }

        if (empty($pokemonesFiltrados)) {
            $mensaje = "Pokémon no encontrado. Mostrando todos los pokemones:";
        }
    }

    return array($pokemonesFiltrados, $mensaje);
}
