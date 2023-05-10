<?php
require_once 'autoload.php';
require_once 'config/parameters.php';
require_once 'views/layout/header.php';
require_once 'views/layout/sidebar.php';

function show_error()
{
    $error = new errorController();
    $error->index();
}

$nombre_controlador = controller_default;
$action = action_default;

if(isset($_GET['controller'])){
    $nombre_controlador = strtolower($_GET['controller']) . "Controller";
}

if (class_exists($nombre_controlador)){
    $controlador = new $nombre_controlador();
    
}else{
    show_error();
    exit();
}

if(!empty($_GET['action']) && class_exists($nombre_controlador)){
    $action = strtolower($_GET['action']);
}

if(method_exists($controlador, $action)){
    $controlador->$action();
}else{
    show_error();
}




require_once 'views/layout/footer.php';     // Cargar pie de pagina


?>