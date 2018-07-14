<?php
include_once("clsChannel.php");
include_once("dt/DtDirectLink.php");
class clsDirectLink extends clsChannel
{
	static private $instance = NULL;
	private function __construct(){}
	static public function getInstance(){
		if (clsDirectLink::$instance == NULL)
			clsDirectLink::$instance = new clsDirectLink();
		return clsDirectLink::$instance;
	}
	public function __destruct(){}

	public function Ver($id){
		$this->open_connection();
		$query = "SELECT * FROM Channel inner join DirectLink on Channel.id = DirectLink.id WHERE DirectLink.id = ?;";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$r = $stmt->get_result();
		$r = $r->fetch_array();
		$afRows =  $stmt->affected_rows;
		$stmt->close();
		$this->close_connection();
		if ($r['id'] == $id){
			return new  DtDirectLink($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
			$r['src'],$r['tv'], $r['placeholder'], 1);
		}else {
			return NULL;
		}
	}

	public function Listar()
	{
		$this->query = "SELECT * FROM Channel inner join DirectLink on Channel.id = DirectLink.id";
		$res = $this->get_results_from_query();
		$arr = array();
		foreach ($res as $r) {
			array_push($arr,
			new  DtDirectLink($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
		  $r['src'],$r['tv'], $r['placeholder'],1));
		}
		array_pop($arr);
		return $arr;
	}

	public function ListarXPais($pais)
	{
		$this->query = "SELECT * FROM Channel inner join DirectLink on Channel.id = DirectLink.id WHERE Channel.country = $pais";
		$res = $this->get_results_from_query();
		$arr = array();
		foreach ($res as $r) {
			array_push($arr,
			new  DtDirectLink($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
		  $r['src'],$r['tv'], $r['placeholder'],1));
		}
		array_pop($arr);
		return $arr;
	}

	public function ListarXCategoria($categoria)
	{
		$this->query = "SELECT * FROM Channel inner join DirectLink on Channel.id = DirectLink.id WHERE Channel.category = $categoria";
		$res = $this->get_results_from_query();
		$arr = array();
		foreach ($res as $r) {
			array_push($arr,
			new  DtDirectLink($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
		  $r['src'],$r['tv'], $r['placeholder'],1));
		}
		array_pop($arr);
		return $arr;
	}

	public function ListarXActivo($active)
	{
		$this->query = "SELECT * FROM Channel inner join DirectLink on Channel.id = DirectLink.id WHERE Channel.active = $active";
		$res = $this->get_results_from_query();
		$arr = array();
		foreach ($res as $r) {
			array_push($arr,
			new  DtDirectLink($r['id'],  $r['number'],  $r['name'],  $r['coment'],  $r['views'],  $r['logo'],  $r['country'],  $r['category'],  $r['user'],  $r['active'],
		  $r['src'],$r['tv'], $r['placeholder'],1));
		}
		array_pop($arr);
		return $arr;
	}

	public function ContarXPais($pais)
	{
		$this->query = "SELECT count(*) as cont FROM Channel inner join DirectLink on Channel.id = DirectLink.id WHERE Channel.country = $pais";
		return $this->get_results_from_query()['cont'];
	}

	public function ContarXCategoria($categoria)
	{
		$this->query = "SELECT count(*) as cont FROM Channel inner join DirectLink on Channel.id = DirectLink.id WHERE Channel.category = $categoria";
		return $this->get_results_from_query();
	}

	public function ContarXActivo($active)
	{
		$this->query = "SELECT count(*) as cont FROM Channel inner join DirectLink on Channel.id = DirectLink.id WHERE Channel.active = $active";
		return $this->get_results_from_query()['cont'];
	}

	public function Insertar($number, $name, $coment,	$views, $logo, $country, $category, $user,
	$active, $src, $tv, $placeHolder)
	{
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		try{
					$this->open_connection();
					$this->conn->autocommit(false);
					$dev = "</br>";
					$query = "
								INSERT INTO Channel (number,name,coment,views,logo,country,category,user,active) VALUES
								(?,?,?,?,?,?,?,?,?);
					";
					$dev .= "</br>".$query;
					$stmt = $this->conn->prepare($query);
					$stmt->bind_param('issisiisi',$number,$name,$coment,$views,$logo,$country,$category,
					$user,$active
				);
					$stmt->execute();
					$query = "
								INSERT INTO DirectLink (id,src,tv,placeholder) VALUES
								(@@identity,?,?,?);
					";
					$dev .= $query;
					$stmt = $this->conn->prepare($query);
					$stmt->bind_param('sis',$src,$tv,$placeHolder);
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

	public function Editar($id,$number, $name, $coment,	$views, $logo, $country, $category, $user,
	$active, $src, $tv, $placeHolder)
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
						UPDATE DirectLink SET
						src=?, tv=?, placeholder=?
						WHERE id = ?;
					";
					$dev .= $query;
					$stmt = $this->conn->prepare($query);
					$stmt->bind_param('sisi',$src,$tv,$placeHolder,$id);
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
}
?>
