<html lang="es">
<head>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>index</title>
	<link preload rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	<link preload href="css/animate.css" rel="stylesheet" type="text/css" />
	<link preload rel="stylesheet" href="css/normalize.css">
	<link preload rel="stylesheet" href="css/animate.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/base.css">
</head>
<body><?php
include_once("controller/Enrutador.php");
	include_once("controller/ctrDirectLink.php");
	include_once("controller/ctrIFrame.php");
	include_once("controller/ctrPais.php");
	include_once("controller/ctrUser.php");
	include_once("controller/ctrYouTube.php");
	include_once("controller/ctrCategory.php");
	include_once("controller/ctrChannel.php");
	?>
	<header id="header">
	<nav id="mnav" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
			</button>
			<div class="collapse navbar-collapse navbar-ex1-collapse">
			<div class="container">
			    <ul class="nav navbar-nav">
					<li><a href="?cargar=inicio">Señales</a></li>
					<li><a href="?cargar=Pais/Listar">Países</a></li>
					<li><a href="?cargar=Categoria/Listar">Categorias</a></li>
					<li><a href="?cargar=Listar">Ver Todo</a></li>
					<li><a href="?cargar=Actualizar">Actualizar</a></li>
				</ul>
			</div>
		</div>
	</nav>
</header>

	<br>

	<div class="container">
		<?php
			$enrutador = new Enrutador();
			if ($enrutador->ValidarVista($_GET['cargar']))
			{
				$enrutador->CargarVista($_GET['cargar']);
			}
		?>
	</div>
	<br><br>
	<footer class="footer1">
		<div class="container">
			<div class="row">
				<p>CRUD SEÑALES.</p>
			</div>
			<div class="div-footer row">
			</div>
		</div>
	</footer>
	<div id="arruw-up" class="btn btn-default btn-circle flotante" style="display: none; " onclick="$('html,body').scrollTop(0);">
	        <i class="fa fa-arrow-up rotateIn animated "></i>
	    </div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jsbase.js"></script>
	<script src="plugin/Concurrent.Thread.js"></script>
	<script type="text/javascript" src="https://cdn.viblast.com/vb/stable/viblast.js"></script>
</body>
</html>
