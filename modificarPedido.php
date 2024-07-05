
<?php
require_once "tienda.php";
require_once "venta.php";

class Modificar
{



    // Debe recibir el número de pedido, el email del usuario, el nombre, tipo, talla y cantidad. Si existe se modifica, de
    // lo contrario, informar que no existe ese número de pedido.

    public static function ModificarPedido($email, $nombre, $tipo, $talla, $cantidad, $nuevatalla)
    {
        $coincidencia = false;
        $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");

        parse_str(file_get_contents("php://input"), $putData);

        if (isset($putData['nombre'], $putData['tipo'], $putData['email'], $putData['talla'], $putData['nuevatalla'], $putData['cantidad'])) {

            $nombre = $putData['nombre'];
            $tipo = $putData['tipo'];
            $email = $putData['email'];
            $talla = $putData['talla'];
            $nuevatalla = $putData['nuevatalla'];
            $cantidad = $putData['cantidad'];

            foreach ($listaVentas as $venta) {

                if ($venta["email"] = $email && $venta["nombre"] == $nombre && $venta["tipo"] == $tipo && $venta["talla"] == $talla && $venta["cantidadSolicitada"] == $cantidad) {

                    $posicion = array_search($venta, $listaVentas);
                    echo $posicion . '<br>\n';

                    $listaVentas[$posicion]['talla']=  $nuevatalla;
                    echo $listaVentas[$posicion]['talla'] . '<br>\n';

                    echo "Se encontró una coincidencia\n";
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
            echo "No se encontró una coincidencia\n";
        }
        return [];
    }
}
