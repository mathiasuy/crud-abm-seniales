<?php
include_once("model/clsCategory.php");
class ctrCategory
{
	private $Category;
	private static $instance = NULL;

	private function __construct()
	{
		$this->Category = clsCategory::getInstance();
	}

	public static function getInstance(){
		if (ctrCategory::$instance == NULL){
			ctrCategory::$instance = new ctrCategory();
		}
		return ctrCategory::$instance;
	}

	public function Index()
	{
		return $this->Category->Listar();
	}

	public function Agregar($nombre,$comentario)
	{
		return $this->Category->Insertar($nombre,$comentario);
	}

	public function Ver($id)
	{
		return $this->Category->Ver($id);
	}

	public function Eliminar($id)
	{
		return $this->Category->Eliminar($id);
	}

	public function Editar($id,$nombre,$comentario)
	{
		return $this->Category->Editar($id,$nombre,$comentario);
	}
}
?>
