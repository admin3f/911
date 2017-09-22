<div class="row">
<div class="col-sm-6" id="user-info">Bienvenido <?php echo $user_nombre; ?>, <a href="<?php echo site_url('administracion/logout'); ?>">salir</a></div>
<div class="col-sm-6">
  <div class="btn-group pull-right">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="glyphicon glyphicon-cog"></i> <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a href="<?php echo site_url('/reportes/listado'); ?>">Ver Reportes</a></li>
        <?php
        if($new):
        ?>
        <li><a href="#" id="resetForm">Limpiar formulario</a></li>
        <?php
        endif;
        ?>
      </ul>
    </div>
</div>
</div>
