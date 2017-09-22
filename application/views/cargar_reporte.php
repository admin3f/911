<?php
defined('BASEPATH') OR exit('No direct script access allowed');
      $atributos = array( 'role' => 'form',
                         'class' => 'form-horizontal',
                            'id' => 'cargarReporte',
                  'autocomplete' => "off"

                        ); 
       ?>
      <div class="col-md-9 col-sm-8 col-md-push-3 col-sm-push-4">
      <div class="row">
        <div id="TdeFMap"></div>
      </div>
        
      </div>
      <div class="col-md-3 col-sm-4 col-md-pull-9 col-sm-pull-8">
        <div class="side-column">
          <?php echo form_open_multipart( '' ,$atributos); ?>
          <h3>Complete los datos</h3>
          <?php echo validation_errors();?>
          <?php echo (isset($error))?$error:''; ?>
          <input type="hidden" id="lat" name="latReportes" value="<?php echo set_value('latReportes');?>">
           <input type="hidden" id="lng" name="lngReportes" value="<?php echo set_value('lngReportes');?>">
            <div class="form-group">
              <div class="col-sm-12">
                  <label for="direccionReporte" class="sr-only">Dirección</label>
                  <div class="input-group">
                      <input type="text" class="form-control" id="direccionReporte" value="<?php echo set_value('direccionReporte');?>" name="direccionReporte" placeholder="Dirección del reporte">
                      <span class="input-group-btn">
                        <button class="btn btn-default" id="verDirecion" name="verDirecion" type="button">Ver</button>
                      </span>
                    </div><!-- /input-group -->
                 <p class="help-block small">Mueva el icono o haga clic si el direccion  que se muestra en el mapa es incorrecto.</p>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <label for="tituloReporte" class="sr-only">Titulo del Reporte</label>
                <input type="text" class="form-control" name="tituloReporte" id="tituloReporte" value="<?php echo set_value('tituloReporte');?>" placeholder="Titulo del reporte">
              </div>
            </div>        
            <div class="form-group">
              <div class="col-sm-12">
                <label for="textoReporte" class="sr-only">Descripción del Reporte</label>
                <textarea id="textoReporte" name="textoReporte"  class="form-control" rows="4" placeholder="Escriba aquí una descripción"><?php echo set_value('textoReporte');?></textarea>
              </div>
            </div>
            <div class="form-group" id="drag-foto">
              <div class="col-sm-12" >
                <div>
                    <span class="img-responsive preview"></span>
                </div>
                <input type="file"  value="<?php echo set_value('imagenReporte')?>" class="form-control" name="imagenReporte" />
              </div>
             </div> 
              <div class="form-group">
                <div class="col-sm-12" >
                  <div class="btn-group  btn-group-justified btn-group-sm" data-toggle="buttons">
                      <?php foreach ($categorias as $categoria): ?>

                        <label class="btn btn-default<?php if(set_radio('categoriaReporte', $categoria["id"])){ echo ' active';}?>">
                          <input type="radio" value="<?php echo $categoria["id"]; ?>" name="categoriaReporte" id="categoriaReporte<?php echo $categoria["id"]; ?>" <?php echo set_radio('categoriaReporte', $categoria["id"]); ?> autocomplete="off">
                          <img src="<?php echo base_url().'assets/img/icon-'.$categoria["id"].'.png'; ?>" alt=" <?php echo $categoria["nombre"]; ?>">  <br>
                          <?php echo $categoria["nombre"]; ?>
                        </label>
                      <?php endforeach; ?>
                      </div>
                  </div>
               </div>
                               
            <div class="form-group">
            <div class="col-sm-6">
               <label for="nombreReporte" class="sr-only">Nombre</label>
              <input type="text" class="form-control" id="nombreReporte"  name="nombreReporte" value="<?php echo set_value('nombreReporte');?>" placeholder="Nombre">         
            </div>
            <div class="col-sm-6">
               <label for="apellidoReporte" class="sr-only">Apellido</label>
              <input type="text" class="form-control" id="apellidoReporte" name="apellidoReporte" value="<?php echo set_value('apellidoReporte');?>" placeholder="Apellido">         
            </div>
            </div>
            <div class="form-group">
              <div class="col-sm-7">
                 <label for="dniReporte" class="sr-only">DNI</label>
                <input type="number" class="form-control" id="dniReporte" name="dniReporte" value="<?php echo set_value('dniReporte');?>" placeholder="DNI">         
              </div>
              <div class="col-sm-5">
       
              
             
                      <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default<?php if(set_radio('generoReporte', '1')){ echo ' active';}?>">
                          <input type="radio" value="1" name="generoReporte" id="generoReporteF" <?php echo set_radio('generoReporte', '1'); ?> autocomplete="off"> F
                        </label>
                        <label class="btn btn-default<?php if(set_radio('generoReporte', '2')){ echo ' active';}?>">
                          <input type="radio" value="2" name="generoReporte" id="generoReporteM" <?php echo set_radio('generoReporte', '2'); ?> autocomplete="off"> M
                        </label>
                      </div>
              
                  
           
               </div> 
             </div>   
             <div class="form-group">
                <label class="sr-only" for="celularReporte">Celular</label>
                <div class="col-sm-5">
                  <div class="input-group">
                    <div class="input-group-addon">0</div>
                    <input type="text" class="form-control" id="celularAreaReporte" name="celularAreaReporte" value="<?php echo set_value('celularAreaReporte');?>" placeholder="11">
                  </div>
                 </div>
                  <div class="col-sm-7">
                   <div class="input-group">
                    <div class="input-group-addon">15</div>
                    <input type="text" class="form-control" id="celularReporte" name="celularReporte" value="<?php echo set_value('celularReporte');?>" placeholder="12341234">
                  </div>
                  </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12">
                  <label for="emailReporte" class="sr-only">E-mail</label>
                  <input type="email" class="form-control" id="emailReporte"  name="emailReporte" value="<?php echo set_value('emailReporte');?>" placeholder="Correo eléctronico">  
                </div>
              </div>



            
            </div>
            <div class="col-sm-12 ">
               <button type="submit" id="enviarReporte"  value="upload" class="btn btn-block btn-info">Enviar</button>
            </div>

           
          </form>
        </div>  
        
      </div>


        
  



