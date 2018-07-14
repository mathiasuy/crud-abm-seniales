<?php
class DtPais
{
	private $id;
	private $nombre;
	private $codigo;

	public function __construct($id,$nombre,$codigo){
    $this->id = $id;
    $this->nombre = $nombre;
    $this->codigo = $codigo;
  }
	public function __destruct(){}

	public function get($atributo)
	{
		return $this->$atributo;
	}

	public function toString(){
		return "País: $this->nombre ($this->id,$this->codigo)";
	}

}
?>
