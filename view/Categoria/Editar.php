<?php
	$ctrCategorias = ctrCategory::getInstance();
	$categorias = $ctrCategorias->Index();
  $c;
	$resultado = 0;
  $nombre = "N/D";
  $comentario = "N/D";
	if(isset($_GET['id'])){
    $c = $ctrCategorias->Ver($_GET['id']);
    $nombre = $c->get('nombre');
    $comentario = $c->get('comentario');
  }

	if(isset($_POST['btnEditar']))
	{
		$name = $_POST['name'];
		$coment = $_POST['coment'];
		$id = $_GET['id'];
		$resultado = $ctrCategorias->Editar($id,$name,$coment);

    if ($resultado > 0)
		{
			//header('Location: ?cargar=inicio');
			echo "<script>alert('Categoría editada');</script>";
	}
	else
	{
			echo "<script>alert('ERROR: $resultado');</script>";
		}

	}
?>
<h1 class="col-sm-10 col-md-offset-3 h1agregar">Editar Categoria</h1>

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
	<label class="col-sm-2 control-label">Comentario</label>
	<div class="col-sm-4">
		<input class="form-control" type="text" name="coment" value="<?php echo $comentario ?>" />
	</div>
</div>

	<div class="form-group">
	    <div class="col-sm-offset-3 col-sm-10">
	      	<button type="submit" class="btn btn-primary btn-lg" name="btnEditar">Editar</button>
	    </div>
    </div>
</form>
