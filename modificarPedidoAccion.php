<?php


include "modificarPedido.php";
require_once "tienda.php";
require_once "venta.php";




if ($_GET["accion"] == 'modificar') {
    parse_str(file_get_contents("php://input"), $putData);
    $lista = AlterarVenta::ModificarPedido($putData['email'], $putData['nombre'], $putData['tipo'], $putData['talla'], $putData['cantidad'], $putData['nuevatalla'], $putData['numeropedido']);

    if (!empty($lista)) {
        echo Tienda::GuardarJson($lista, "ventas.json") ? "Se guardó el listado de ventas\n" : "Error al guardar listado de ventas\n";
    }
} else if ($_GET["accion"] == 'eliminar') {
    parse_str(file_get_contents("php://input"), $putData);
    $lista = AlterarVenta::EliminarPedido($putData['numeropedido']);

    if (!empty($lista)) {
        echo Tienda::GuardarJson($lista, "ventas.json") ? "Se guardó el listado de ventas\n" : "Error al guardar listado de ventas\n";
    }
}
