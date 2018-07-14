<?php
include_once("DB/DbAbstractModel_MYSQL.php");
include_once("dt/DtPais.php");
class clsPais extends DBAbstractModel

{
	static private $instance = NULL;
	private function __construct(){}
	static public function getInstance(){
		if (clsPais::$instance == NULL)
			clsPais::$instance = new clsPais();
		return clsPais::$instance;
	}
	public function __destruct(){}


	public function Ver($id){
		$this->open_connection();
		$query = "SELECT * FROM Pais WHERE Pais.id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$r = $stmt->get_result();
		$r = $r->fetch_array();
		$afRows =  $stmt->affected_rows;
		$stmt->close();
		$this->close_connection();
		if ($r['id'] == $id){
			return new  DtPais($r['id'],$r['nombre'],$r['codigo']);
		}else {
			return NULL;
		}
	}

	public function Listar()
	{
		$this->query = "SELECT * FROM Pais";
		$res = $this->get_results_from_query();
		$arr = array();
		foreach ($res as $r) {
			array_push($arr, new  DtPais($r['id'],$r['nombre'],$r['codigo']));
		}
		array_pop($arr);
		return $arr;
	}

	public function Insertar($nombre,$codigo)
	{
		$this->query = "INSERT INTO Pais(nombre,codigo) VALUES ('{$nombre}','{$codigo}')";
  	$this->execute_single_query();
  	return $this->affRows;
	}

	public function Eliminar($id)
	{
		$this->query = "DELETE FROM Pais WHERE (id = '{$id}')";
  	$this->execute_single_query();
  	return $this->affRows;
	}

	public function Editar($id,$nombre,$codigo){
		$this->query = "UPDATE Pais SET nombre = '{$nombre}', codigo = '{$codigo}' WHERE id = '{$id}'";
		$this->execute_single_query();
  	return $this->affRows;
	}

}
?>
