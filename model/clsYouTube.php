<?php
include_once("clsChannel.php");
include_once("dt/DtYouTube.php");
include_once("clsCategory.php");
include_once("clsPais.php");
class clsYouTube extends clsChannel
{
	static private $instance = NULL;
	private function __construct(){}

	static public function getInstance(){
		if (clsYouTube::$instance == NULL)
			clsYouTube::$instance = new clsYouTube();
		return clsYouTube::$instance;
	}

	public function __destruct(){}

		public function Ver($id){
			$this->open_connection();
			$query = "SELECT * FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE YouTube.id = ?;";
			$stmt = $this->conn->prepare($query);
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$r = $stmt->get_result();
			$r = $r->fetch_array();
			$afRows =  $stmt->affected_rows;
			$stmt->close();
			$this->close_connection();
			if ($r['id'] == $id){
				$dt = new DtYouTube($r['id'],$r['number'],$r['name'],$r['coment'],
				$r['views'],$r['logo'],$r['country'],$r['category'],$r['user'],$r['active'],$r['channel'],
				$r['src'],$r['yt_nameVideo'],$r['yt_nameChannel'],$r['yt_logo'],isset($r['yt_rating'])?$r['yt_rating']:0,$r['yt_description'],$r['video'],1);
				return $dt;
			}else {
				return NULL;
			}
		}

		public function Listar()
		{
			$this->query = "SELECT * FROM Channel inner join YouTube on Channel.id = YouTube.id";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new DtYouTube($r['id'],$r['number'],$r['name'],$r['coment'],
				$r['views'],$r['logo'],$r['country'],$r['category'],$r['user'],$r['active'],$r['channel'],
				$r['src'],$r['yt_nameVideo'],$r['yt_nameChannel'],$r['yt_logo'],$r['yt_rating'],$r['yt_description'],$r['video'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ListarXPais($pais)
		{
			$this->query = "SELECT * FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE Channel.country = $pais";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new DtYouTube($r['id'],$r['number'],$r['name'],$r['coment'],
				$r['views'],$r['logo'],$r['country'],$r['category'],$r['user'],$r['active'],$r['channel'],
				$r['src'],$r['yt_nameVideo'],$r['yt_nameChannel'],$r['yt_logo'],$r['yt_rating'],$r['yt_description'],$r['video'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ListarXCategoria($categoria)
		{
			$this->query = "SELECT * FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE Channel.category = $categoria";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new DtYouTube($r['id'],$r['number'],$r['name'],$r['coment'],
				$r['views'],$r['logo'],$r['country'],$r['category'],$r['user'],$r['active'],$r['channel'],
				$r['src'],$r['yt_nameVideo'],$r['yt_nameChannel'],$r['yt_logo'],$r['yt_rating'],$r['yt_description'],$r['video'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ListarXActivo($activo)
		{
			$this->query = "SELECT * FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE Channel.active = $activo";
			$res = $this->get_results_from_query();
			$arr = array();
			foreach ($res as $r) {
				array_push($arr,
				new DtYouTube($r['id'],$r['number'],$r['name'],$r['coment'],
				$r['views'],$r['logo'],$r['country'],$r['category'],$r['user'],$r['active'],$r['channel'],
				$r['src'],$r['yt_nameVideo'],$r['yt_nameChannel'],$r['yt_logo'],$r['yt_rating'],$r['yt_description'],$r['video'],1));
			}
			array_pop($arr);
			return $arr;
		}

		public function ContarXPais($pais)
		{
			$this->query = "SELECT count(*) FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE Channel.country = $pais";
			return $this->get_results_from_query()[0];
		}

		public function ContarXCategoria($categoria)
		{
			$this->query = "SELECT count(*) as cont  FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE Channel.category = $categoria";
			return $this->get_results_from_query() ;
		}

		public function ContarXActivo($activo)
		{
			$this->query = "SELECT count(*) FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE Channel.active = $activo";
			return $this->get_results_from_query()[0];
		}

		public function Insertar($number, $name, $coment,
		$views, $logo, $country, $category, $user,
		$active, $channel, $src, $yt_nameVideo, $yt_nameChannel,
		$yt_logo, $yt_rating, $yt_description, $video)
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
					$user,$active);
					$stmt->execute();
					$afRows = 0;
					$query = "
					INSERT INTO YouTube (id,channel,src,yt_nameVideo,yt_nameChannel,yt_logo,yt_rating,yt_description,video) VALUES
					(@@identity,?,?,?,?,?,?,?,?);
					";
					$stmt = $this->conn->prepare($query);
					$stmt->bind_param('sssssisi',$channel,$src,$yt_nameVideo,$yt_nameChannel,
					$yt_logo,$yt_rating,$yt_description,$video);
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
		$views, $logo, $country, $category, $user,
		$active, $channel, $src, $yt_nameVideo, $yt_nameChannel,
		$yt_logo, $yt_rating, $yt_description,$video)
		{
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
			try{
						$this->open_connection();
						$this->conn->autocommit(false);
						$dev = "";
						//echo "<script>alert('affected rows: ".$this->user."');</script>";
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
							UPDATE YouTube SET
									channel=?, src=?, yt_nameVideo=?, yt_nameChannel=?, yt_logo=?,
							 		yt_rating=?, yt_description=?, video=?
							WHERE id = ?;
						";
						$dev .= $query;
						$stmt = $this->conn->prepare($query);
						$stmt->bind_param('sssssisii',$channel, $src, $yt_nameVideo, $yt_nameChannel, $yt_logo,
						$yt_rating, $yt_description, $video,$id);
						$stmt->execute();
						//$result = $select->fetch_assoc();
						$r = $this->conn->query('SELECT @msg as salida');
						$result = $r->fetch_assoc();
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
