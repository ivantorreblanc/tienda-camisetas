<?php
require_once 'models/producto.php';

class productoController
{
    public function index()
    {
        $producto = new Producto();
        $productos = $producto->getRandom(9);
        // Renderizar vista
        require_once 'views/producto/destacados.php';
    }

    public function ver(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            $product = $producto->getOne();
            require_once 'views/producto/ver.php';
        } 
        

    }

    public function gestion()
    {
        Utils::isAdmin();
        $producto = new Producto();
        $productos = $producto->getAll();

        require_once 'views/producto/gestion.php';
    }

    public function crear()
    {
        Utils::isAdmin();


        require_once 'views/producto/crear.php';
    }

    public function save()
    {
        Utils::isAdmin();
        if (isset($_POST)) {
            $categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : false;
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
            $stock = (int)$_POST['stock'];
            if ($categoria_id && $nombre && $descripcion && $precio) {
                $producto = new Producto();
                $producto->setCategoria_id($categoria_id);
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);

                // Cargar la imagen si existe
                if (isset($_FILES['imagen'])) {
                    $file = $_FILES['imagen'];
                    $filename = $file['name'];
                    $mimetype = $file['type'];


                    if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {

                        if (!is_dir('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }

                        move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                        $producto->setImagen($filename);

                    }
                }

                
                // Guardar el producto
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $producto->setId($id);
                    $save = $producto->edit();
                }else{
                    $save = $producto->save(); 
                }

                
                if ($save) {
                    $_SESSION['producto'] = "complete";
                } else {
                    $_SESSION['producto'] = "failedSAVE";
                }
            } else {
                $_SESSION['producto'] = "failedTRUES";
            }
        } else {
            $_SESSION['producto'] = "failedPOST";
        }
        header('Location:' . base_url . 'producto/gestion');
    }

    public function editar()
    {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            $pro = $producto->getOne();

            require_once 'views/producto/editar.php';
        } else {
            header('Location:' . base_url . 'producto/gestion');
        }



    }

    public function eliminar()
    {
        Utils::isAdmin();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            $delete = $producto->delete();
            if ($delete) {
                $_SESSION['delete'] = 'complete';
            } else {
                $_SESSION['delete'] = 'failed delete';
            }

        } else {
            $_SESSION['delete'] = 'failed get';
        }
        header('Location:' . base_url . 'producto/gestion');
    }




} // Fin de clase controlador