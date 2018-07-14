<?php 
class clsConexion
{
	private $server;
	private $user;
	private $pass;
	private $dbname;
	private $conexion;

//CONSTRUCTOR DE LA CLASE
	public function __construct()
	{
		$this->server = "localhost";
		$this->user   = "root";
		$this->pass   = "";
		$this->dbname = "futbolistas";

		$this->conexion = mysqli_connect($this->server, $this->user, $this->pass,$this->dbname);
		
		if ($this->conexion)
		{
			$this->conexion->set_charset("utf8");
		}
		else
		{
			echo "Error en la conexion a la base de datos.";
		}
	}


//DESTRUCTOR DE LA CLASE
	public function __destruct(){ }



//MANDAR UNA CONSULTA INSERT UPDATE DELETE
	public function Consulta($sql)
	{
		$this->conexion->query($sql);
	}

//MANDAR UNA CONSULTA PARA RETORNAR DATOS
	public function ConsultaResult($sql)
	{
		if (!isset($this->conexion))
			echo "llego";
		$resultado = $this->conexion->query($sql);

		return $resultado;
	}


//CERRAMOS LA CONSULTA PARA LIBERAR MEMORIA
	public function Liberar($sql)
	{
		if ($sql != NULL)
		mysqli_free_result($sql);
	}

//CERRAR CONEXION
	public function Cerrarconex()
	{
		mysqli_close();
	}

}


?>