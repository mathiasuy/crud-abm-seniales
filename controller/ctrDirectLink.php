<?php
include_once("model/clsDirectLink.php");
include_once("URLChecker.php");
class ctrDirectLink
{
	private $directLink;
	private static $instance = NULL;

	private function __construct()
	{
		$this->directLink = clsDirectLink::getInstance();
	}

	public static function getInstance(){
		if (ctrDirectLink::$instance == NULL){
			ctrDirectLink::$instance = new ctrDirectLink();
		}
		return ctrDirectLink::$instance;
	}

	public function Index()
	{
		return $this->directLink->Listar();
	}

	function disponible($src) {
		$ctr = Check::getInstance();
		return $ctr->check_alive($src);
	}


		public function ListarXActivo($activo)
		{
	    $resultado_dl = $this->directLink->ListarXActivo($activo);
	    foreach($resultado_dl as $e){
	    	$arr[$e->get('id')] = $e;
	    }
	    ksort($arr);
	    return $arr;
		}


	public function updateData($lista){
		$in = 0;
		foreach ($lista as $l){
			if ($l->get('check') == 1){
				$active = $this->disponible($l->get('src'));
				$in += ($l->get('active')==$active?0:1);
				if (!$active){
					$this->Editar($l->get('id'),$l->get('number'),	$l->get('name'),$l->get('coment'),
					$l->get('views'), $l->get('logo'), $l->get('country'), $l->get('category'), $l->get('user'),
					$active, $l->get('src'), $l->get('tv'), $l->get('placeHolder'));
				}
			}
		}
		return $in;
	}

	public function Agregar($number, $name, $coment,	$logo, $country, $category,
	$active, $src, $tv, $placeHolder)
	{
		return $this->directLink->Insertar($number, $name, $coment,	0, $logo, $country, $category, "Public",
		$active, $src, $tv, $placeHolder);
	}

	public function Ver($id)
	{
		return $this->directLink->Ver($id);
	}

	public function Eliminar($id)
	{
		return $this->directLink->Eliminar($id);
	}

	public function Editar($id,$number, $name, $coment,	$views, $logo, $country, $category, $user,
	$active, $src, $tv, $placeHolder)
	{
		return $this->directLink->Editar($id,$number, $name, $coment,	$views, $logo, $country->get('id'), $category->get('id'), $user,
		$active, $src, $tv, $placeHolder);
	}

	public function EditarManual($id,$number, $name, $coment,	$logo, $country, $category,
	$active, $src, $tv, $placeHolder)
	{
		$e = $this->Ver($id);
		return $this->directLink->Editar($id,$number, $name, $coment,	$e->get('views'), $logo, $country, $category, $e->get('user'),
		$active, $src, $tv, $placeHolder);
	}
}
?>
