
<?php
require_once "tienda.php";
require_once "venta.php";

class AlterarVenta
{



    // Si existe la venta, se modifica, de lo contrario, informar que no existe ese número de pedido.
    public static function ModificarPedido($email, $nombre, $tipo, $talla, $cantidad, $nuevatalla, $numeropedido)
    {
        $coincidencia = false;
        $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");

        if (isset($email, $nombre, $tipo, $talla, $cantidad, $nuevatalla, $numeropedido)) {

            foreach ($listaVentas as $venta) {

                if ($venta["email"] == $email && $venta["nombre"] == $nombre && $venta["tipo"] == $tipo && $venta["talla"] == $talla && $venta["cantidadSolicitada"] == $cantidad && $venta["numeroVenta"] == $numeropedido) {

                    $posicion = array_search($venta, $listaVentas);

                    $listaVentas[$posicion]['talla'] = $nuevatalla;

                    echo "La talla del pedido $numeropedido fue modificada\n";
                    $coincidencia = true;
                    return $listaVentas;
                } else {
                    $coincidencia = false;
                }
            }
        } else {
            echo "No se recibieron todos los campos esperados.\n";
        }

        if (!$coincidencia) {
            echo "No se encontró una coincidencia con el numero de pedido: ". $numeropedido ."\n";
        }
        return [];
    }

        // Si existe la venta, se hace un softdelete, de lo contrario, informar que no existe ese número de pedido.
        public static function EliminarPedido($numeropedido)
        {
            $coincidencia = false;
            $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");
    
            if (isset($numeropedido)) {
    
                foreach ($listaVentas as $venta) {
    
                    if ($venta["numeroVenta"] == $numeropedido) {
    
                        $posicion = array_search($venta, $listaVentas);
    
                        $listaVentas[$posicion]['eliminado'] = 'Y';
    
                        echo "Se eliminó el pedido $numeropedido\n";
                        $coincidencia = true;
                        return $listaVentas;
                    } else {
                        $coincidencia = false;
                    }
                }
            } else {
                echo "No se recibió el número de pedido.\n";
                $coincidencia = true;
            }
    
            if (!$coincidencia) {
                echo "No se encontró una coincidencia con el numero de pedido: ". $numeropedido ."\n";
            }
            return [];
        }
}
