<?php
class DtCategoria
{
	private $id;
	private $nombre;
	private $comentario;

	public function __construct($id,$nombre,$comentario){
    $this->id = $id;
    $this->nombre = $nombre;
    $this->comentario = $comentario;
  }
	public function __destruct(){}

	public function get($atributo)
	{
		return $this->$atributo;
	}

	public function toString(){
		return "Categoría: $this->nombre ($this->id,$this->comentario)";
	}

}
?>
