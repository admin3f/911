<div class="container login text-center">
	<h3>Descargar recurrentes<small> listado sin procesar</small></h3>
	<div class="col-md-6 col-md-offset-3 login-wrapper jumbotron">
		
		<?php echo form_open('administracion/info_extra');?>
			<?php if(validation_errors()): ?>
				<div class="alert alert-danger" role="alert">
				 <?php echo validation_errors(); ?>
				</div>
			<?php endif?>
			<div class="form-group">
				<select class="form-control" name="mes">
  					<option value="0">Dicembre '14</option>
  					<option value="1">Enero '15</option>
  					<option value="2">Febrero '15</option>
  					<option value="3">Marzo '15</option>
  					<option value="4">Abril '14</option>
  					<option value="5">Mayo '15</option>
  					<option value="6">Junio '15</option>
  					<option value="7">Julio '15</option>
  					<option value="8">Agosto '14</option>
  					<option value="9">Septiembre '15</option>
  					<option value="10">Octubre '15</option>				  					
			</select>
			</div>	
			<div class="form-group">
				<input class="form-control" type="password" name="user" placeholder="Contraseña"/>
			</div>
			<div class="form-group">

			<input type="submit" class="btn btn-primary btn-block" value="Bajar"/>			
		<?php echo form_close();?>
			<a href="<?php echo site_url('/administracion/listado'); ?>" class="btn btn-success btn-block"/>Volver</a>	
		
	</div>
</div>