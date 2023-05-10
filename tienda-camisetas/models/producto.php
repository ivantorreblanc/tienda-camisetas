<?php
class Producto
{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }





	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
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
	 * @return mixed
	 */
	public function getCategoria_id() {
		return $this->categoria_id;
	}
	
	/**
	 * @param mixed $categoria_id 
	 * @return self
	 */
	public function setCategoria_id($categoria_id): self {
		$this->categoria_id = $categoria_id;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getNombre() {
		return $this->nombre;
	}
	
	/**
	 * @param mixed $nombre 
	 * @return self
	 */
	public function setNombre($nombre): self {
		$this->nombre = $this->db->real_escape_string($nombre);
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getDescripcion() {
		return $this->descripcion;
	}
	
	/**
	 * @param mixed $descripcion 
	 * @return self
	 */
	public function setDescripcion($descripcion): self {
		$this->descripcion = $this->db->real_escape_string($descripcion);
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPrecio() {
		return $this->precio;
	}
	
	/**
	 * @param mixed $precio 
	 * @return self
	 */
	public function setPrecio($precio): self {
		$this->precio = $this->db->real_escape_string($precio);
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getStock() {
		return $this->stock;
	}
	
	/**
	 * @param mixed $stock 
	 * @return self
	 */
	public function setStock($stock): self {
		$this->stock = $this->db->real_escape_string($stock);
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getOferta() {
		return $this->oferta;
	}
	
	/**
	 * @param mixed $oferta 
	 * @return self
	 */
	public function setOferta($oferta): self {
		$this->oferta = $this->db->real_escape_string($oferta);
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getFecha() {
		return $this->fecha;
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
	 * @return mixed
	 */
	public function getImagen() {
		return $this->imagen;
	}
	
	/**
	 * @param mixed $imagen 
	 * @return self
	 */
	public function setImagen($imagen): self {
		$this->imagen = $imagen;
		return $this;
	}

	public function getCantidad(){
		$sql = "SELECT stock FROM productos WHERE id = {$this->getId()};";
		$result = $this->db->query($sql);
		return $result;
	}

	public function getOne(){
        $producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()};");
		if($producto->num_rows > 0){
			return $producto->fetch_object();
		}else{
			return false;
		}
        
    }

    public function getAll(){
        $productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC;");
        return $productos;
    }

	public function getByCategoria(){
		$sql = "SELECT p.*, c.nombre as 'categoria' FROM productos p "
				."INNER JOIN categorias c ON c.id = p.categoria_id "  
				."WHERE p.categoria_id = {$this->getCategoria_id()} "
				."ORDER BY id DESC;";
        $productos = $this->db->query($sql);
        return $productos;
    }

	public function getRandom($limit){
		$productos = $this->db->query("SELECT * FROM productos WHERE stock > 0 ORDER BY RAND() LIMIT $limit;");
        return $productos;
	}

	public function save(){
		Utils::isAdmin();
		$result = false;
        $sql = "INSERT INTO productos VALUES(NULL, '{$this->getCategoria_id()}', '{$this->getNombre()}', '{$this->getDescripcion()}', {$this->getPrecio()}, {$this->getStock()}, NULL, CURDATE(), '{$this->getImagen()}');"; 
		$save = $this->db->query($sql);
		if($save){
			$result = true;
		}
		return $result;
    }
	
	public function edit(){
		Utils::isAdmin();
		$result = false;
        $sql = "UPDATE productos set categoria_id={$this->getCategoria_id()}, nombre='{$this->getNombre()}', descripcion='{$this->getDescripcion()}', precio={$this->getPrecio()}, stock={$this->getStock()}";
		if($this->getImagen() != null){
			$sql .= ", imagen='{$this->getImagen()}'";
		}
		$sql .= " WHERE id={$this->getId()};"; 
		$edit = $this->db->query($sql);
		if($edit){
			$result = true;
		}
		return $result;
    }
	
	public function delete(){
		$sql = "DELETE FROM productos WHERE id={$this->id}";
		$delete = $this->db->query($sql);
		$result = false;
		if($delete){
			$result = true;
		}
		return $result;
	}


}
