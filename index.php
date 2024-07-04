<?php

//Mauricio Rojas.

$metodo = $_SERVER["REQUEST_METHOD"];


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
            default:
                echo "Acción por POST inválida\n";
                break;
        }
    case "GET":
        include "consultarVentas.php";
        break;
    default:
        echo "El método pasado no es válido\n";
        break;
}
