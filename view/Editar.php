<?php
include_once("dt/DtYouTube.php");
include_once("dt/DtDirectLink.php");
	$ctrl_yt = ctrYouTube::getInstance();
	$ctrl_directLink = ctrDirectLink::getInstance();
	$ctrl_category = ctrCategory::getInstance();
	$ctrl_pais = ctrPais::getInstance();
	$ctrl_iframe = ctrIFrame::getInstance();
	$ctrl_channels = ctrChannel::getInstance();
	$canales_yt = $ctrl_yt->Index();
	$canales_dl = $ctrl_directLink->Index();
	$paises = $ctrl_pais->Index();
	$categorias = $ctrl_category->Index();

	$resultado;

	if(isset($_GET['id']))
	{
		//var_dump("asd".$_GET['id']."asd");
		$resultado = $ctrl_channels->Ver($_GET['id']);
		//var_dump($resultado);
		//var_dump($resultado->get('name'));
	}
	else
	{
		header('Location: ?cargar=inicio');
	}


	if(isset($_POST['btnEditar']))
	{
//		echo "<script>alert('".$_POST['number']."');</script>";
		$id = $_GET['id'];
		$number = $_POST['number'];
		$name = $_POST['name'];
		$coment = $_POST['coment'];
		$logo = $_POST['logo'];
		$country = $_POST['country'];
		$category = $_POST['category'];
		$active = isset($_POST['active'])?1:0;
		$src = $_POST['src'];
		$exito = "No se pudo editar";
		if ($resultado instanceof DtYouTube){
			$channel = $_POST['channel'];
			$video = isset($_POST['video'])?1:0;
			$exito = $ctrl_yt->EditarManual($id,$number, $name, $coment,
			$logo, $src, $channel, $active, $category, $country, $video);
			if ($exito > 0)
				$exito = 'Editado con éxito!';
		}

		if ($resultado instanceof DtDirectLink){
			$tv = isset($_POST['tv'])?1:0;
			$placeHolder = $_POST['placeHolder'];
			$exito = $ctrl_directLink->EditarManual($id,$number, $name, $coment,	$logo, $country, $category,
			$active, $src, $tv, $placeHolder);
			if ($exito > 0)
				$exito = 'Editado con éxito!';
		}

		if ($resultado instanceof DtIFrame){
			$tv = isset($_POST['tv'])?1:0;
			$exito = $ctrl_iframe->EditarManual($id, $number, $name, $coment,
			$logo, $country, $category, $active, $src, $tv);
			if ($exito > 0)
				$exito = 'Editado con éxito!';
		}

		echo "<script>alert('$exito');</script>";

		//header('Location: ?cargar=inicio');
	}

//var_dump(">>>>>".$resultado[0]['number']."<<<<");
?>

<h1 class="col-sm-10 col-md-offset-4 h1agregar">Editar Señal</h1>
<form class="form-horizontal col-sm-12 col-md-offset-2" name="" action="" method="POST">
	<?php
		if ($resultado instanceof DtYouTube){
			echo '<div class="form-group">
				<div class="col-sm-3 col-md-offset-2">
				<div style="background: url('.$resultado->get('yt_logo').') center center; background-size: cover;   opacity: 0.4; height: 100px; width: auto;"></div>
				</div>
			</div>';
		}else if ($resultado->get('logo') != ""){
			echo '<div class="form-group">
				<div class="col-sm-3 col-md-offset-2">
				<div style="background: url('.$resultado->get('logo').') center center; background-size: cover;   opacity: 0.4; height: 100px; width: auto;"></div>
				</div>
			</div>';
		}

	?>
	<?php

	if ($resultado instanceof DtYouTube){

	?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Nombre de canal (YouTube)</label>
				<div class="col-sm-4">
					<p class="form-control-static"><?php echo $resultado->get('yt_nameChannel'); ?></p>
				</div>
			</div>
	<?php

	}
	?>
	<div class="form-group">
		<label class="col-sm-2 control-label">Número</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="number" value="<?php echo $resultado->get('number'); ?>" required/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Nombre</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="name" value="<?php echo $resultado->get('name'); ?>" required/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Comentario</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="coment" value="<?php echo $resultado->get('coment'); ?>" />
		</div>
	</div>


	<div class="form-group">
		<label class="col-sm-2 control-label">Logo</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="logo" value="<?php echo $resultado->get('logo'); ?>" />
		</div>
	</div>


	<div class="form-group">
		<label class="col-sm-2 control-label">SRC</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="src" value="<?php echo $resultado->get('src'); ?>" required/>
		</div>
	</div>
<?php

if ($resultado instanceof DtYouTube){

?>
		<div class="form-group">
			<label class="col-sm-2 control-label">Codigo de canal</label>
			<div class="col-sm-4">
				<input class="form-control" type="text" name="channel" value="<?php echo $resultado->get('channel'); ?>"/>
			</div>
		</div>
<?php

}
?>

<?php

if ($resultado instanceof DtDirectLink){

?>
		<div class="form-group">
			<label class="col-sm-2 control-label">Place Holder</label>
			<div class="col-sm-4">
				<input class="form-control" type="text" name="placeHolder" value="<?php echo $resultado->get('placeHolder'); ?>"/>
			</div>
		</div>
<?php

}
?>

			<div class="form-group">
				<label class="col-sm-2 control-label">Activo</label>
				<div class="col-sm-4">
					<input class="form-control" type="checkbox" name="active" value="active" <?php echo $resultado->get('active')?'checked':''; ?>/>
				</div>
			</div>

	<?php

	if ($resultado instanceof DtDirectLink || $resultado instanceof DtIFrame){

	?>
			<div class="form-group">
				<label class="col-sm-2 control-label">TV</label>
				<div class="col-sm-4">
					<input class="form-control" type="checkbox" name="tv" value="tv" <?php echo $resultado->get('tv')?'checked':''; ?>/>
				</div>
			</div>
	<?php

	}
	?>

	<?php

	if ($resultado instanceof DtYouTube){

	?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Es video</label>
				<div class="col-sm-4">
					<input class="form-control" type="checkbox" name="video" value="video" <?php echo $resultado->get('video')?'checked':''; ?>/>
				</div>
			</div>
	<?php

	}
	?>

	<div class="form-group">
		<label class="col-sm-2 control-label">Categoría</label>
		<div class="col-sm-4">
			<select id="ctgr" class="form-control" name="category" value="">
				<option value="" >Seleccione la Categoria para Editar</option>
				<?php
					foreach($categorias as $row)
					{
						if ($row != NULL){
				?>
						<option value="<?php echo $row->get('id'); ?>"><?php echo $row->get('nombre');?></option>
				<?php
						}
					}
				?>
			</select>
			<script>
				document.getElementById("ctgr").value  = <?php echo $resultado->get('category')->get('id'); ?>;
			</script>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Pais</label>
		<div class="col-sm-4">
			<select id="slct" class="form-control" name="country" value="">
				<option value="">Seleccione el Pais para Editar</option>
				<?php
					foreach($paises as $row)
					{
						if ($row != NULL){
				?>
						<option value="<?php echo $row->get('id'); ?>"><?php echo $row->get('nombre');?></option>
				<?php
						}
					}
				?>
			</select>
			<script>
				document.getElementById("slct").value  = <?php echo $resultado->get('country')->get('id'); ?>;
			</script>
		</div>
	</div>
	<?php

	if ($resultado instanceof DtYouTube){

	?>
			<div class="form-group">
				<label class="col-sm-2 control-label">Descripción: </label>
				<div class="col-sm-4">
					<p class="form-control-static"><?php echo $resultado->get('yt_description'); ?></p>
				</div>
			</div>

	<?php

	}
	?>



	<br>
	<div class="form-group">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
					<button type="submit" class="btn btn-primary btn-lg col-md-offset-2" name="btnEditar">Editar</button>
			</div>
		</div>
    </div>
</form>
<div class="col-sm-offset-2 col-sm-10">
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
		<button class="btn btn-primary btn-lg col-md-offset-2" type="buttom" onclick="location.href='?cargar=Ver&id='+ <?php echo $resultado->get('id')  ?> "  name="ver">Ir</button>
</div>
