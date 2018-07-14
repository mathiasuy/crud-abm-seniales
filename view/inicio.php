<?php
/*
	$lista = Concurrent.Thread.create((ctrChannel::getInstance())->Index());
	$paises = Concurrent.Thread.create((ctrPais::getInstance())->Index());
	$categorias = Concurrent.Thread.create((ctrCategory::getInstance())->Index());
*/

if (!isset($_GET['activo'])){
	$lista = (ctrChannel::getInstance())->ListarXActivo(1);
}else{
	$lista = (ctrChannel::getInstance())->ListarXActivo(0);
}

//$paises = (ctrPais::getInstance())->Index();
//$categorias = (ctrCategory::getInstance())->Index();


//	var_dump($resultado[0]['nombre']);
?>
<h1 class="col-sm-10 col-md-offset-3 h1agregar">Listado de Señales</h1>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right"></div>
<div class="col-sm-offset-1 col-sm-1" align="right">
	<div class="dropdown">
		<button class="btn btn-light  dropdown-toggle dropdown-header" type="button" data-toggle="dropdown">
			<span class="caret"></span>
			 Estado
		</button>
		<ul class="dropdown-menu">
			    		<li><a class="dropdown-item" href="?cargar=inicio">Activo</a></li>
			    		<li><a class="dropdown-item" href="?cargar=inicio&activo=0">Inactivo</a></li>
	  </ul>
	</div>
</div>
<div class="col-sm-offset-1 col-sm-1" align="right">
	<button type="buttom" class="btn btn-primary btn-lg " target="_blank" onclick="location.href='?cargar=Agregar'">Agregar</button>
</div>
<div>
	<table class="table table-hover">
		<thead>
			<th>ID</th>
			<th>Num</th>
			<th>Nombre</th>
			<th>Comentario</th>
			<th>Visualizacinoes</th>
			<th>País</th>
			<th>Categoría</th>
			<th>Fuente</th>
			<th COLSPAN="3">OPCIONES</th>
		</thead>
		<tbody>
			<?php foreach ($lista as $row) {
			?>
			<tr>
				<td><?php echo $row->get('id'); ?></td>
				<td><?php echo $row->get('number'); ?></td>
				<td><?php echo $row->get('name'); ?></td>
				<td><?php echo ($row instanceof DtYouTube)?$row->get('yt_nameChannel'):$row->get('coment'); ?></td>
				<td><?php echo ($row instanceof DtYouTube)?$row->get('yt_rating'):$row->get('views'); ?></td>
				<td><?php echo $row->get('country')->get('nombre'); ?></td>
				<td><?php echo $row->get('category')->get('nombre'); ?></td>
				<td><?php echo ($row instanceof DtYouTube)?"YouTube":(($row instanceof DtDirectLink)?"DirectLink":"IFrame") ?></td>
				<td>
					<a href="?cargar=Ver&id=<?php echo $row->get('id'); ?>"><span class="glyphicon glyphicon-zoom-in"></span></a>
				</td>
				<td>
					<a href="?cargar=Editar&id=<?php echo $row->get('id'); ?>"><span class="glyphicon glyphicon-edit"></span></a>
				</td>
				<td>
					<a href="?cargar=Eliminar&id=<?php echo $row->get('id'); ?>"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</div>
