<?php
require_once 'models/producto.php';

class carritoController
{
    public function index()
    {
        if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0){
            $carrito = $_SESSION['carrito'];
            require_once 'views/carrito/index.php';
        }else{
            echo "<h1>Su carrito de compras no tiene elementos</h1><br /><p>En este segmento se despliegan los items de compra...</p>";
        }


    }

    public function add()
    {
        $last = false;
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($producto_id);
            $cantidad = $producto->getCantidad()->fetch_column();
        } else {
            header('Location:' . base_url);
        }
        if (isset($_SESSION['carrito'])) {
            $counter = 0;
            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['id_producto'] == $producto_id && $elemento['unidades'] < $cantidad) {
                    $_SESSION['carrito'][$indice]['unidades']++;
                    $counter++;

                }elseif($elemento['id_producto'] == $producto_id && $elemento['unidades'] >= $cantidad){
                    $last = true;
                    
                }

            }


        }
        if((!isset($counter) || $counter == 0) && !$last){

            // Conseguir producto
            $producto = new Producto();
            $producto->setId($producto_id);
            if($producto->getOne()){
                $producto = $producto->getOne();
            }
            
    
    
            // Add al carrito
            if (is_object($producto)) {
                $_SESSION['carrito'][] = array(
                    "id_producto" => $producto->id,
                    "precio" => $producto->precio,
                    "unidades" => 1,
                    "stock" => $producto->stock,
                    "producto" => $producto
                );
    
            }
        }
        $_SESSION['last'] = $last;
        header('Location:' . base_url . 'carrito/index');
    }

    public function subtract(){
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
        } else {
            header('Location:' . base_url);
        }

        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['id_producto'] == $producto_id) {
                    if($_SESSION['carrito'][$indice]['unidades'] > 1){
                        $_SESSION['carrito'][$indice]['unidades']--;
                    }else{
                        unset($_SESSION['carrito'][$indice]);
                    }
                }

            }

        }
        header('Location:' . base_url . 'carrito/index');

    }

    

    public function remove(){
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
        } else {
            header('Location:' . base_url);
        }

        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                if ($elemento['id_producto'] == $producto_id) {
                    unset($_SESSION['carrito'][$indice]);
                }                
            }

        }
        header('Location:' . base_url . 'carrito/index');

    }

    public function delete_all()
    {
        unset($_SESSION['carrito']);
        header('Location:' . base_url . 'carrito/index');

    }
}