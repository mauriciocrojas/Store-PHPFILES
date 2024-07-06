<?php

//Mauricio Rojas

require_once "tienda.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');

class Venta
{

    public $id;
    public $email;
    public $nombre;
    public $tipo;
    public $numeroVenta;
    public $cantidadSolicitada;
    public $fecha;
    public $talla;
    public $precio;

    public function SetEmail($email)
    {
        if (isset($email) && is_string($email)) {
            $this->email = $email;
        }
    }
    public function SetNombre($nombre)
    {
        if (isset($nombre) && is_string($nombre)) {
            $this->nombre = $nombre;
        }
    }
    public function SetTipo($tipo)
    {
        if (isset($tipo) && is_string($tipo)) {
            $this->tipo = $tipo;
        }
    }

    public function SetTalla($talla)
    {
        if (isset($talla) && is_string($talla)) {
            $this->talla = $talla;
        }
    }
    public function SetCantidadSolicitada($cantidadSolicitada)
    {
        if (isset($cantidadSolicitada) && is_numeric($cantidadSolicitada)) {
            $this->cantidadSolicitada = $cantidadSolicitada;
        }
    }

    public function SetId($id)
    {
        if (isset($id) && is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function SetPrecio($precio)
    {
        if (isset($precio) && is_numeric($precio)) {
            $this->precio = $precio;
        }
    }

    public function SetNumeroVenta($numeroVenta)
    {
        if (isset($numeroVenta) && is_numeric($numeroVenta)) {
            $this->numeroVenta = $numeroVenta;
        }
    }
    public static function AltaUsuarioVenta($email, $nombre, $tipo, $cantidadSolicitada, $talla, $precio)
    {
        $listaVentas = array();

        $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");

        $venta = new Venta();
        $venta->SetEmail($email);
        $venta->SetTalla($talla);
        $venta->SetNombre($nombre);
        $venta->SetTipo($tipo);
        $venta->SetPrecio($precio);
        $venta->SetCantidadSolicitada($cantidadSolicitada);
        $venta->SetId(count($listaVentas) + 1);
        $venta->SetNumeroVenta(rand(1000, 5000));
        $venta->fecha = date("d-m-Y H:i:s");

        array_push($listaVentas, $venta);

        return $listaVentas;
    }

    public static function BuscarPrendaParaUsuario($nombre, $tipo, $talla, $cantidadSolicitada)
    {
        $listaPrendas = Tienda::ObtenerContenidoDelArchivo();
        $cadena = '';
        $bool = false;
        foreach ($listaPrendas as $prenda) {
            if ($prenda["nombre"] == $nombre && $prenda["tipo"] == $tipo && $prenda["talla"] == $talla && $prenda["stock"] >= $cantidadSolicitada) {
                $cadena = "Hay stock del nombre, tipo y talla solicitada, se realiza la venta\n";
                $indice = array_search($prenda, $listaPrendas);
                $listaPrendas[$indice]["stock"] = $prenda["stock"] - $cantidadSolicitada;
                Tienda::guardarJson($listaPrendas);
                $cadena .= "El nuevo stock es de: " .  $listaPrendas[$indice]["stock"] . "\n";
                $bool = true;
                break;
            } else if ($prenda["nombre"] == $nombre && $prenda["tipo"] == $tipo && $prenda["talla"] == $talla && $prenda["stock"] < $cantidadSolicitada) {
                $cadena = "No hay stock de la prenda solicitado\n";
                $bool = false;
                break;
            } else {
                $bool = false;
                $cadena = "No existe una prenda de este tipo, nombre o talla\n";
            }
        }

        echo $cadena;

        return $bool;
    }

    public static function GuardarImagenCargada($ubicacionTemp, $nombre, $tipo, $talla, $email)
    {
        if (isset($ubicacionTemp)) {
            $nombreCarpeta = "ImagenesDeVentas2024/";
            $destino =  $nombreCarpeta . $nombre . $tipo . $talla . explode('@', $email)[0] . date("d-m-Y") . ".jpg";



            //Si la carpeta no está creada, la crea
            //Si ya existe, saltea el if
            if (!is_dir($nombreCarpeta)) {
                mkdir($nombreCarpeta, 0777);
            }

            return move_uploaded_file($ubicacionTemp, $destino) ? true : false;
        } else {
            return false;
        }
    }



    public static function PrendasVendidasPorDia($fecha = "19-05-2024")
    {

        $listaVentas = array();

        $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");
        $cantidad = 0;

        foreach ($listaVentas as $venta) {
            if (explode(" ", $venta["fecha"])[0] == $fecha) {
                $cantidad += $venta["cantidadSolicitada"];
            }
        }
        return $cantidad;
    }

    public static function PrendasCompradasPorUsuario($usuario)
    {

        $listaVentas = array();

        $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");

        $listaUsuarios = array();

        foreach ($listaVentas as $venta) {
            if ($venta["email"] == $usuario) {
                array_push($listaUsuarios, $venta);
            }
        }
        return $listaUsuarios;
    }

    public static function MostrarVentas($listaDeVentas)
    {
        if (!empty($listaDeVentas)) {
            foreach ($listaDeVentas as $venta) {
                echo "\nUsuario: " . $venta["email"] .
                    " \nnombre: " . $venta["nombre"] .
                    " \nTipo: " . $venta["tipo"] .
                    " \nCantidad adquirada: " . $venta["cantidadSolicitada"] . "\n\n";
            }
        } else {
            echo "\nLista Vacía\n";
            return false;
        }
    }





    public static function PrendasVendidasPorTipo($tipo = "camiseta")
    {

        $listaVentas = array();

        $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");

        $listaVentasPornombre = array();

        foreach ($listaVentas as $venta) {
            if ($venta["tipo"] == $tipo) {
                array_push($listaVentasPornombre, $venta);
            }
        }

        if (Venta::MostrarVentas($listaVentasPornombre) === false) {
            echo "No existen ventas de ese tipo\n";
        }
    }

    public static function MostrarPrendasEntrePrecios($valor01, $valor02)
    {
        $listaPrendas = array();

        $listaPrendas = Tienda::ObtenerContenidoDelArchivo("tienda.json");

        $listaPrendasEntrePrecios = array();

        foreach ($listaPrendas as $prenda) {
            if ($prenda["precio"] >= $valor01 && $prenda["precio"] <= $valor02) {
                array_push($listaPrendasEntrePrecios, $prenda);
            }
        }

        if (Tienda::MostrarPrendas($listaPrendasEntrePrecios) === false) {
            echo "No existen prendas entre los rangos mencionados\n";
        }
    }

    public static function IngresosDeVentasPorDia($fecha = null)
    {
        $listaVentas = array();
        $hayIngresosFechaEspecifica = false;

        $listaVentas = Tienda::ObtenerContenidoDelArchivo("ventas.json");
        $totalIngresos = 0;

        if (isset($fecha)) {
            //Recorro la lista de ventas y cada vez que se encuentre la fecha pasada por parámetro, los ingresos de ese día se sumarán
            foreach ($listaVentas as $venta) {
                if (explode(" ", $venta["fecha"])[0] == $fecha) {
                    $totalIngresos += $venta["precio"];
                    $hayIngresosFechaEspecifica = true;
                }
            }
        } else {
            //Recorro la lista de ventas, y por cada fecha que encuentre, armo los ingresos para ese día y los informo
            foreach ($listaVentas as $venta) {
                $fechaVenta = explode(" ", $venta["fecha"])[0];

                if (!isset($ingresosPorFecha[$fechaVenta])) {
                    $ingresosPorFecha[$fechaVenta] = 0;
                }

                $ingresosPorFecha[$fechaVenta] += $venta["precio"];
            }
        }


        if ($totalIngresos > 0 && $hayIngresosFechaEspecifica) {
            //Muestro los ingresos de una fecha específica
            echo "Los ingresos de esa fecha fueron de: $" . $totalIngresos;
        } else if (!empty($ingresosPorFecha) && !$hayIngresosFechaEspecifica) {
            //Muestro los ingresos de todos los días
            echo "Los ingresos por día fueron de:\n";
            foreach ($ingresosPorFecha as $fecha => $ingresos) {
                echo "Fecha: " . $fecha . " - Ingresos: $" . $ingresos . "\n";
            }
        }
    }


    public static function ProductoMasVendido()
    {
        $ventas = Tienda::ObtenerContenidoDelArchivo("ventas.json");
    
        $cantidades = [];
    
        foreach ($ventas as $venta) {
            $nombre = $venta["nombre"];
            if (!isset($cantidades[$nombre])) {
                $cantidades[$nombre] = 0;
            }
            $cantidades[$nombre] += intval($venta["cantidadSolicitada"]);
        }
    
        $productoMasVendido = '';
        $cantidadMaxima = 0;
    
        foreach ($cantidades as $nombre => $cantidad) {
            if ($cantidad > $cantidadMaxima) {
                $productoMasVendido = $nombre;
                $cantidadMaxima = $cantidad;
            }
        }
    
        if ($productoMasVendido != '') {
            echo "El producto más vendido es: $productoMasVendido con una cantidad vendida de $cantidadMaxima unidades.";
        } else {
            echo "No se encontraron ventas";
        }
    }
    
}
