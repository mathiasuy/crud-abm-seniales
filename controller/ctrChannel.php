<?php
include_once("model/clsIFrame.php");
class ctrChannel
{
	private $iFrame;
	private $dl;
	private $yt;
	private static $instance = NULL;

	private function __construct()
	{
		$this->iFrame = clsIFrame::getInstance();
		$this->dl = clsDirectLink::getInstance();
		$this->yt = clsYouTube::getInstance();
	}

	public static function getInstance(){
		if (ctrChannel::$instance == NULL){
			ctrChannel::$instance = new ctrChannel();
		}
		return ctrChannel::$instance;
	}

	public function Index()
	{
    $arr = array();
    $resultado_yt = $this->yt->Listar();
    foreach($resultado_yt as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_dl = $this->dl->Listar();
    foreach($resultado_dl as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_if = $this->iFrame->Listar();
    foreach($resultado_if as $e){
    	$arr[$e->get('id')] = $e;
    }
    ksort($arr);
    return $arr;
	}

	public function ListarXPais($pais)
	{
    $arr = array();
    $resultado_yt = $this->yt->ListarXPais($pais);
    foreach($resultado_yt as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_dl = $this->dl->ListarXPais($pais);
    foreach($resultado_dl as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_if = $this->iFrame->ListarXPais($pais);
    foreach($resultado_if as $e){
    	$arr[$e->get('id')] = $e;
    }
    ksort($arr);
    return $arr;
	}

	public function ListarXCategoria($categoria)
	{
    $arr = array();
    $resultado_yt = $this->yt->ListarXCategoria($categoria);
    foreach($resultado_yt as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_dl = $this->dl->ListarXCategoria($categoria);
    foreach($resultado_dl as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_if = $this->iFrame->ListarXCategoria($categoria);
    foreach($resultado_if as $e){
    	$arr[$e->get('id')] = $e;
    }
    ksort($arr);
    return $arr;
	}

	public function ListarXActivo($activo)
	{
    $arr = array();
    $resultado_yt = $this->yt->ListarXActivo($activo);
    foreach($resultado_yt as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_dl = $this->dl->ListarXActivo($activo);
    foreach($resultado_dl as $e){
    	$arr[$e->get('id')] = $e;
    }
    $resultado_if = $this->iFrame->ListarXActivo($activo);
    foreach($resultado_if as $e){
    	$arr[$e->get('id')] = $e;
    }
    ksort($arr);
    return $arr;
	}

	public function ContarXPais($pais)
	{
		$cont = $this->yt->ContarXPais($pais);
    $cont += $this->dl->ContarXPais($pais);
    $cont += $this->iFrame->ContarXPais($pais);
    return $cont;
	}

	public function ContarXCategoria($categoria)
	{
		$cont = $this->yt->ContarXCategoria($categoria);
    $cont += $this->dl->ContarXCategoria($categoria);
    $cont += $this->iFrame->ContarXCategoria($categoria);
    return $cont;
	}

	public function ContarXActivo($activo)
	{
    $cont = $this->yt->ContarXActivo($activo);
    $cont += $this->dl->ContarXActivo($activo);
    $cont += $this->iFrame->ContarXActivo($activo);
    return $cont;
	}


	public function Eliminar($id)
	{
		$this->iFrame->Eliminar($id);
	}

	public function Ver($id)
	{
    $re_dl = $this->dl->Ver($id);
    if ($re_dl != NULL){
			//var_dump($re_dl->get('id'));
      return $re_dl;
    }
    $re_yt = $this->yt->Ver($id);
    if ($re_yt != NULL){
			//var_dump("ENTRO YT ");
      return $re_yt;
    }
    $re_if = $this->iFrame->Ver($id);
    if ($re_if != NULL){
			//var_dump("ENTRO IF ");
      return $re_if;
    }
	}
}
?>
