<?php
include_once("model/clsPais.php");
class ctrPais
{
	private $pais;
	private static $instance = NULL;

	private function __construct()
	{
		$this->pais = clsPais::getInstance();
	}

	public static function getInstance(){
		if (ctrPais::$instance == NULL){
			ctrPais::$instance = new ctrPais();
		}
		return ctrPais::$instance;
	}

	public function Index()
	{
		return $this->pais->Listar();
	}

	public function Agregar($nombre,$codigo)
	{
		return $this->pais->Insertar($nombre,$codigo);
	}

	public function Ver($id)
	{
		return $this->pais->Ver($id);
	}

	public function Eliminar($id)
	{
		return $this->pais->Eliminar($id);
	}

	public function Editar($id, $nombre, $codigo)
	{
		return $this->pais->Editar($id,$nombre,$codigo);
	}
}
?>
