<div>
	<?php
	$controlador = ctrChannel::getInstance();
	$resultado;
	if (isset($_POST['btnEliminar'])){
		$controlador->Eliminar($_GET['id']);
		//header('Location: ?cargar=inicio');
	}
	if(isset($_GET['id']))
	{
		$resultado = $controlador->Ver($_GET['id']);
	}
	else
	{
		//header('Location: ?cargar=inicio');
	}
	?>
	<?php
if (isset($resultado)){
	?>
	<h1 class="col-sm-9 col-md-offset-2 h1agregar">¿Esta Seguro de Eliminar?</h1>
	<center><label id="lbl"><?php echo "¿Eliminar señal ".$resultado->get('name')."?"; ?></label></center>
	<br><br>
	<form action="" method="POST" onsubmit="return confirmation()">
		<center><input id="btn" type="submit"  class="btn btn-primary btn-sm" name="btnEliminar" value="Eliminar"/></center>
	</form>
	<?php
}else{
	?>
	<h1 class="col-sm-9 col-md-offset-2 h1agregar">Eliminado con éxito.</h1>
	<br><br>

<?php
}
 ?>
</div>
