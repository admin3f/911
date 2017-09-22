<div class="row reportes-hor-container">

<div style="text-align: center;">
	<span class="handle glyphicon glyphicon-chevron-up"></span>
</div>

<div class="col-sm-12">

	<table class="table table-hover table-condensed table-bordered">
		<thead>
		<th>Fecha/hora</th>
		<th>Zona</th>
		<th>Evento</th>
		<th>Dirección</th>
		<th>Comentarios</th>
		<th></th>
		</thead>
		<tbody>


		<?php
		$reportes = get_ultimos_reportes();
		// reportes.id AS id, reportes.direccion AS Dirección,
  //                               reportes.comentarios AS Descripción,
  //                               eventos.nombre AS Evento,
  //                               (CASE eventos.es_delito WHEN 1 THEN "Si" ELSE "No" END) as Delito,
  //                               zonas.nombre AS Zona,
  //                               reportes.fecha AS Fecha,
  //                               CONCAT(users.nombre, " ", users.apellido) as Usuario
		foreach($reportes as $reporte):
		?>
			<tr>
				<td><?php echo date('d-m-Y', strtotime($reporte['Fecha'])); ?>&nbsp;
				<?php echo date('H:iA', strtotime($reporte['hora'])); ?></td>
				<td><?php echo $reporte['Zona']; ?></td>
				<td><?php echo $reporte['Evento']; ?></td>
				<td><?php echo $reporte['Dirección']; ?></td>
				<td><?php echo substr($reporte['Descripción'], 0, 50); ?>..</td>
				<td><a href="<?php echo site_url('/reportes/editar/'.$reporte['id']); ?>" class="btn btn-success">Ampliar</a></td>
			</tr>
		<?php
		endforeach;
		?>
		</tbody>
	</table>

</div>

</div>
