<?php

class Categoria{
    private $id;
    private $nombre;

    
    // Conexion a base de datos
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

    public function getAll(){
        $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;
    }

	public function getOne(){
        $categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->getId()};");
        return $categoria->fetch_object();
    }

    public function save(){
        $sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');"; 
        $save = $this->db->query($sql);
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
    }

}

?>