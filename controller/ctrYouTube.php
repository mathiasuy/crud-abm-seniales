<?php
include_once("model/clsYouTube.php");
include_once("model/clsPais.php");
include_once("model/clsCategory.php");
include_once("controller/Yapi.php");
class ctrYouTube
{
	private $youTube;
	private static $instance = NULL;

	private function __construct()
	{
		$this->youTube = clsYouTube::getInstance();
	}

	public static function getInstance(){
		if (ctrYouTube::$instance == NULL){
			ctrYouTube::$instance = new ctrYouTube();
		}
		return ctrYouTube::$instance;
	}

	public function Index()
	{
		$resultado = $this->youTube->Listar();
		return $resultado;
	}

	public function ListarXActivo($activo)
	{
    $arr = array();
    $resultado_yt = $this->youTube->ListarXActivo($activo);
    foreach($resultado_yt as $e){
    	$arr[$e->get('id')] = $e;
    }
    ksort($arr);
    return $arr;
	}

public function updateData($seniales){

	$yapi = Yapi::getInstance();
	$in = 0;
	foreach ($seniales as $s) {
		if ($s->get('channel') != "" && $s->get('check') == 1 ){
			$in++;
		//		echo "<script>alert(".$s->get('id').");</script>";
				$in_src = $s->video==0?$yapi->getVideoLiveIdFromchannelId($s->get('channel')):$s->src;
				$yt_nameVideo = $s->get('yt_nameVideo');
				$yt_nameChannel = $yapi->getChannelTitleFromVideoId($in_src);
				$yt_logo = $yapi->getChannelLogo($s->get('channel'),1);
				$yt_rating = $s->get('yt_rating');
				$yt_description = $yapi->getVideoDescripcion($in_src);
				$video = $s->get('video');
				$active = !($in_src=="");
				$this->Editar($s->get('id'),$s->get('number'), $s->get('name'), $s->get('coment'),
				$s->get('views'), $s->get('logo'), $s->get('country'), $s->get('category'), $s->get('user'),
				$active, $s->get('channel'), $in_src, $yt_nameVideo, $yt_nameChannel,
				$yt_logo, $yt_rating, $yt_description, $video);
			}
		}
		return $in;
}

public function updateRating($seniales){
	$yapi = Yapi::getInstance();
	$in = 0;
	foreach ($seniales as $s) {
		if ($s->get('src') != ""){
			$in++;
			$in_src = $s->get("src");
			$yt_nameVideo = $s->get('yt_nameVideo');
			$yt_nameChannel = $s->get("yt_nameChannel");
			$yt_logo = $s->get("yt_logo");
			$yt_rating = $yapi->getCountViewers($in_src);
			$yt_description = $s->get("yt_description");
			$video = $s->get('video');
			$this->Editar($s->get('id'),$s->get('number'), $s->get('name'), $s->get('coment'),
			$s->get('views'), $s->get('logo'), $s->get('country'), $s->get('category'), $s->get('user'),
			$s->get('active'), $s->get('channel'), $in_src, $yt_nameVideo, $yt_nameChannel,
			$yt_logo, $yt_rating, $yt_description, $video);
		}
	}
	return $in;
}

	public function Agregar($number, $name, $coment,
	$logo, $country, $category,
	$active, $src, $channel, $video)
	{
		$yapi = Yapi::getInstance();
		if ($channel == ""){
			$channel = $yapi->getChannelIdFromVideoId($src);
		}
		if ($src == ""){
			$src = $yapi->getVideoLiveIdFromchannelId($channel);
		}
		$yt_nameVideo = "N/D";
		$yt_nameChannel = $yapi->getChannelTitleFromVideoId($src);
		$yt_logo = $yapi->getChannelLogo($channel,1);
		$yt_rating = $yapi->getCountViewers($src);
		$yt_description  = $yapi->getChannelDescripcion($channel);
		$yt_description .= $yapi->getVideoDescripcion($src);
		return $this->youTube->Insertar($number, $name, $coment,
		0, $logo, $country, $category, "Public",
		$active, $channel, $src, $yt_nameVideo, $yt_nameChannel,
		$yt_logo, $yt_rating, $yt_description, $video);
	}

	public function Ver($id)
	{
		//var_dump($id);
		$re = $this->youTube->Ver($id);
		return $re;
		/*
		foreach ($resultado as $re){
			var_dump($re);
		}
		*/
	}

	public function Eliminar($id)
	{
		return $this->youTube->Eliminar($id);
	}

	public function Editar($id,$number, $name, $coment,
	$views, $logo, $country, $category, $user,
	$active, $channel, $src, $yt_nameVideo, $yt_nameChannel,
	$yt_logo, $yt_rating, $yt_description, $video)
	{
		//echo "<script>alert('".$this->youTube->get('user')."');</script>";
	return 	$this->youTube->Editar($id,$number, $name, $coment,
		$views, $logo, $country->get('id'), $category->get('id'), $user,
		$active, $channel, $src, $yt_nameVideo, $yt_nameChannel,
		$yt_logo, $yt_rating, $yt_description, $video);
	}

	public function EditarManual($id,$number, $name, $coment,
	$logo, $src, $channel, $active, $category, $country, $video)
	{
		$e = $this->youTube->Ver($id);
		//echo "<script>alert('".$this->youTube->get('user')."');</script>";
		return $this->youTube->Editar($id,$number, $name, $coment,
		$e->get('views'), $logo, $country, $category, $e->get('user'),
		$active, $channel, $src, $e->get('yt_nameVideo'), $e->get('yt_nameChannel'),
		$e->get('yt_logo'), $e->get('yt_rating'), $e->get('yt_description'), $video);
	}
}
?>
