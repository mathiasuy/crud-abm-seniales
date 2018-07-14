<br>
<br>
<br>
<br>
<br>
<?php
	if(isset($_GET['id']))
	{
		$num = $_GET['id'];
		$controlador = ctrCategory::getInstance();
		$size = sizeof($controlador->Index());
		$r = $controlador->Ver($_GET['id']);
		echo $r->toString();

	}
	else
	{
		header('Location: ?cargar=inicio');
	}
?>
<form action="?cargar=Categoria/Editar&id=<?php echo $num; ?>" method="POST">
  <div class="form-group">
	    <div class="col-sm-offset-3 col-sm-10">
	      	<button type="submit" class="btn btn-primary btn-lg" name="ir_btnEditar">Editar</button>
	    </div>
    </div>
</form>
