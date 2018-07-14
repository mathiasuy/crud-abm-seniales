<br>
<br>
<br>
<br>
<br>
<?php
  $num = 1;
	if(isset($_GET['id']))
	{
		$num = $_GET['id'];
		$controlador = ctrPais::getInstance();
		$size = sizeof($controlador->Index());
		$r = $controlador->Ver($_GET['id']);
		echo $r->toString();
	}
	else
	{
		header('Location: ?cargar=inicio');
	}
?>
<form action="?cargar=Pais/Editar&id=<?php echo $num; ?>" method="POST">
  <div class="form-group">
	    <div class="col-sm-offset-3 col-sm-10">
	      	<button type="submit" class="btn btn-primary btn-lg" name="ir_btnEditar">Editar</button>
	    </div>
    </div>
</form>
