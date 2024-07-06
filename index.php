<?php

//Mauricio Rojas

$metodo = $_SERVER["REQUEST_METHOD"];
echo "Método HTTP: $metodo\n";

switch ($metodo) {
    case "POST":
        switch ($_GET["accion"]) {
            case "alta":
                include "tiendaAlta.php";
                break;
            case "consultar":
                include "prendaConsultar.php";
                break;
            case "venta":
                include "altaVenta.php";
                break;
            case "altaConjunto":
                include "tiendaAlta.php";
                break;
            default:
                echo "Acción por POST inválida\n";
                break;
        }
        break;
    case "GET":
        include "consultarVentas.php";
        break;
    case "PUT":
        if ($_GET["accion"] == 'modificar') {
            echo "Entré al IF del bloque PUT.\n";
            include "modificarPedido.php";
            parse_str(file_get_contents("php://input"), $putData);
            $lista = Modificar::ModificarPedido($putData['email'], $putData['nombre'], $putData['tipo'], $putData['talla'], $putData['cantidad'], $putData['nuevatalla'], $putData['numeropedido']);

            if (count($lista) > 0) {
                echo Tienda::GuardarJson($lista, "ventas.json") ? "Se guardó el listado de ventas\n" : "Error al guardar listado de ventas\n";
            }
        }
        break;
    default:
        echo "El método pasado no es válido\n";
        break;
}
