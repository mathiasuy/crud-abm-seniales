<?php
class Enrutador
{
	public function CargarVista($vista)
	{
		switch ($vista)
		{
			case 'Editar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Eliminar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Agregar':
				include_once('view/' . $vista . '.php');
				break;
			case 'inicio':
				include_once('view/' . $vista . '.php');
				break;
			case 'Ver':
				include_once('view/' . $vista . '.php');
				break;
			case 'YTUpdate':
				include_once('view/' . $vista . '.php');
				break;
			case 'URLChecker':
				include_once('view/' . $vista . '.php');
				break;
			case 'URLChecker2':
				include_once('view/' . $vista . '.php');
				break;
			case 'YTRating':
				include_once('view/' . $vista . '.php');
				break;
			case 'SetJSON':
				include_once('view/' . $vista . '.php');
				break;
			case 'Listar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Categoria/Agregar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Categoria/Listar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Categoria/Editar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Categoria/Eliminar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Categoria/Ver':
				include_once('view/' . $vista . '.php');
				break;
			case 'Pais/Agregar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Pais/Listar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Pais/Editar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Pais/Eliminar':
				include_once('view/' . $vista . '.php');
				break;
			case 'Pais/Ver':
				include_once('view/' . $vista . '.php');
				break;
			case 'Actualizar':
				include_once('view/' . $vista . '.php');
				break;
			default:
				include_once('view/error.php');
				break;
		}
	}

	public function ValidarVista($variable)
	{
		if (empty($variable))
		{
			include_once("view/inicio.php");
		}
		else
		{
			return true;
		}
	}
}

?>
