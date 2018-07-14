<?php
include_once("clsChannel.php");
include_once("dt/DtIFrame.php");
class clsIFrame  extends clsChannel
{

	static private $instance = NULL;
	private function __construct(){}
	static public function getInstance(){
		if (clsIFrame::$instance == NULL)
			clsIFrame::$instance = new clsIFrame();
		return clsIFrame::$instance;
	}


//	public function __construct(){}
	public function __destruct(){}

	public function set($atributo, $contenido)
	{
		$this->$atributo = $contenido;
	}

	public function get($atributo)
	{
		return $this->$atributo;
	}


		public function Ver($id){
			$this->open_connection();
			$query = "SELECT * FROM Channel inner join IFrame on Channel.id = IFrame.id WHERE IFrame.id = ?;";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$r = $stmt->get_result();
			$r = $r->fetch_array();
			$afRows =  $stmt->affected_rows;
			$stmt->close();
			$this->close_connection();
			if ($r['id'] == $id){
				return new  DtIFrame($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
				$r['src'],$r['tv'], 1);
			}else {
				return NULL;
			}

		}

		public function Listar()
		{
			$this->query = "SELECT * FROM Channel inner join IFrame on Channel.id = IFrame.id";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new  DtIFrame($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
			  $r['src'],$r['tv'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ListarXPais($pais)
		{
			$this->query = "SELECT * FROM Channel inner join IFrame on Channel.id = IFrame.id WHERE Channel.country = $pais";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new  DtIFrame($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
			  $r['src'],$r['tv'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ListarXCategoria($categoria)
		{
			$this->query = "SELECT * FROM Channel inner join IFrame on Channel.id = IFrame.id WHERE Channel.category = $categoria";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new  DtIFrame($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
			  $r['src'],$r['tv'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ListarXActivo($activo)
		{
			$this->query = "SELECT * FROM Channel inner join IFrame on Channel.id = IFrame.id WHERE Channel.active = $activo";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new  DtIFrame($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
			  $r['src'],$r['tv'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ContarXPais($pais)
		{
			$this->query = "SELECT count(*) FROM Channel inner join IFrame on Channel.id = IFrame.id WHERE Channel.country = $pais";
			return $this->get_results_from_query()[0];
		}

		public function ContarXCategoria($categoria)
		{
			$this->query = "SELECT count(*) as cont FROM Channel inner join IFrame on Channel.id = IFrame.id WHERE Channel.category = $categoria";
			return $this->get_results_from_query();
		}

		public function ContarXActivo($activo)
		{
			$this->query = "SELECT count(*) FROM Channel inner join IFrame on Channel.id = IFrame.id WHERE Channel.active = $activo";
			return $this->get_results_from_query()[0];
		}

		public function Insertar($number, $name, $coment,
		$views, $logo, $country, $category, $user, $active, $src, $tv)
		{
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			try{
						$this->open_connection();
						$this->conn->autocommit(false);
						$query = "
									INSERT INTO Channel (number,name,coment,views,logo,country,category,user,active) VALUES
									(?,?,?,?,?,?,?,?,?);
						";
						$stmt = $this->conn->prepare($query);
						$stmt->bind_param('issisiisi',$number,$name,$coment,$views,$logo,$country,$category,
						$user,$active
						);
						$stmt->execute();
						$query = "
									INSERT INTO IFrame (id,src,tv) VALUES
									(@@identity,?,?);
						";
						$stmt = $this->conn->prepare($query);
						$stmt->bind_param('si',$src,$tv);
						$stmt->execute();
						$this->conn->commit();
						$afRows =  $stmt->affected_rows;
						return $afRows;
				}catch (\mysqli_sql_exception  $exception){
						$this->conn->rollback();
				}finally {
					  isset($stmt) && $stmt->close();
					  $this->conn->autocommit(true);
						$this->close_connection();
				}
		}

		public function Editar($id, $number, $name, $coment,
		$views, $logo, $country, $category, $user, $active, $src, $tv)
		{
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			try{
						$this->open_connection();
						$this->conn->autocommit(false);
						$dev = "";
						$this->open_connection();
						$query = "
							UPDATE Channel SET number=?, name=?, coment=?, views=?, logo=?,
										country=?, category=?, user=?, active=?
							WHERE Channel.id = ?;
						";
						$dev .= $query;
						$stmt = $this->conn->prepare($query);
						$stmt->bind_param('issisiisii',$number, $name, $coment, $views, $logo,
									$country, $category, $user, $active,$id);
						$stmt->execute();
						$query = "
							UPDATE IFrame SET
							src=?, tv=?
							WHERE id = ?;
						";
						$dev .= $query;
						$stmt = $this->conn->prepare($query);
						$stmt->bind_param('sii',$src,$tv,$id);
						$stmt->execute();
						$afRows =  $stmt->affected_rows;
						$this->conn->commit();
						$afRows =  $stmt->affected_rows;
						return $afRows;
				}catch (\mysqli_sql_exception  $exception){
						$this->conn->rollback();
				}finally {
					  isset($stmt) && $stmt->close();
					  $this->conn->autocommit(true);
						$this->close_connection();
				}
		}

		public function Eliminar($id)
	  {
	    $this->open_connection();
	    $query = "call BajaCanal(?,@msg)";
	    $stmt = $this->conn->prepare($query);
	    $stmt->bind_param('i', $id);
	    $stmt->execute();
	    $afRows =  $stmt->affected_rows;
	    $stmt->close();
	    $this->close_connection();
	    return $afRows;
	  }

}
?>
