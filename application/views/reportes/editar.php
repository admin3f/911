<?php
$CI =& get_instance();
defined('BASEPATH') OR exit('No direct script access allowed');
$atributos = array(
    'role' => 'form',
    'class' => 'form-horizontal',
    'id' => 'cargarReporte',
    'autocomplete' => "on"
);

$data["new"] = false;
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
            <?php echo form_open_multipart( 'reportes/guardar_edit/' . $id ,$atributos); ?>
            <h3>Complete los datos</h3>

            <?php $CI->load->view('/template/acciones_menu', $data); ?>

            <input type="hidden" id="lat" name="lat" value="<?php echo $reporte->lat;?>">
            <input type="hidden" id="lng" name="lng" value="<?php echo $reporte->lng;?>">

            <?php if(!empty($reporte_success)): ?>
            <div class="alert alert-success"><?php echo $reporte_success; ?></div>
            <?php endif; ?>

            <?php if(!empty($reporte_error)): ?>
            <div class="alert alert-danger"><?php echo $reporte_error; ?></div>
            <?php endif; ?>

            <div class="form-group"></div>

            <div class="form-group">
                <div class="col-sm-6">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input disabled placeholder="Fecha" id="fecha-picker" value="<?php echo date("d-m-Y", strtotime($reporte->fecha)); ?>" class="selector-fecha form-control" name="fecha" />
                        <span style="cursor: pointer" onclick="openCalendar();" class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="input-group bootstrap-timepicker timepicker">
                        <input disabled value="<?php echo date("H:i", strtotime($reporte->hora)); ?>" id="hora_reporte_picker" name="hora" type="text" class="form-control input-small">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6">
                    <select name="zona_id" id="zona_id" data-none-selected-text="Seleccione Zona" class="selectpicker form-control" data-live-search="true" placeholder="Zona">
                        <option></option>
                        <?php foreach ($zonas as $zona): ?>
                            <option <?php echo ($reporte->zona_id == $zona["id"] ? 'selected="selected"' : ''); ?> value="<?php echo $zona["id"]; ?>" data-tokens="<?php echo $zona["nombre"]; ?>" ><?php echo $zona["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-sm-6">
                    <select name="evento_id" data-none-selected-text="Seleccione Evento" class="selectpicker form-control" data-live-search="true" id="evento_id" placeholder="Evento">
                        <option></option>
                        <?php foreach ($eventos as $evento): ?>
                            <option <?php echo ($reporte->evento_id == $evento["id"] ? 'selected="selected"' : ''); ?> value="<?php echo $evento["id"]; ?>" data-tokens="<?php echo $evento["nombre"]; ?>" ><?php echo $evento["nombre"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6">
                    <label for="direccion" class="sr-only">Dirección</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="direccion" value="<?php echo $reporte->direccion;?>" name="direccion" placeholder="Dirección">
                        <input type="hidden" name="localidad" id="localidad">
                        <input type="hidden" name="altura" id="altura">
                        <input type="hidden" name="calle" id="calle">
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="interseccion" class="sr-only">Interseccón</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="interseccion" value="<?php echo $reporte->interseccion; ?>" name="interseccion" placeholder="Esquina/Interseccion">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <textarea placeholder="Comentarios" name="comentarios" id="comentarios" class="form-control"><?php echo $reporte->comentarios; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label class="control-label" for="intervencion" style="color: rgb(119, 119, 119);">Intervención</label>
                    <select class="form-control" id="intervencion" name="intervencion">
                        <option <?php if($reporte->intervencion == "UPPL" ) echo "selected" ?> value="UPPL">UPPL</option>
                        <option <?php if($reporte->intervencion == "COMANDO" ) echo "selected" ?> value="COMANDO">COMANDO</option>
                        <option <?php if($reporte->intervencion == "COM" ) echo "selected" ?> value="COM">COM</option>
                        <option <?php if($reporte->intervencion == "POLICIA FEDERAL" ) echo "selected" ?> value="POLICIA FEDERAL">POLICIA FEDERAL</option>
                    </select>
               </div>
            </div>

            <div id="form_dinamico">
                <?php echo $form_reporte; ?>
            </div>

            <button type="submit" id="enviarReporte"  value="upload" class="btn btn-block btn-info">GUARDAR</button>

            <div class="form-error-pop-up form-pop-up" <?php echo (isset($error)||validation_errors())?'style="display:block;"':'style="display:none;"' ?>>
                <div>
                    <div class="disp-table">
                        <div class="disp-table-cell">
                            <img src="<?php echo base_url();?>assets/img/error-form-icon.png" alt="error">
                            <h5>ERROR<br>Corroborá los siguientes datos:</h5>
                            <div class="output-errors">
                                <?php echo validation_errors();?>
                                <?php echo (isset($error))?$error:''; ?>
                            </div>
                            <button type="button" id="corregirReporte" class="btn btn-block btn-info">Corregir Errores</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-gracias-pop-up form-pop-up " <?php echo ($gracias)?'style="display:block;"':'style="display:none;"' ?>>
                <div>
                    <div class="disp-table">
                        <div class="disp-table-cell">
                            <img src="<?php echo base_url();?>assets/img/gracias-form-icon.png" alt="Gracias">
                            <h5> GRACIAS.<br>Tus datos han sido enviados. </h5>
                            <?php if( $num_reporte): ?>
                            <h4>Tu número de reporte es: <?php echo $num_reporte;?></h4>
                            <?php endif;?>
                            <button  type="button"  id="corregirReporte" class="btn btn-block btn-info">CARGAR NUEVO REPORTE</button>
                            <button type="button" id="volverReporte" class="btn btn-block btn-info">VOLVER A LA NAVEGACIÓN</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
//$CI->load->view('reportes/snippet_horizontal');
?>
