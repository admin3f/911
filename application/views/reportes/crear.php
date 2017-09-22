<?php
$CI =& get_instance();
defined('BASEPATH') OR exit('No direct script access allowed');
$atributos = array(
    'role' => 'form',
    'class' => 'form-horizontal',
    'id' => 'cargarReporte',
    'autocomplete' => "on"
);

$data["new"] = true;
?>
    <div id="toggle_map_element">
        <button data-type="camara"><img src="<?php echo base_url()?>assets/img/icon-camera.png" alt=""></button>
        <button data-type="zona"><img src="<?php echo base_url()?>assets/img/icon-zone.png" alt=""></button>
    </div>

    <div id="MapContainer">
        <div id="TdeFMap"  <?php echo (isset($error)||validation_errors()||$gracias||$cargar)?'class="form-active"':'' ?>></div>
    </div>

    <div id="form-carga" class="widged">
        <div class="side-column">

            <?php echo form_open_multipart( 'reportes/guardar' ,$atributos); ?>

            <h3>Complete los datos</h3>

            <?php $CI->load->view('/template/acciones_menu', $data); ?>

            <input type="hidden" id="lat" name="lat" value="<?php echo set_value('lat');?>">
            <input type="hidden" id="lng" name="lng" value="<?php echo set_value('lng');?>">

            <?php if(!empty($reporte_success)): ?>
                <div class="row">
                <div class="alert alert-success"><?php echo $reporte_success; ?></div>
                </div>
            <?php endif; ?>

            <?php if(!empty($reporte_error)): ?>
                <div class="row">
                <div class="alert alert-danger"><?php echo $reporte_error; ?></div>
                </div>
            <?php endif; ?>

            <div class="form-group"></div>

            <div class="form-group">
                <div class="col-sm-6">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input placeholder="Fecha" id="fecha-picker" value="<?php echo date("d-m-Y"); ?>" class="selector-fecha form-control" name="fecha" style=""/>
                        <span style="cursor: pointer" onclick="openCalendar();" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input id="hora_reporte_picker" name="hora" type="text" class="hora_reporte_picker_new form-control input-small">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6">
                    <select name="zona_id" id="zona_id" data-none-selected-text="Seleccione Zona" class="selectpicker form-control" data-live-search="true" placeholder="Zona">
                        <option></option>
                        <?php foreach ($zonas as $zona): ?>
                            <option value="<?php echo $zona["id"]; ?>" data-tokens="<?php echo $zona["nombre"]; ?>" ><?php echo $zona["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-6">
                    <select name="evento_id" data-none-selected-text="Seleccione Evento" class="selectpicker form-control" data-live-search="true" id="evento_id" placeholder="Evento">
                        <option></option>
                        <?php foreach ($eventos as $evento): ?>
                            <option value="<?php echo $evento["id"]; ?>" data-tokens="<?php echo $evento["nombre"]; ?>" ><?php echo $evento["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6">
                    <label for="direccion" class="sr-only">Dirección</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="direccion" value="<?php echo set_value('direccion');?>" name="direccion" placeholder="Dirección">
                        <input type="hidden" name="localidad" id="localidad">
                        <input type="hidden" name="altura" id="altura">
                        <input type="hidden" name="calle" id="calle">
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="interseccion" class="sr-only">Interseccón</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="interseccion" value="<?php echo set_value('interseccion');?>" name="interseccion" placeholder="Esquina/Interseccion">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea placeholder="Comentarios" name="comentarios" id="comentarios" class="form-control"><?php echo set_value('comentarios');?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label" for="intervencion" style="color: rgb(119, 119, 119);">Intervención</label>
                    <select class="form-control" id="intervencion" name="intervencion">
                        <option value="UPPL">UPPL</option>
                        <option value="COMANDO">COMANDO</option>
                        <option value="COM">COM</option>
                        <option value="POLICIA FEDERAL">POLICIA FEDERAL</option>
                    </select>
               </div>
            </div>

            <div id="form_dinamico"></div>

            <button type="submit" id="enviarReporte"  value="upload" class="btn btn-block btn-info">GUARDAR</button>
        </div>
    </div>

<?php
//$CI->load->view('reportes/snippet_horizontal');
?>
