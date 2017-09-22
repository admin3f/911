<?php
$map_url = "//maps.googleapis.com/maps/api/staticmap?center=" . $reporte->direccion . "+3+de+Febrero,+Buenos+Aires,Argentina&zoom=15&size=640x300&maptype=roadmap";

if(!empty($reporte->lat) && !empty($reporte->lng))
{
	$map_url .= "&markers=icon:" . site_url('/assets/img/icon-star.png') . "|" . $reporte->lat . "," . $reporte->lng;
}
?>
<div style="padding: 25px">
	<label>Zona:</label> <span><?php echo $reporte->zona; ?></span> | <label>Evento:</label> <span><?php echo $reporte->evento; ?></span><br>
	<label>Dirección:</label> <span><?php echo $reporte->direccion; ?></span><br>
	<label>Intersección:</label> <span><?php echo $reporte->interseccion; ?></span><br>
	<label>Fecha:</label> <span><?php echo $reporte->fecha; ?></span> | <label>Hora:</label> <span><?php echo $reporte->hora; ?></span> | <label>Cargado por:</label> <span><?php echo $reporte->usuario; ?></span><br>
	<label>Comentarios:</label> <span><?php echo str_replace("\n", "<br>", $reporte->comentarios); ?></span><br><br>
	<div style="text-align: center">
		<img src="<?php echo $map_url; ?>" alt="">
		<br>
		<br>
		<a class="btn btn-danger close_popup" href="#">Cerrar</a>
		<a class="btn btn-success" href="<?php echo site_url('/reportes/editar/'.$reporte->id); ?>">Ampliar</a>
	</div>
</div>
