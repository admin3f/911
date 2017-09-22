<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Tres de Febrero</title>
		<meta name="description" content="Tres de Febrero">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="apple-touch-icon" href="http://3def.farwebstudio.com.ar/apple-touch-icon.png">

		<link rel="stylesheet" href="../../css/bootstrap.min.css">

		<link rel="stylesheet" href="../../css/main.css">
		<link rel="stylesheet" href="../../css/juan.css">

		<script src="../../js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
	</head>
	<body id="cargar-reporte">
	  <div class="col-md-9 col-sm-8 col-md-push-3 col-sm-push-4">
		  <div class="row">
		  	  <header id="header" class="">
	  		  	<img class="logo-3def" src="http://3def.farwebstudio.com.ar/assets/img/tres-de-febrero-avanza.png"  alt="Tres de Febrero | Municipalidad">
		  	  </header><!-- /header -->
		  
			<div id="TdeFMap"></div>
		  </div>
		
	  </div>
	  <div class="col-md-3 col-sm-4 col-md-pull-9 col-sm-pull-8" style="min-height: 100%">
		<div class="side-column">
		  <form action="http://3def.farwebstudio.com.ar/reportes/cargar" role="form" class="form-horizontal" id="cargarReporte" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8">
		  <h3>Complete los datos</h3>
			<input type="hidden" id="lat" name="latReportes" value="">
		    <input type="hidden" id="lng" name="lngReportes" value="">
			<div class="form-group">
			  <div class="col-sm-12">
				  <label for="direccionReporte" class="sr-only">Dirección</label>
				  <div class="input-group">
					  <input type="text" class="form-control" id="direccionReporte" value="" name="direccionReporte" placeholder="Dirección del reporte">
					  <span class="input-group-btn">
						<button class="btn btn-default btn-blue" id="verDirecion" name="verDirecion" type="button">Ver</button>
					  </span>
					</div><!-- /input-group -->
				 <p class="help-block small mb0">Mueva el icono o haga clic si el direccion  que se muestra en el mapa es incorrecto.</p>
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<label for="tituloReporte" class="sr-only">Titulo del Reporte</label>
				<input type="text" class="form-control" name="tituloReporte" id="tituloReporte" value="" placeholder="Titulo del reporte">
			  </div>
			</div>        
			<div class="form-group">
			  <div class="col-sm-12">
				<label for="textoReporte" class="sr-only">Descripción del Reporte</label>
				<textarea id="textoReporte" name="textoReporte"  class="form-control" rows="2" placeholder="Escriba aquí una descripción"></textarea>
			  </div>
			</div>
			<div class="form-group" id="drag-foto">
				  <div class="col-sm-6" >
					  <div class="input-file-container">  
					    <label tabindex="0" for="my-file" class="input-file-trigger">Cargar Imagen</label> 
					    <input class="input-file" name="imagenReporte" id="my-file" type="file">
					  </div>
				  </div>
				  <div class="col-sm-6" >
				  	   <input type="text" class="file-return-input" disabled="disabled" name="" value="" placeholder="">
				  </div>
			 </div> 
			<div class="form-group">
				<div class="col-sm-12">
				  <select name="sources" id="sources" class="custom-select sources" placeholder="-- Seleccionar Categoría --">
				    <option value="pavimentacion-y-veredas">Pavimentacion y veredas</option>
				    <option value="mobiliario-via-publica">Mobiliario vía pública</option>
				    <option value="espacios-verdes-y-arboleda">Espacios verdes y arboleda</option>
				    <option value="servicio-publico">Servicio público</option>
				  </select>
				</div>

			</div>
			<div class="form-group">
				<div class="col-sm-6">
				   <label for="nombreReporte" class="sr-only">Nombre</label>
				  <input type="text" class="form-control" id="nombreReporte"  name="nombreReporte" value="" placeholder="Nombre">         
				</div>
				<div class="col-sm-6">
				   <label for="apellidoReporte" class="sr-only">Apellido</label>
				  <input type="text" class="form-control" id="apellidoReporte" name="apellidoReporte" value="" placeholder="Apellido">         
				</div>
			</div>
			<div class="form-group">
			  <div class="col-sm-6">
				 <label for="dniReporte" class="sr-only">DNI</label>
				<input type="number" class="form-control" id="dniReporte" name="dniReporte" value="" placeholder="DNI">         
			  </div>
			  <div class="col-sm-6">
	   
			  
			 
					  <div class="btn-group btn-group-sexo" data-toggle="buttons">
					  	<p class="label-sexo">Sexo:</p>
						<label class="btn btn-default">
						  <input type="radio" value="1" name="generoReporte" id="generoReporteF"  autocomplete="off"> F
						</label>
						<label class="btn btn-default">
						  <input type="radio" value="2" name="generoReporte" id="generoReporteM"  autocomplete="off"> M
						</label>
					  </div>
			  
				  
		   
			   </div> 
			 </div>   
			 <div class="form-group">
				<label class="sr-only" for="celularReporte">Celular</label>
				<div class="col-sm-4">
				  <div class="input-group">
					<div class="input-group-addon">0</div>
					<input type="text" class="form-control" id="celularAreaReporte" name="celularAreaReporte" value="" placeholder="11">
				  </div>
				 </div>
				  <div class="col-sm-8">
				   <div class="input-group">
					<div class="input-group-addon">15</div>
					<input type="text" class="form-control" id="celularReporte" name="celularReporte" value="" placeholder="12341234">
				  </div>
				  </div>
			  </div>
			  <div class="form-group">
				<div class="col-sm-12">
					<div class="input-group">
						<div class="input-group-addon input-group-addon-arroba">@</div>
						<label for="emailReporte" class="sr-only">E-mail</label>
						<input type="email" class="form-control" id="emailReporte"  name="emailReporte" value="" placeholder="Correo eléctronico"> 
					</div>

				 <!--  <label for="emailReporte" class="sr-only">E-mail</label>
				  <input type="email" class="form-control" id="emailReporte"  name="emailReporte" value="" placeholder="Correo eléctronico">   -->



				</div>
			  </div>



			
			</div>
		    <button type="submit" id="enviarReporte"  value="upload" class="btn btn-block btn-info">Enviar</button>

		   
		  </form>
		  <?php include_once('../../inc/form-error-pop-up.php'); ?>
		</div>  
	  </div>


		
  



		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

		<script src="../../js/vendor/bootstrap.min.js"></script>

		<script src="../../js/plugins.js"></script>
			
		<script>
			baseUrl = "http://3def.farwebstudio.com.ar/";
			centerMap = {
				lat: -34.5926653,
				lng: -58.5808747,
			}


		</script>	

		<script src="../../js/main.js"></script>
		<script src="../../js/juan.js"></script>
		
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_I_sKgsQL4YqoHKVcobAP_gYmM5a60xQ&signed_in=true&libraries=places&callback=initMap"
		async defer></script>
	</body>
</html>