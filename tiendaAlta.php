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
} else if (
    isset($_POST["nombrecamisa"]) && isset($_POST["tipocamisa"]) && isset($_POST["nombrepantalon"]) && isset($_POST["tipopantalon"])
) {
    $listaConjuntos = Tienda::ConjuntoAlta($_POST["nombrecamisa"], $_POST["tipocamisa"], $_POST["nombrepantalon"], $_POST["tipopantalon"]);

    if (!empty($listaConjuntos)) {
        echo Tienda::GuardarJson($listaConjuntos) ? "Se guardó el conjunto en un archivo\n" : "Error al guardar el conjunto en el archivo\n";
        $ubicacionTemp = $_FILES["file"]["tmp_name"];
        echo Tienda::GuardarImagenCargadaConjunto($ubicacionTemp, $_POST["nombrecamisa"], $_POST["nombrepantalon"]) ? "Se guardó la imagen enviada\n" : "No se pudo guardar la imagen enviada\n";
    } else {
        echo "Lista de prendas vacía al intentar dar de alta un conjunto\n";
    }
} else {
    echo "Faltan datos";
}
