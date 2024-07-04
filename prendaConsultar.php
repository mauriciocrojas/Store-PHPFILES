<?php

//Mauricio Rojas

require_once "tienda.php";

if (isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["color"])) {
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $color = $_POST["color"];

    echo Tienda::ConsultarTipoNombreColor($nombre, $tipo, $color);
} else {
    echo "Faltan datos";
}
