
<?php

//Mauricio Rojas

require_once "tienda.php";
require_once "venta.php";

if (isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["cantidad"]) && isset($_POST["email"]) && isset($_POST["talla"]) && isset($_POST["cantidad"]) && isset($_POST["precio"])) {

    if ($_POST["tipo"] == 'pantalon' || $_POST["tipo"] == 'camiseta') {
        $nombre = $_POST["nombre"];
        $tipo = $_POST["tipo"];
        $cantidad = $_POST["cantidad"];
        $email = $_POST["email"];
        $talla = $_POST["talla"];
        $precio = $_POST["precio"];


        if (Venta::BuscarPrendaParaUsuario($nombre, $tipo, $talla, $cantidad)) {
            $usuario = Venta::AltaUsuarioVenta($email, $nombre, $tipo, $cantidad, $talla, $precio);
            echo Tienda::GuardarJson($usuario, "ventas.json") ? "Se guardó el listado de ventas\n" : "Error al guardar listado de ventas\n";

            $ubicacionTemp = $_FILES["file"]["tmp_name"];
            echo Venta::GuardarImagenCargada($ubicacionTemp, $nombre, $tipo, $talla, $email) ? "Se guardó la imagen enviada\n" : "No se pudo guardar la imagen enviada\n";
        } else {
            echo "No se realizó la venta\n";
        }
    }
} else if ($_POST["tipo"] == 'Conjunto') {

    $nombreCamisa = $_POST["nombrecamisa"];
    $nombrePantalon = $_POST["nombrepantalon"];
    $tallaCamisa = $_POST["tallacamisa"];
    $tallaPantalon = $_POST["tallapantalon"];
    $tipo = $_POST["tipo"];
    $cantidad = $_POST["cantidad"];
    $email = $_POST["email"];
    $precio = $_POST["precio"];

    $nombreConjunto = $nombreCamisa . $nombrePantalon;

    if (Venta::BuscarConjuntoParaUsuario($nombrePantalon, $nombreCamisa, $tipo, $tallaPantalon, $tallaCamisa, $cantidad)) {
        $listaventas = Venta::AltaUsuarioConjuntoVenta($email, $nombrePantalon, $nombreCamisa, $tipo, $cantidad, $tallaPantalon, $tallaCamisa, $precio);
        echo Tienda::GuardarJson($listaventas, "ventas.json") ? "Se guardó el listado de ventas\n" : "Error al guardar listado de ventas\n";

        $ubicacionTemp = $_FILES["file"]["tmp_name"];
        echo Venta::GuardarImagenCargada($ubicacionTemp, $nombreConjunto, $tipo, $tallaCamisa, $email) ? "Se guardó la imagen enviada\n" : "No se pudo guardar la imagen enviada\n";
    }
} else {
    echo "Faltan datos";
}
