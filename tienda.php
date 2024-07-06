<?php

//Mauricio Rojas

class Tienda
{
    public $id;
    public $nombre;
    public $tipo;
    public $color;
    public $talla;
    public $precio;
    public $stock;
    public $nombreCamisa;
    public $nombrePantalon;
    public $tallaCamisa;
    public $tallaPantalon;
    public $precioTotal;

    public function setTalla($talla)
    {
        if (isset($talla) && is_string($talla)) {
            $this->talla = $talla;
        }
    }

    public function setNombreCamisa($nombreCamisa)
    {
        if (isset($nombreCamisa) && is_string($nombreCamisa)) {
            $this->nombreCamisa = $nombreCamisa;
        }
    }

    public function setNombrePantalon($nombrePantalon)
    {
        if (isset($nombrePantalon) && is_string($nombrePantalon)) {
            $this->nombrePantalon = $nombrePantalon;
        }
    }

    public function setTallaCamisa($tallaCamisa)
    {
        if (isset($tallaCamisa) && is_string($tallaCamisa)) {
            $this->tallaCamisa = $tallaCamisa;
        }
    }

    public function settallaPantalon($tallaPantalon)
    {
        if (isset($tallaPantalon) && is_string($tallaPantalon)) {
            $this->tallaPantalon = $tallaPantalon;
        }
    }

    public function setPrecioTotal($precioTotal)
    {
        if (isset($precioTotal) && is_numeric($precioTotal)) {
            $this->precioTotal = floatval($precioTotal);
        }
    }



    public function setId($id)
    {
        if (is_int($id)) {
            $this->id = $id;
        }
    }


    public function setNombre($nombre)
    {
        if (isset($nombre) && is_string($nombre)) {
            $this->nombre = $nombre;
        }
    }

    public function setColor($color)
    {
        if (isset($color) && is_string($color)) {
            $this->color = $color;
        }
    }


    public function setTipo($tipo)
    {
        if (isset($tipo) && is_string($tipo)) {
            $this->tipo = $tipo;
        }
    }


    public function setPrecio($precio)
    {
        if (isset($precio) && is_numeric($precio)) {
            $this->precio = floatval($precio);
        }
    }


    public function setStock($stock)
    {
        if (isset($stock) && is_numeric($stock)) {
            $this->stock = intval($stock);
        }
    }


    public static function TiendaAlta($nombre, $tipo, $precio, $stock, $talla, $color)
    {
        $listaPrendas = Tienda::ObtenerContenidoDelArchivo();
        $indice = Tienda::BuscarPrendaEnLista($nombre, $tipo, $listaPrendas);

        if ($indice) {
            $listaPrendas[$indice - 1]["stock"] += intval($stock);
            $listaPrendas[$indice - 1]["precio"] = floatval($precio);
            echo "Prenda existente, se actualiza su precio y se suma el nuevo stock\n";
            return $listaPrendas;
        } else {
            $tienda = new Tienda();
            $tienda->setId(count($listaPrendas) + 1);
            $tienda->setNombre($nombre);
            $tienda->setTipo($tipo);
            $tienda->setPrecio($precio);
            $tienda->setStock($stock);
            $tienda->setTalla($talla);
            $tienda->setColor($color);

            array_push($listaPrendas, $tienda);
            echo "Nueva prenda\n";
            return $listaPrendas;
        }
    }

    public static function ConjuntoAlta($nombreCamisa, $tipoCamisa, $nombrePantalon, $tipoPantalon)
    {
        $listaPrendas = Tienda::ObtenerContenidoDelArchivo();

        foreach ($listaPrendas as $camisa) {
            if ($camisa["nombre"] == $nombreCamisa && $camisa["tipo"] == $tipoCamisa) {
                foreach ($listaPrendas as $pantalon) {
                    if ($pantalon["nombre"] == $nombrePantalon && $pantalon["tipo"] == $tipoPantalon) {
                        $tienda = new Tienda();
                        $tienda->setId(count($listaPrendas) + 1);
                        $tienda->setNombreCamisa($nombreCamisa);
                        $tienda->setNombrePantalon($nombrePantalon);
                        $tienda->setTipo('Conjunto');
                        $tienda->setPrecioTotal($camisa["precio"] + $pantalon["precio"]);
                        $tienda->setTallaCamisa($camisa["talla"]);
                        $tienda->settallaPantalon($pantalon["talla"]);
                        $tienda->setNombre("$nombreCamisa y $nombrePantalon");

                        array_push($listaPrendas, $tienda);
                        echo "Nuevo conjunto dado de alta\n";
                        break;
                    }
                }
                break;
            }
        }

        return $listaPrendas;
    }

    // public static function GuardarJson($lista, $nombreArchivo = "tienda.json")
    // {
    //     $contenido = json_encode($lista, JSON_PRETTY_PRINT);
    //     if (!empty($contenido)) {
    //         $data = file_put_contents($nombreArchivo, $contenido);
    //         if ($data != false) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         echo "El archivo no se pudo guardar\n";
    //         return false;
    //     }
    // }

    public static function GuardarJson($lista, $nombreArchivo = "tienda.json")
    {
        // Preparar y filtrar las prendas válidas
        $preparadas = array_map(fn ($prenda) => array_filter((array) $prenda), $lista);

        // Convertir a JSON y guardar en el archivo
        $jsonContenido = json_encode($preparadas, JSON_PRETTY_PRINT);

        // Guardar en el archivo y retornar el resultado
        return file_put_contents($nombreArchivo, $jsonContenido) ? true : false;
    }


    public static function ConsultarTipoNombreColor($nombre, $tipo, $color)
    {
        $listaPrendas = Tienda::ObtenerContenidoDelArchivo();
        $mensaje =  "";

        foreach ($listaPrendas as $prenda) {
            if ($prenda["nombre"] == $nombre && $prenda["tipo"] == $tipo && $prenda["color"] == $color) {
                $mensaje =  "Existen prendas de ese color con nombre " . $nombre . "  y tipo " . $tipo . "\n";
                break;
            } else if ($prenda["tipo"] == $tipo && $prenda["nombre"] != $nombre && $prenda["color"] == $color) {
                $mensaje .=  "Hay de tipo " . $tipo . " pero no de nombre " . $nombre . "\n";
                break;
            } else if ($prenda["tipo"] != $tipo && $prenda["nombre"] == $nombre && $prenda["color"] == $color) {
                $mensaje .=  "Hay de nombre " . $nombre . " pero no de tipo " . $tipo . "\n";
                break;
            } else {
                $mensaje .=  "No hay prendas que cumplan los requisitos";
                break;
            }
        }
        return $mensaje;
    }


    public static function ObtenerContenidoDelArchivo($rutaArchivo = "tienda.json")
    {
        $arrayAux = array();
        if (file_exists($rutaArchivo)) {
            $contenido = file_get_contents($rutaArchivo);
            $arrayAux = json_decode($contenido, true);
        } else {
            //Apartado que verifica la existencia del archivo, de no existir lo crea y lo inializa con un array vacio
            file_put_contents($rutaArchivo, '[]');
            $arrayAux = [];
        }
        return $arrayAux;
    }

    public static function BuscarPrendaEnLista($nombre, $tipo, $listaPrendas)
    {
        foreach ($listaPrendas as $prenda) {
            if (
                $prenda["nombre"] == $nombre
                && $prenda["tipo"] == $tipo
            ) {
                return array_search($prenda, $listaPrendas) + 1;
            }
        }
        return false;
    }


    public static function GuardarImagenCargada($ubicacionTemp, $nombre, $tipo)
    {
        if (isset($ubicacionTemp)) {
            $nombreCarpeta = "ImagenesDeRopa2024/";
            $destino =  $nombreCarpeta . $nombre . $tipo . ".jpg";

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
    public static function GuardarImagenCargadaConjunto($ubicacionTemp, $nombreCamisa, $nombrePantalon)
    {
        if (isset($ubicacionTemp)) {
            $nombreCarpeta = "ImagenesDeConjuntos2024/";
            $destino =  $nombreCarpeta . $nombreCamisa . $nombrePantalon . ".jpg";

            if (!is_dir($nombreCarpeta)) {
                mkdir($nombreCarpeta, 0777);
            }

            return move_uploaded_file($ubicacionTemp, $destino) ? true : false;
        } else {
            return false;
        }
    }

    public static function MostrarPrendas($listaDePrendas)
    {
        if (!empty($listaDePrendas)) {
            foreach ($listaDePrendas as $prenda) {
                echo " \nnombre: " . $prenda["nombre"] .
                    " \nTipo: " . $prenda["tipo"] .
                    " \nPrecio: " . $prenda["precio"] . "\n\n";
            }
        } else {
            echo "\nLista Vacía\n";
            return false;
        }
    }
}
