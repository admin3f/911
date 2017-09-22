<?php
defined('BASEPATH') OR exit('No direct script access allowed');




      $atributos = array( 'role' => 'form',
                         'class' => 'form-horizontal',
                            'id' => 'reporte',
                  'autocomplete' => "off"
                        ); 
       ?>

    <?php echo form_open( '' ,$atributos); ?>
 <input type="text" name="nombre" class="form-control"  value="<?php echo set_value('nombre'); ?>">
 <input type="text" name="apellido" class="form-control"  value="<?php echo set_value('apellido'); ?>">
 <input type="number" name="dni" class="form-control" min="0" placeholder="12333444" value="<?php echo set_value('dni'); ?>">
 <input type="number" name="prefijo" class="form-control" min="0" placeholder="03463" value="<?php echo set_value('prefijo'); ?>">
 15 - <input type="number" name="celular" class="form-control" min="0" placeholder="12345678" value="<?php echo set_value('celular'); ?>">
 <input type="submit">




    <?php echo form_close();?>

