<?php
include_once("model/clsIFrame.php");
class ctrIFrame
{
	private $iFrame;
	private static $instance = NULL;

	private function __construct()
	{
		$this->iFrame = clsIFrame::getInstance();
	}

	public static function getInstance(){
		if (ctrIFrame::$instance == NULL){
			ctrIFrame::$instance = new ctrIFrame();
		}
		return ctrIFrame::$instance;
	}

	public function Index()
	{
		return $this->iFrame->Listar();
	}

	public function Agregar($number, $name, $coment,
	$logo, $country, $category, $active, $src, $tv)
	{
		return $this->iFrame->Insertar($number, $name, $coment,
		0, $logo, $country, $category, "Public", $active, $src, $tv);
	}

	public function Eliminar($id)
	{
		return $this->iFrame->Eliminar($id);
	}

	public function Ver($id)
	{
 		return $this->iFrame->Ver($id);
	}

	public function Editar($id, $number, $name, $coment,
	$views, $logo, $country, $category, $user, $active, $src, $tv)
	{
		return $this->iFrame->Editar($id, $number, $name, $coment,
		$views, $logo, $country->get('id'), $category->get('id'), $user, $active, $src, $tv);
	}

	public function EditarManual($id, $number, $name, $coment,
	$logo, $country, $category, $active, $src, $tv)
	{
		$e = $this->Ver($id);
		//echo "<script>alert($category,s $country)</script>";
		return $this->iFrame->Editar($id, $number, $name, $coment,
		$e->get('views'), $logo, $country, $category, $e->get('user'), $active, $src, $tv);
	}
}
?>
