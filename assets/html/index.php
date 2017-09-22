<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="es">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Tres de Febrero</title>
	<meta name="description" content="Tres de Febrero">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="apple-touch-icon" href="http://3def.farwebstudio.com.ar/apple-touch-icon.png">
	<!-- <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500"> -->
	<link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/juan.css">
	<style>
	html,
	body {
		height: 100%;
		margin: 0;
		padding: 0;
	}
	
	#map {
		height: 100%;
	}
	</style>
	<script src="../js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
	<?php include_once('../inc/navbar.php') ?>
	<div id="TdeFMap" class="form-active"></div>
	<div class="widged text-center">
		<h4>Reportes</h4>
		<div class="col-xs-12">
			<div class="btn-group btn-group-justified btn-group-xs" data-toggle="buttons">
				<label class="btn btn-default active">
					<input type="checkbox" value="1" name="categoriaLista" id="categoriaLista1" autocomplete="off">
					<img src="../img/icon-1.png" alt=" Pavimentacion y veredas">
					<br> Pavimentacion y veredas </label>
				<label class="btn btn-default active">
					<input type="checkbox" value="2" name="categoriaLista" id="categoriaLista2" autocomplete="off">
					<img src="../img/icon-2.png" alt=" Mobiliario vía pública">
					<br> Mobiliario vía pública </label>
				<label class="btn btn-default active">
					<input type="checkbox" value="3" name="categoriaLista" id="categoriaLista3" autocomplete="off">
					<img src="../img/icon-3.png" alt=" Espacios verdes y arboleda">
					<br> Espacios verdes y arboleda </label>
				<label class="btn btn-default active">
					<input type="checkbox" value="4" name="categoriaLista" id="categoriaLista4" autocomplete="off">
					<img src="../img/icon-4.png" alt=" Servicio público">
					<br> Servicio público </label>
			</div>
		</div>
		<!-- <a href="http://3def.farwebstudio.com.ar/reportes/cargar" class="btn btn-primary ">Cargar reporte</a> -->
		<a href="http://3def.farwebstudio.com.ar/assets/html/reportes/cargar.html" class="btn btn-primary btn-cargar">Cargar reporte</a>
	</div>
	<div class="widged-right">
		<div class="widged-title"><span>Filtrar por:</span></div>
		<ul class="periodo">
			<li>Días</li>
			<li><a href="">Hoy</a></li>
			<li class="active"><a href="">Semana</a></li>
			<li><a href="">Último mes</a></li>
		</ul>
		<ul class="status">
			<li>Status</li>
			<li><a href="">Reportado</a></li>
			<li class="active"><a href="">En proceso</a></li>
			<li><a href="">Finalizado</a></li>
		</ul>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script>
	window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
	</script>
	<script src="../js/vendor/bootstrap.min.js"></script>
	<script src="../js/plugins.js"></script>
	<script>
	baseUrl = "http://3def.farwebstudio.com.ar/";
	centerMap = {
		lat: -34.5926653,
		lng: -58.5808747,
	}
	</script>
	<script src="../js/main.js"></script>
	<script src="../js/juan.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_I_sKgsQL4YqoHKVcobAP_gYmM5a60xQ&signed_in=true&libraries=places&callback=initMap" async defer></script>
</body>

</html>
