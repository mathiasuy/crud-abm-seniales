</br>
</br>
</br>
</br>
</br>
<?php
	$num = 10;
	$size = 1;
	if(isset($_GET['id']))
	{
		$num = $_GET['id'];
		$controlador = ctrChannel::getInstance();
		$size = sizeof($controlador->Index());
		$r = $controlador->Ver($_GET['id']);
		echo $r->getData()['iframe'];
		echo $r->getData()['link'];
		echo $r->toString();
	}
	else
	{
		header('Location: ?cargar=inicio');
	}
?>
<form action="Ver.php" method="POST">

</form>

<div class="form-group">
	<div class="row">
		<div class="col-sm-offset-3 col-sm-3">
				<button type="buttom" onclick="location.href='?cargar=Ver&id='+ <?php echo ($num==1?$size:($num-1))  ?> " class="btn btn-primary btn-lg" name="Anterior">Anterior</button>
		</div>
		<div class="col-sm-offset-3 col-sm-3">
				<button type="buttom" onclick="location.href='?cargar=Ver&id='+ <?php echo ($num==$size?1:($num+1))  ?> " class="btn btn-primary btn-lg" name="Siguiente">Siguiente</button>
		</div>
	</div>

	</div>
