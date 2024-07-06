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
        include "modificarPedidoAccion.php";
        break;
    case "DELETE":
        include "modificarPedidoAccion.php";
        break;
    default:
        echo "El método pasado no es válido\n";
        break;
}
