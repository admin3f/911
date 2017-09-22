<div class="container login">
	<div class="col-md-6 col-md-offset-3 login-wrapper">
		<?php echo form_open('administracion/login');?>
			<?php if(validation_errors()): ?>
				<div class="alert alert-danger" role="alert">
				 <?php echo validation_errors(); ?>
				</div>
			<?php endif?>	
			<div class="form-group">
				<input class="form-control" type="text" name="name" placeholder="Usuario"/>
			</div>
			<div class="form-group">
				<input class="form-control" type="password" name="user" placeholder="Contraseña"/>
			</div>
			<div class="form-group">
				<div class="col-md-10 col-md-offset-1">
					
					<input type="submit" class="btn btn-primary btn-block" value="Ingresar"/>					
				</div>

					
		<?php echo form_close();?>
		
	</div>
</div>