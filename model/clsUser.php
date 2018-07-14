<?php
include_once("DB/DbAbstractModel_MYSQL.php");
class clsUser extends DBAbstractModel
{
  static private $instance = NULL;
	private function __construct(){}
	static public function getInstance(){
		if (clsUser::$instance == NULL)
			clsUser::$instance = new clsUser();
		return clsUser::$instance;
	}
	public function __destruct(){}

  	public function Ver($nombre){
  		$this->query = "SELECT nombre FROM Usuario WHERE Usuario.nombre = '{$nombre}'";
  		return $this->get_results_from_query();
  	}

  	public function Listar()
  	{
  		$this->query = "SELECT nombre FROM Usuario";
  		return $this->get_results_from_query();
  	}

  	public function Insertar($nombre,$pass)
  	{
  		$this->query = "INSERT INTO Usuario(nombre,pass) VALUES ('{$nombre}','{$pass}')";
    	$this->execute_single_query();
    	return $this->affRows;
  	}

  	public function Eliminar($nombre)
  	{
  		$this->query = "DELETE FROM Usuario WHERE (nombre = '{$nombre}')";
    	$this->execute_single_query();
    	return $this->affRows;
  	}

  	public function Editar($nombre,$pass){
  		$this->query = "UPDATE Usuario SET pass = '{$pass}' WHERE nombre = '{$nombre}'";
  		$this->execute_single_query();
    	return $this->affRows;
  	}

}

?>
