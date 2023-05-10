<?php


class Usuario{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
    private $imagen;
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
	
	/**
	 * @return mixed
	 */
	public function getApellidos() {
		return $this->apellidos;
	}
	
	/**
	 * @param mixed $apellidos 
	 * @return self
	 */
	public function setApellidos($apellidos): self {
		$this->apellidos = $this->db->real_escape_string($apellidos);
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * @param mixed $email 
	 * @return self
	 */
	public function setEmail($email): self {
		$this->email = $this->db->real_escape_string($email);
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getPassword() {
		return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['COST' => 4]);;
	}
	
	/**
	 * @param mixed $password 
	 * @return self
	 */
	public function setPassword($password): self {
		$this->password = $password;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	public function getRol() {
		return $this->rol;
	}
	
	/**
	 * @param mixed $rol 
	 * @return self
	 */
	public function setRol($rol): self {
		$this->rol = $rol;
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

    public function save(){
        $sql = "INSERT INTO usuarios VALUES(NULL, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', 'user', null);"; 
        $save = $this->db->query($sql);
		$result = false;
		if($save){
			$result = true;
		}
		return $result;
    }

	public function login(){
		$result = false;
		$email = $this->email;
		$password = $this->password;

		// Comprobar si existe el usuario
		$sql = "SELECT * FROM usuarios WHERE email = '{$email}'";
		$login = $this->db->query($sql);

		if($login && $login->num_rows == 1){
				$usuario = $login->fetch_object();

				// Verificar password
				$verify = password_verify($password, $usuario->password);

				
				if ($verify){
					$result = $usuario;

				}
		}
		return $result;

	}

}