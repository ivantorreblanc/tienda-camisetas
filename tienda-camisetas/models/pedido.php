<?php
class Pedido {
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;

    private $db;



    public function __construct(){
        $this->db = Database::connect();
    }



	public function getOne(){
        $pedido = $this->db->query("SELECT * FROM pedidos WHERE id = {$this->getId()};");

        return $pedido->fetch_object();
    }

	public function getOneByUser(){
		$sql = "SELECT id, coste FROM pedidos "
				."WHERE usuario_id = {$this->getUsuario_id()} ORDER BY id DESC LIMIT 1;";
		
        $pedido = $this->db->query($sql);

        return $pedido->fetch_object();
    }

	public function getAllByUser(){
		$sql = "SELECT * FROM pedidos "
				."WHERE usuario_id = {$this->getUsuario_id()} ORDER BY id DESC;";
		
        $pedidos = $this->db->query($sql);

        return $pedidos;
    }

	public function getProductosByPedido($pedido_id){
		$sql = "SELECT p.*, lp.unidades FROM productos p "
				."INNER JOIN lineas_pedido lp ON lp.producto_id = p.id "
				."WHERE lp.pedido_id = {$pedido_id}";
		$productos = $this->db->query($sql);
		$result = false;

		if($productos){
			$result = $productos;
		}
		return $result;
	
	}

    public function getAll(){
        $pedidos = $this->db->query("SELECT * FROM pedidos ORDER BY id DESC;");
        return $pedidos;
    }

	public function getUserPedido($user_id){
		$sql = "SELECT u.id as 'usuario_id', u.nombre, u.apellidos, u.email, p.estado FROM usuarios u "
		."INNER JOIN pedidos p ON u.id = p.usuario_id "
		."WHERE p.usuario_id = {$user_id} AND p.id = {$_GET['id']};";


		$user = $this->db->query($sql);
		$result = false;
		if($user){
			$result = $user;
		}
		return $result->fetch_object();
	}



	public function save(){
		$result = false;
        $sql = "INSERT INTO pedidos VALUES(NULL, {$this->getUsuario_id()}, '{$this->getProvincia()}', '{$this->getLocalidad()}', '{$this->getDireccion()}', {$this->getCoste()}, 'confirm', CURDATE(), CURTIME());"; 
		$save = $this->db->query($sql);
        
		if($save){
			$result = true;
		}
		return $result;
    }

	public function save_linea(){
		$result = false;
		$sql = "SELECT LAST_INSERT_ID() as 'pedido';";

		$query = $this->db->query($sql);

		$pedido_id = $query->fetch_object()->pedido;

		foreach ($_SESSION['carrito'] as $elemento){
			$producto = $elemento['producto'];

			$insert = "INSERT INTO lineas_pedido VALUES(NULL, {$pedido_id}, {$producto->id}, {$elemento['unidades']});";

			$save = $this->db->query($insert);
		}
		if($save){
			$result = true;
		}
		return $result;
	}

	public function update_stock(){
		foreach($_SESSION['carrito'] as $elemento){
			$producto = $elemento['producto'];

			$update = "UPDATE productos SET stock = (stock-{$elemento['unidades']}) WHERE id = {$producto->id};";

			$save = $this->db->query($update);
		}
		if($save){
			$result = true;
		}
		return $result;
	}


	public function updateStatus(){

		$result = false;
        $sql = "UPDATE pedidos set estado='{$this->getEstado()}' ";
		$sql .= "WHERE id={$this->getId()};"; 
		$edit = $this->db->query($sql);
		if($edit){
			$result = true;
		}
		return $result;
	}


	
	


	/**
	 * @param mixed $id 
	 * @return self
	 */
	public function setId($id): self {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @param mixed $usuario_id 
	 * @return self
	 */
	public function setUsuario_id($usuario_id): self {
		$this->usuario_id = $usuario_id;
		return $this;
	}
	
	/**
	 * @param mixed $provincia 
	 * @return self
	 */
	public function setProvincia($provincia): self {
		$this->provincia = $this->db->real_escape_string($provincia);
		return $this;
	}
	
	/**
	 * @param mixed $localidad 
	 * @return self
	 */
	public function setLocalidad($localidad): self {
		$this->localidad = $this->db->real_escape_string($localidad);
		return $this;
	}
	
	/**
	 * @param mixed $direccion 
	 * @return self
	 */
	public function setDireccion($direccion): self {
		$this->direccion = $this->db->real_escape_string($direccion);
		return $this;
	}
	
	/**
	 * @param mixed $coste 
	 * @return self
	 */
	public function setCoste($coste): self {
		$this->coste = $coste;
		return $this;
	}
	
	/**
	 * @param mixed $estado 
	 * @return self
	 */
	public function setEstado($estado): self {
		$this->estado = $estado;
		return $this;
	}
	
	/**
	 * @param mixed $fecha 
	 * @return self
	 */
	public function setFecha($fecha): self {
		$this->fecha = $fecha;
		return $this;
	}
	
	/**
	 * @param mixed $hora 
	 * @return self
	 */
	public function setHora($hora): self {
		$this->hora = $hora;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return mixed
	 */
	public function getUsuario_id() {
		return $this->usuario_id;
	}
	
	/**
	 * @return mixed
	 */
	public function getProvincia() {
		return $this->provincia;
	}
	
	/**
	 * @return mixed
	 */
	public function getLocalidad() {
		return $this->localidad;
	}
	
	/**
	 * @return mixed
	 */
	public function getDireccion() {
		return $this->direccion;
	}
	
	/**
	 * @return mixed
	 */
	public function getCoste() {
		return $this->coste;
	}
	
	/**
	 * @return mixed
	 */
	public function getEstado() {
		return $this->estado;
	}
	
	/**
	 * @return mixed
	 */
	public function getFecha() {
		return $this->fecha;
	}
	
	/**
	 * @return mixed
	 */
	public function getHora() {
		return $this->hora;
	}
	
}
