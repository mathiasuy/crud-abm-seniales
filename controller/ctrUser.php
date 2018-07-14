<?php
include_once("model/clsUser.php");
class ctrUser
{
	private $user;
	private static $instance = NULL;

	private function __construct()
	{
		$this->user = clsUser::getInstance();
	}

	public static function getInstance(){
		if (ctrUser::$instance == NULL){
			ctrUser::$instance = new ctrUser();
		}
		return ctrUser::$instance;
	}

	public function Index()
	{
		$resultado = $this->user->Listar();
		return $resultado;
	}

	public function Agregar($nombre,$pass)
	{
		return $this->user->Insertar($nombre,$pass);
	}

	public function Ver($id)
	{
		return $this->user->Ver($id);
	}

	public function Eliminar($id)
	{
		return $this->user->Eliminar($id);
	}

	public function Editar($id,$nombre,$pass)
	{
		return $this->user->Editar($id,$nombre,$pass);
	}
}
?>
