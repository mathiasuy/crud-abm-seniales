<?php
$lista = (ctrCategory::getInstance())->Index();

//	var_dump($resultado[0]['nombre']);
?>
<h1 class="col-sm-10 col-md-offset-3 h1agregar">Listado de Categorías</h1>
<div class="col-sm-offset-9 col-sm-10">
	<button type="buttom" class="btn btn-primary btn-lg col-md-offset-2"  onclick="location.href='?cargar=Categoria/Agregar'">Agregar</button>
</div>
<div>
	<table class="table table-hover">
		<thead>
			<th>ID</th>
			<th>Nombre</th>
			<th>Comentario</th>
			<!--<th>Señales</th>-->
			<th COLSPAN="3">OPCIONES</th>
		</thead>
		<tbody>
			<?php foreach ($lista as $row) {
			?>
			<tr>
				<td><?php echo $row->get('id'); ?></td>
				<td><?php echo $row->get('nombre'); ?></td>
				<td><?php echo $row->get('comentario'); ?></td>
				<td>
					<a href="?cargar=Categoria/Ver&id=<?php echo $row->get('id'); ?>"><span class="glyphicon glyphicon-zoom-in"></span></a>
				</td>
				<td>
					<a href="?cargar=Categoria/Editar&id=<?php echo $row->get('id'); ?>"><span class="glyphicon glyphicon-edit"></span></a>
				</td>
				<td>
					<a href="?cargar=Categoria/Eliminar&id=<?php echo $row->get('id'); ?>"><span class="glyphicon glyphicon-trash"></span></a>
				</td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>

</div>
