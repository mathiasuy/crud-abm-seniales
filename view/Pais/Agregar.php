<?php
	$ctrPais = ctrPais::getInstance();
	$paises = $ctrPais->Index();
	$resultado = 0;

	if(isset($_POST['btnAgregar']))
	{
		$name = $_POST['name'];
		$coment = $_POST['cod'];
		$resultado = $ctrPais->Agregar($name,$coment);

    if ($resultado > 0)
		{
			//header('Location: ?cargar=inicio');
				echo "<script>alert('País agregado');</script>";
		}
		else
		{
				echo "<script>alert('ERROR: $resultado');</script>";
		}

	}
?>
<h1 class="col-sm-10 col-md-offset-3 h1agregar">Agregar País</h1>

<form id ="form" class="form-horizontal col-sm-10 col-md-offset-2" action="" method="POST">

<!-- YOUTUBE -->
<div class="form-group">
	<label class="col-sm-2 control-label">Nombre</label>
	<div class="col-sm-4">
		<input class="form-control" type="text" name="name" required/>
	</div>
</div>

<!-- YOUTUBE -->
<div class="form-group">
	<label class="col-sm-2 control-label">Código</label>
	<div class="col-sm-4">
		<input class="form-control" type="text" name="cod" required/>
	</div>
</div>

	<div class="form-group">
	    <div class="col-sm-offset-3 col-sm-10">
	      	<button type="submit" class="btn btn-primary btn-lg" name="btnAgregar">Agregar</button>
	    </div>
    </div>
</form>
