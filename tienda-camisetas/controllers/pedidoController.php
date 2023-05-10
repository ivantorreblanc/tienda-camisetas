<?php
require_once 'models/pedido.php';
class pedidoController{
    public function hacer(){
        require_once 'views/pedido/hacer.php';
    }

    public function add(){
        if(isset($_SESSION['identity'])){
            
            // Guardar datos en la Variables
            $stats = Utils::statsCarrito();
            $usuario_id = $_SESSION['identity']->id;
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false ;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false ;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false ;
            $coste = $stats['total'];

            

            
            // Validar que los datos sean True  
            
            if($provincia && $localidad && $direccion){
                // Asignar datos al objeto
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);

                // Guardar pedido
                $save = $pedido->save();
                
                // Guardar Linea Pedido
                $save_linea = $pedido->save_linea();
                // Restar Stock
                $update_stock = $pedido->update_stock();
                if($save && $save_linea && $update_stock){
                    $_SESSION['pedido'] = 'complete';
                    unset($_SESSION['carrito']);
                }else{
                    $_SESSION['pedido'] = 'failed';
                }


                header("Location:".base_url."pedido/summary");


            }

        }else{
            // Redirigir al index
            header('Location:'.base_url);
        }



    }

    public function summary(){
        if(Utils::isLogged()){
            $identity = $_SESSION['identity'];
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);
            $pedido = $pedido->getOneByUser();

            $productos = new Pedido();
            $productos = $productos->getProductosByPedido($pedido->id);
        }


        require_once 'views/pedido/summary.php';
    }


    public function mis_pedidos(){
        $gestion = false;
        if(Utils::isLogged()){
            $usuario_id = $_SESSION['identity']->id;
            $pedido = new Pedido();
            // Sacar pedidos del usuario
            $pedido->setUsuario_id($usuario_id);
            $pedidos = $pedido->getAllByUser();

            require_once 'views/pedido/mis_pedidos.php';
        }else{
            header('Location:'.base_url);
        }
    }

    public function detalle(){
        if(Utils::isLogged()){
            if(isset($_GET['id'])){
                $id = $_GET['id'];

                $identity = $_SESSION['identity'];
                $pedido = new Pedido();
                $pedido->setId($id);
                $pedido = $pedido->getOne();
                $user = new Pedido();
                $user = $user->getUserPedido($pedido->usuario_id);

                $productos = new Pedido();
                $productos = $productos->getProductosByPedido($id);
                require_once 'views/pedido/detalle.php';
            }else{
               header('Location:'.base_url.'pedido/mis_pedidos');
            }
        }else{
            header('Location:'.base_url);
        }
    }

    public function gestion(){
        Utils::isAdmin();
        $gestion = true;

        $pedido = new Pedido();
        $pedidos = $pedido->getAll();



        require_once 'views/pedido/mis_pedidos.php';

    }

    public function estado(){
        Utils::isAdmin();
        if(isset($_POST['pedido_id']) && isset($_POST['estado'])){
            // Recoger datos del formulario
            $id = $_POST['pedido_id'];
            $estado = $_POST['estado'];

            // Update Estado del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido->setEstado($estado);
            $pedido->updateStatus();

            header("Location:".base_url."pedido/detalle&id=".$id);
        }else{
            header("Location:".base_url);
        }
    }

}