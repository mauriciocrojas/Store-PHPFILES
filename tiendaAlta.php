<?php

//Mauricio Rojas

require_once "tienda.php";

if (
    isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["color"])
    && isset($_POST["talla"]) && isset($_POST["precio"]) && isset($_POST["stock"])
) {
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $color = $_POST["color"];
    $talla = $_POST["talla"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    $prenda = Tienda::TiendaAlta($nombre, $tipo, $precio, $stock, $talla, $color);

    echo Tienda::GuardarJson($prenda) ? "Se guardó la prenda en un archivo\n" : "Error al guardar la prenda en la archivo\n";

    $ubicacionTemp = $_FILES["file"]["tmp_name"];
    echo Tienda::GuardarImagenCargada($ubicacionTemp, $nombre, $tipo) ? "Se guardó la imagen enviada\n" : "No se pudo guardar la imagen enviada\n";
} else {
    echo "Faltan datos";
}
