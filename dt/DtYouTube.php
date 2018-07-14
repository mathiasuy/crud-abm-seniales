<?php
include_once("DtChannel.php");
include_once("DtPais.php");
include_once("DtCategoria.php");
class DtYouTube extends DtChannel
{
	public $channel;
	public $src;
	public $yt_nameVideo;
	public $yt_nameChannel;
	public $yt_logo;
	public $yt_rating;
	public $yt_description;
	public $video;

	public function __construct($id,  $number,  $name,  $coment,  $views,  $logo,  $country,  $category,  $user,  $active,
  $channel,  $src,  $yt_nameVideo, $yt_nameChannel, $yt_logo, $yt_rating, $yt_description, $video, $check){
    	parent::__construct($id,  $number,  $name,  $coment,  $views,  $logo,  $country,  $category,  $user,  $active, $check);
      $this->channel = $channel;
    	$this->src = $src;
    	$this->yt_nameVideo = $yt_nameVideo;
    	$this->yt_nameChannel = $yt_nameChannel;
    	$this->yt_logo = $yt_logo;
    	$this->yt_rating = $yt_rating;
			$this->video = $video;
    	$this->yt_description = $yt_description;
  }
	public function __destruct(){}

	public function get($atributo)
	{
		if ($atributo == "category"){
			$ctrCategory = ctrCategory::getInstance();
			return $ctrCategory->Ver($this->category);
		}
		if ($atributo == "country"){
			$ctrCountry = ctrPais::getInstance();
			return $ctrCountry->Ver($this->country);
		}
		return $this->$atributo;
	}

	public function toString(){
		$r = $this;
		$str = "";
		$str .= ''.$r->get('number').": ";
		$str .= '<b>'.$r->get('name')."</b></br>";
		$str .= ''.$r->get('country')->toString()."</br>";
		$str .= ''.$r->get('category')->toString()."</br>"."</br>";
		$str .= "YT: <b>".$r->get('yt_nameChannel')."</b>";
		$str .= $r->get('yt_rating')==""?"":' <b>(Mirando ahora: '.$r->get('yt_rating').")</b></br>";
		$str .= '</br>YT: Descripcion : '.$r->get('yt_description')."</br>"."</br>";
		$str .= '<img src="'.$r->get('yt_logo').'" ></img></br>';
		$str .= 'Comentarios: '.$r->get('coment')."</br>";
		$str .= 'Visitas: '.$r->get('views')."</br>";
		$str .= 'Logo: '.$r->get('logo')."</br>";
		$str .= "Logo (YT): ".$r->get('yt_logo')."</br>";
		$str .= '<img src="'.$r->get('logo').'" ></img></br>'."</br>";
		$str .= 'ID '.$r->get('id')." - ";
		$str .= "(YouTube)"."</br>";
		$str .= 'User: '.$r->get('user')."</br>";
		$str .= 'Activo?: '.$r->get('active')."</br>";
		$str .= "Canal: ".$r->get('channel')."</br>";
		$str .= "SRC: ".$r->get('src')."</br>"."</br>";
//		$str .= $r->get('src')?'<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$r->get('src').'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'."</br>":"".'</br>';
//		$str .= $r->get('src')?'<a href="https://www.youtube.com/embed/'.$r->get('src').'">Link al canal: '.$r->get('name')."</a></br>":"EMISIÓN EN VIVO NO DISPONIBLE".'</br>';
		$str .= "YT: Nombre de video: ".$r->get('yt_nameVideo')."</br>";
		$str .= 'YT: Comprobar canal?: '.$r->get('video')."</br>";
		return $str;
	}

	public function getBasico(){
		$r = $this;
		$str = "";
		$str .= ''.$r->get('number').": ";
		$str .= '<b>'.$r->get('name')."";
		$str .= $r->get('yt_rating')==""?"":' <b>(Mirando ahora: '.$r->get('yt_rating').")</b></br>";
		$str .= '<img src="'.$r->get('yt_logo').'" ></img></br>';
		$str .= 'Activo?: '.$r->get('active')."</br>";
		$str .= "Canal: ".$r->get('channel')."</br>";
		$str .= "SRC: ".$r->get('src')."</br>"."</br>";
//		$str .= $r->get('src')?'<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$r->get('src').'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'."</br>":"".'</br>';
//		$str .= $r->get('src')?'<a href="https://www.youtube.com/embed/'.$r->get('src').'">Link al canal: '.$r->get('name')."</a></br>":"EMISIÓN EN VIVO NO DISPONIBLE".'</br>';
		return $str;
	}

	public function getData(){
		$r = $this;
    $arr = array(
      "number" => $r->get('number'),
      "nombre" => $r->get('name'),
      'video' => $r->get('src'),
      //'iframe' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$r->get('src').'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>',
      //'link' => 'https://www.youtube.com/watch?v='.$r->get('src').'',
      'ignorar_chk' => $r->get('check'),
      'tv' => false,
      'medio' => $r->get('video')?3:2,
      'numero' => $r->get('number'),
      'id' => $r->get('id'),
      'check' => $r->get('check'),
      'active' => $r->get('active'),
			'iframe' => $r->get('active')?'<iframe  style="width:100%; height:480;"  src="https://www.youtube.com/embed/'.$r->get('src').'?rel=0&showinfo=0&autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'."</br>":"<b>Señal no habilitada.</b>".'</br>',
			'link' => $r->get('src')?'<a target="_blank" href="https://www.youtube.com/embed/'.$r->get('src').'">Link al canal: '.$r->get('name')."</a></br>":"<b>EMISIÓN EN VIVO NO DISPONIBLE</b>".'</br>',
			'embed_link' => $r->get('src')?'https://www.youtube.com/embed/'.$r->get('src'):"undefined",
			'videoId' => $r->get('src'),
      'visitas' => $r->get('views'),
      'comentarios' => $r->get('coment'),
      'yt_nameVideo' => $r->get('yt_nameVideo'),
      'yt_nameChannel' => $r->get('yt_nameChannel'),
      'yt_description' => $r->get('yt_description'),
      'yt_rating' => $r->get('yt_rating'),
      'codigo' => $r->get('id'),
      'logo' => $r->get('logo')==""?$r->get('yt_logo'):$r->get('logo'),
      'yt_logo' => $r->get('yt_logo')
    );
    return $arr;
  }

}

?>
