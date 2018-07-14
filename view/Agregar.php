<?php
	$ctrCategorias = ctrCategory::getInstance();
	$ctrChannels = ctrChannel::getInstance();
	$ctrPaises = ctrPais::getInstance();
	$categorias = $ctrCategorias->Index();
	$paises = $ctrPaises->Index();
	$seniales = $ctrChannels->Index();
	$numSugerido = 1;
	foreach ($seniales as $s){
		if ($numSugerido <= $s->get('number')){
			$numSugerido =  $s->get('number') + 1;
		}
	}
	$resultado;

	if(isset($_POST['btnAgregar']))
	{
		$number = $_POST['number'];
		$name = $_POST['name'];
		$coment = $_POST['coment'];
		$logo = $_POST['logo'];
		$country = $_POST['country'];
		$category = $_POST['category'];
		$active = isset($_POST['active'])?1:0;
		$src = $_POST['src'];
		$p = $_POST['dropdl'];

		if ($p == "yt"){
			//var_dump("alert('iframe')");
			$channel = $_POST['channel'];
			$video = isset($_POST['video'])?1:0;
			$ctrYouTube = ctrYouTube::getInstance();
			$resultado = $ctrYouTube->Agregar($number, $name, $coment,	$logo, $country, $category, $active, $src,
																	$channel, $video);
		}
		if ($p == "dl"){
			$tv = isset($_POST['tv'])?1:0;
			$placeHolder = $_POST['placeHolder'];
			$ctrDirectLink = ctrDirectLink::getInstance();

			$resultado = $ctrDirectLink->Agregar($number, $name, $coment,	$logo, $country, $category,
																	$active, $src, $tv, $placeHolder);
		}
		if ($p == "iframe"){

			$tv = isset($_POST['tv'])?1:0;
			$ctrIFrame = ctrIFrame::getInstance();
			$resultado = $ctrIFrame->Agregar($number, $name, $coment,$logo, $country, $category, $active,$src,
																		$tv);
		}

		if ($resultado > 0)
		{
			//header('Location: ?cargar=inicio');
			echo "<script>alert('Señal Agregada');</script>";
		}
		else
		{
			echo "<script>alert('ERROR: $resultado');</script>";
		}
	}
?>
<h1 class="col-sm-10 col-md-offset-3 h1agregar">Agregar Señal</h1>

<form id ="form" class="form-horizontal col-sm-10 col-md-offset-2" action="" method="POST">

	<div class="form-group">
		<label class="col-sm-2 control-label">Origen del streaming</label>
		<div class="col-sm-4">
			<select name="dropdl" id="dropdl" class="form-control" name="tipo"  onchange="actualizar()" value="">
						<option value="yt">Canal de YouTube</option>
						<option value="dl">Enlace directo</option>
						<option value="iframe">iframe</option>
			</select>
		</div>
	</div>

<!-- YOUTUBE -->
<div id="div_yt1" class="form-group">
	<label class="col-sm-2 control-label">Canal</label>
	<div class="col-sm-4">
		<input id="_channel" class="form-control" type="text" name="channel"  oninput="document.getElementById('_src').required = false;" />
	</div>
</div>
<div id="div_yt2" class="form-group">
	<label class="col-sm-2 control-label">Sólo Video</label>
	<div class="col-sm-4">
		<input class="form-control" type="checkbox" name="video" value="video"/>
	</div>
</div>

<!-- DIRECTLINK -->
<div id="div_dl1" class="form-group">
	<label class="col-sm-2 control-label">Place Holder</label>
	<div class="col-sm-4">
		<input class="form-control" type="text" name="placeHolder" />
	</div>
</div>
<div id="div_dl2" class="form-group">
	<label class="col-sm-2 control-label">TV</label>
	<div class="col-sm-4">
		<input class="form-control" type="checkbox" name="tv" value="tv"/>
	</div>
</div>

<!-- IFRAME -->
<div id="div_if" class="form-group">
	<label class="col-sm-2 control-label">TV</label>
	<div class="col-sm-4">
		<input class="form-control" type="checkbox" name="tv" value="tv"/>
	</div>
</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Número (*)</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="number" value="<?php echo $numSugerido ?>" required/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Nombre (*)</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="name" required/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Comentario</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="coment" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">SRC</label>
		<div class="col-sm-4">
			<input id="_src" class="form-control" type="text" name="src" oninput="document.getElementById('_channel').required = false;"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Logo</label>
		<div class="col-sm-4">
			<input class="form-control" type="text" name="logo" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">Activo</label>
		<div class="col-sm-4">
			<input class="form-control" type="checkbox" name="active" value="active" <?php //echo $resultado->get('active')?'checked':''; ?>/>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Categoría</label>
		<div class="col-sm-4">
			<select class="form-control" name="category" value="">
				<?php
					foreach ($categorias as $row) {
						if ($row != NULL){
				?>
						<option value="<?php echo $row->get('id'); ?>"><?php echo $row->get('nombre');?></option>
				<?php
						}
					}
				?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Pais</label>
		<div class="col-sm-4">
			<select class="form-control" name="country" value="">
				<?php
					foreach ($paises as $row) {
						if ($row != NULL){
				?>
						<option value="<?php echo $row->get('id'); ?>"><?php echo $row->get('nombre');?></option>
				<?php
						}
					}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
	    <div class="col-sm-offset-3 col-sm-10">
	      	<button type="submit" class="btn btn-primary btn-lg" name="btnAgregar">Agregar</button>
	    </div>
    </div>
</form>
<script>
	actualizar();
	function actualizar(){
		var ifr = document.getElementById("div_if");
		var dl1 = document.getElementById("div_dl1");
		var dl2 = document.getElementById("div_dl2");
		var yt1 = document.getElementById("div_yt1");
		var yt2 = document.getElementById("div_yt2");
		var ddl = document.getElementById("dropdl");
		var opc = ddl.options[ddl.selectedIndex].value;
		switch (opc) {
			case "yt":
					ifr.style.display = 'none';
					dl1.style.display = 'none';
					dl2.style.display = 'none';
					yt1.style.display = 'block';
					yt2.style.display = 'block';
					document.getElementById("_channel").required = true;
				break;
			case "iframe":
					document.getElementById("_src").required = true;
					ifr.style.display = 'block';
					dl1.style.display = 'none';
					dl2.style.display = 'none';
					document.getElementById("_channel").required = false;
					yt1.style.display = 'none';
					yt2.style.display = 'none';
				break;
			case "dl":
					ifr.style.display = 'none';
					dl1.style.display = 'block';
					dl2.style.display = 'block';
					document.getElementById("_channel").required = false;
					yt1.style.display = 'none';
					yt2.style.display = 'none';
					document.getElementById("_src").required = true;
				break;
			default:

		}
	}
</script>
