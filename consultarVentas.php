<?php

//Mauricio Rojas


require_once "tienda.php";
require_once "venta.php";

switch ($_GET["accion"]) {
    case "cantidadVentasPorDia":

        if (isset($_GET["fecha"])) {
            echo "Parámetro de fecha utlizado: " . $_GET["fecha"] . "\n";
            echo "Se vendieron en la fecha sumistrada, la siguiente cantidad de prendas: ";
            echo Venta::PrendasVendidasPorDia($_GET["fecha"]) . "\n";
        } else {
            echo "No se pasó un parámetro de fecha, se utilizará la fecha del día de ayer\n";
            echo "Se vendieron el día de ayer, la siguiente cantidad de prendas: ";
            echo Venta::PrendasVendidasPorDia() . "\n";
        }
        break;
    case "listadoComprasPorUsuario":
        if (isset($_GET["usuario"])) {
            if (!empty(Venta::PrendasCompradasPorUsuario($_GET["usuario"]))) {
                echo "Listado de compras realizadas por el usuario: " . $_GET["usuario"] . "\n";
                Venta::MostrarVentas(Venta::PrendasCompradasPorUsuario($_GET["usuario"]));
            } else {
                echo "Este usuario no realizó compras\n";
            }
        }
        break;
    case "ventasPorTipo":
        echo "Prendas vendidas por tipo: \n";
        Venta::PrendasVendidasPorTipo();
        break;
    case "prendasEntrePrecios":
        if (isset($_GET["valor01"]) && isset($_GET["valor02"])) {
            Venta::MostrarPrendasEntrePrecios($_GET["valor01"], $_GET["valor02"]);
        } else {
            echo "Faltan datos\n";
        }
        break;
}
