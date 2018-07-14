<?php
	$ctrPais = ctrPais::getInstance();
	$categorias = $ctrPais->Index();
  $c;
	$resultado = 0;
  $nombre = "N/D";
  $codigo = "N/D";
	if(isset($_GET['id'])){
    $c = $ctrPais->Ver($_GET['id']);
    $nombre = $c->get('nombre');
    $codigo = $c->get('codigo');
  }

	if(isset($_POST['btnEditar']))
	{
		$name = $_POST['name'];
		$codigo = $_POST['codigo'];
		$id = $_GET['id'];
		$resultado = $ctrPais->Editar($id,$name,$codigo);

    if ($resultado > 0)
		{
			//header('Location: ?cargar=inicio');
			echo "<script>alert('País Editado');</script>";
	}
	else
	{
			echo "<script>alert('ERROR: $resultado');</script>";
		}

	}
?>
<h1 class="col-sm-10 col-md-offset-3 h1agregar">Editar País</h1>

<form id ="form" class="form-horizontal col-sm-10 col-md-offset-2" action="" method="POST">

<!-- YOUTUBE -->
<div class="form-group">
	<label class="col-sm-2 control-label">Nombre</label>
	<div class="col-sm-4">
		<input class="form-control" type="text" name="name" value="<?php echo $nombre ?>" required/>
	</div>
</div>

<!-- YOUTUBE -->
<div class="form-group">
	<label class="col-sm-2 control-label">Código</label>
	<div class="col-sm-4">
		<input class="form-control" type="text" name="codigo" value="<?php echo $codigo ?>" required/>
	</div>
</div>

	<div class="form-group">
	    <div class="col-sm-offset-3 col-sm-10">
	      	<button type="submit" class="btn btn-primary btn-lg" name="btnEditar">Editar</button>
	    </div>
    </div>
</form>
