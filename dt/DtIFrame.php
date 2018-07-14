<?php
include_once("DtChannel.php");
include_once("DtPais.php");
include_once("DtCategoria.php");
class DtIFrame extends DtChannel
{
  private $src;
	private $tv;

	public function __construct($id,  $number,  $name,  $coment,  $views,  $logo,  $country,  $category,  $user,  $active,
  $src,$tv, $check){
    	parent::__construct($id,  $number,  $name,  $coment,  $views,  $logo,  $country,  $category,  $user,  $active, $check);
      $this->src = $src;
      $this->tv = $tv;
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
      $str .= ' '.$r->get('name')." ";
      $str .= "(embedido)"."</br>";
      $str .= ''.$r->get('country')->toString()."</br>";
      $str .= ''.$r->get('category')->toString()."</br>"."</br>";
      $str .= 'Comentarios: '.$r->get('coment')."</br>";
      $str .= 'Visitas: '.$r->get('views')."</br>"."</br>";
      $str .= 'Logo: '.$r->get('logo')."</br>";
      $str .= '<img src="'.$r->get('logo').'" ></img></br>'."</br>";
      //$str .= $r->get('src')?'<iframe width="560" height="315" src="'.$r->get('src').'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'."</br>":"".'</br>';
      //$str .= $r->get('src')?'<a href="'.$r->get('src').'">Link al canal: '.$r->get('name')."</a></br>":"EMISIÓN EN VIVO NO DISPONIBLE".'</br>';
      $str .= 'ID: '.$r->get('id')." - ";
      $str .= 'User: '.$r->get('user')."</br>";
      $str .= 'Activo?: '.$r->get('active')."</br>";
      $str .= 'SRC: '.$r->get('src')."</br>";
      $str .= 'TV?: '.$r->get('tv')."</br>";
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
      'check' => $r->get('check'),
      'ignorar_chk' => $r->get('check'),
      'medio' => '4',
      'iframe' => $r->get('src')?'<iframe style="width:100%; height:480;" src="'.$r->get('src').'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>'."</br>":"".'</br>',
      'link' => $r->get('src')?'<a href="'.$r->get('src').'">Link al canal: '.$r->get('name')."</a></br>":"EMISIÓN EN VIVO NO DISPONIBLE".'</br>',
      'src' => $r->get('src')?$r->get('src'):"undefined",
      'active' => $r->get('active'),
      'comentarios' => $r->get('coment'),
      'codigo' => $r->get('id'),
      'logo' => $r->get('logo'),
      'visitas' => $r->get('views'),
      'tv' => $r->get('tv')
    );
    return $arr;
  }
}
?>
