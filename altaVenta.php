
<?php

//Mauricio Rojas

require_once "tienda.php";
require_once "venta.php";

if (isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["cantidad"]) && isset($_POST["email"]) && isset($_POST["talla"]) && isset($_POST["cantidad"])) {
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $cantidad = $_POST["cantidad"];
    $email = $_POST["email"];
    $talla = $_POST["talla"];


    if (Venta::BuscarPrendaParaUsuario($nombre, $tipo, $talla, $cantidad)) {
        $usuario = Venta::AltaUsuarioVenta($email, $nombre, $tipo, $cantidad, $talla);
        echo Tienda::GuardarJson($usuario, "ventas.json") ? "Se guardó el listado de ventas\n" : "Error al guardar listado de ventas\n";

        $ubicacionTemp = $_FILES["file"]["tmp_name"];
        echo Venta::GuardarImagenCargada($ubicacionTemp, $nombre, $tipo, $talla,$email) ? "Se guardó la imagen enviada\n" : "No se pudo guardar la imagen enviada\n";
        
    } else {
        echo "No se realizó la venta\n";
    }
} else {
    echo "Faltan datos";
}
