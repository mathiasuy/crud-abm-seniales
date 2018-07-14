<?php
include_once("DtChannel.php");
include_once("DtPais.php");
include_once("DtCategoria.php");
class DtDirectLink extends DtChannel
{
  private $src;
	private $tv;
	private $placeHolder;

	public function __construct($id,  $number,  $name,  $coment,  $views,  $logo,  $country,  $category,  $user,  $active,
  $src,$tv, $placeHolder, $check){
    	parent::__construct($id,  $number,  $name,  $coment,  $views,  $logo,  $country,  $category,  $user,  $active, $check);
      $this->src = $src;
      $this->tv = $tv;
      $this->placeHolder = $placeHolder;
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

    $str .= ''.$r->get('number');
    $str .= ': '.$r->get('name')."";
    $str .= " (enlace directo)"."</br>";
    $str .= ''.$r->get('country')->toString()."</br>";
    $str .= ''.$r->get('category')->toString()."</br>"."</br>";
    $str .= 'Comentarios: '.$r->get('coment')."</br>";
    $str .= 'Visitas: '.$r->get('views')."</br>";
    $str .= 'Logo: '.$r->get('logo')."</br>";
    $str .= '<img src="'.$r->get('logo').'" ></img></br>'."</br>";
//    $str .= $r->get('src')?'<video width="560" height="315" src="'.$r->get('src').'" frameborder="0" allow="autoplay; encrypted-media" controls allowfullscreen></video>'."</br>":"".'</br>';
//    $str .= $r->get('src')?'<a href="'.$r->get('src').'">Link al canal: '.$r->get('name')."</a></br>":"EMISIÓN EN VIVO NO DISPONIBLE".'</br>';
    $str .= 'ID: '.$r->get('id').'</br>';
    $str .= 'User: '.$r->get('user')."</br>";
    $str .= 'Activo?: '.$r->get('active')."</br>";
    $str .= 'SRC: '.$r->get('src')."</br>";
    $str .= 'TV?: '.$r->get('tv')."</br>";
    $str .= 'Place Holder: '.$r->get('placeHolder')."</br>";
    return $str;
  }


    public function getData(){
      $r = $this;
      $arr = array(
        "numero" => $r->get('number'),
        "id" => $r->get('id'),
        "nombre" => $r->get('name'),
        'video' => $r->get('src'),
        'embed_link' => $r->get('src'),
        'medio' => '1',
        'check' => $r->get('check'),
        'ignorar_chk' => $r->get('check'),
        'active' => $r->get('active'),
        'iframe' => $r->get('src')?'<video width="100%" src="'.$r->get('src').'" frameborder="0" allow="autoplay; encrypted-media" controls allowfullscreen  autoplay  data-viblast-key="d8844439-6c65-4770-878d-ce1bc3f81174" type="application/x-mpegURL" ></video>'."</br>":"".'</br>',
        'link' => $r->get('src')?'<a href="'.$r->get('src').'">Link al canal: '.$r->get('name')."</a></br>":"EMISIÓN EN VIVO NO DISPONIBLE".'</br>',
        'src' => $r->get('src')?$r->get('src'):"undefined",
        'tv' => $r->get('tv')?1:0,
        'comentarios' => $r->get('coment'),
        'codigo' => $r->get('id'),
        'logo' => $r->get('logo'),
        'visitas' => $r->get('views'),
        'placeHolder' => $r->get('placeHolder')
      );
      return $arr;
    }

}
?>
