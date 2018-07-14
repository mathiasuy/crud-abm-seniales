<?php
include_once("DB/DbAbstractModel_MYSQL.php");
include_once("dt/DtCategoria.php");
class clsCategory  extends DBAbstractModel
{
	static private $instance = NULL;
	private function __construct(){}
	static public function getInstance(){
		if (clsCategory::$instance == NULL)
			clsCategory::$instance = new clsCategory();
		return clsCategory::$instance;
	}
	public function __destruct(){}

	public function Ver($id){
		$this->open_connection();
		$query = "SELECT * FROM Categoria WHERE Categoria.id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$r = $stmt->get_result();
		$r = $r->fetch_array();
		$afRows =  $stmt->affected_rows;
		$stmt->close();
		$this->close_connection();
		if ($r['id'] == $id){
			return new DtCategoria($r['id'],$r['nombre'],$r['comentario']);
		}else {
			return NULL;
		}
	}

	public function Listar()
	{
		$this->query = "SELECT * FROM Categoria";
		$res = $this->get_results_from_query();
		$arr = array();
		foreach ($res as $r) {
			array_push($arr, new  DtCategoria($r['id'],$r['nombre'],$r['comentario']));
		}
		array_pop($arr);
		return $arr;
	}

	public function Insertar($nombre,$comentario)
	{
		$this->query = "INSERT INTO Categoria(nombre,comentario) VALUES ('{$nombre}','{$comentario}')";
  	$this->execute_single_query();
  	return $this->affRows;
	}

	public function Eliminar($id)
	{
		$this->query = "DELETE FROM Categoria WHERE (id = '{$id}')";
  	return $this->affRows;
	}

	public function Editar($id,$nombre,$comentario){
		$this->query = "UPDATE Categoria SET nombre = '{$nombre}', comentario = '{$comentario}' WHERE id = '{$id}'";
		$this->execute_single_query();
		return $this->affRows;
	}

}
?>
