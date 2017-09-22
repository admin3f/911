<div class="modal-header">
      <input type="hidden" id="reporte_id_h" value="<?php echo $usuario->id; ?>" />
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel"><?php echo $usuario->id.' - '.$usuario->titulo; ?>  
                <?php switch ($usuario->estado) {
          case 1:
              echo '<span class="label label-primary">Aprobado</span>';
            break;
           case 2:
               echo '<span class="label label-warning">En proceso</span>';
            break;
            case 3:
              echo '<span class="label label-success">Finalizado</span>';
            break;
            case -1:
              echo '<span class="label label-danger">Rechazada</span>';
            break;         
          default:
            # code...
            break;
        }
        if( $usuario->oculto == 1){
          echo ' - <span class="label label-danger">Oculto</span>';
        }else{
          echo ' - <span class="label label-success">Visible</span>';
        }

        ?>    	
        </h4>
        <strong>Reporte: </strong>
            <p><?php 
                echo $usuario->texto ?></p>
         <strong>Dirección: </strong>
                <p><?php echo ucwords ( strtolower ($usuario->direccion)); ?></p>
                                <?php if( $usuario->imagen != '' && $usuario->imagen != NULL): ?>
                   <img src="<?php echo base_url().'assets/subidas/'.$usuario->imagen ?>" alt="" class="img-responsive">
                <?php endif;?>  
                   <div><strong>Origen</strong>
                       <div style="width: 36px"><img style="width: 100%" src="<?php echo base_url() . 'assets/img/' . ($usuario->origen == 1  ? 'app.png' : 'web.png');?>" alt="Origen" /></div></td>
                   </div>
      </div>
      <div class="modal-body">
              <div class="main ficha-main contact-ficha-main">
        <!--  -->
        <div class="chart-user-info row">
          <div class="col-md-8 left-col">
          	<h4>Datos usuario</h4>
              <h5><?php 
              echo  $usuario->usuario . ' - ' . $usuario->nombre . ' ' . $usuario->apellido; ?></h5>
            
            
              <div class="row">
                <div class="doble-info col-md-6">
                  <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                  <span><?php echo $usuario->email; ?></span>
                    <div>
                   <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>
                    <span><?php echo $usuario->celular_area.' '.$usuario->celular; ?></span>
                  </div>
                  <div>
                    <!--<i class="womanIc"></i>-->
                    <strong>DNI: </strong>
                    <span><?php echo $usuario->dni; ?></span>
                  </div>
                 
                </div>

               
               
              </div>
            </div>
          </div>
          <hr>
          <div class="row" id="acciones-box">
    
              <div class="col-md-4">

                <h4>Acciones</h4>
              </div>
              <div class="col-md-12">
                  
                <div class="row">
                        <div class="col-md-3">  

                        <button type="button" href="#" id="ap_1" class="<?php if( $usuario->estado == 1){ echo 'active '; }?>set-status-reporte  btn-block btn btn-primary ">APROBAR</button>
                        </div>
                    <div class="col-md-3">  
                         <button type="button" href="#" id="ap_2" class="<?php if( $usuario->estado == 2){ echo 'active '; }?>set-status-reporte  btn-block btn btn-warning ">EN PROCESO</button>
                         </div>
                       <div class="col-md-3"> 
                        <button type="button" href="#" id="ap_3" class="<?php if( $usuario->estado == 3){ echo 'active '; }?>set-status-reporte  btn-block btn btn-success ">FINALIZADO</button>
                        </div>
                         <div class="col-md-3">                                          
                         <button type="button" href="#" id="ap_-1" class="<?php if( $usuario->estado == -1){ echo 'active '; }?>set-status-reporte  btn-block btn btn-danger ">RECHAZAR</button>
                         </div>
                </div>
                  
                  <div class="row">
                      <div class="col-md-3">
                          <h4>Categoria: <?php echo $categoria_actual->nombre; ?></h4>
                          <div class="dropdown" style="margin-bottom: 10px;">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Modificar Categoria
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                              <?php foreach($categorias as $categoria): ?>
                                <li><a onclick="return confirm('¿Esta seguro?')" href="<?php echo site_url('/administracion/cambiar_categoria/'.$usuario->id.'/'.$categoria['id']); ?>"><?php echo $categoria['nombre']; ?></a></li>
                              <?php endforeach; ?> 
                            </ul>
                          </div>
                      </div>
                  </div>
                  
              </div>
             
          </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
      <div class="row">
      <div class="col-md-2">
        <?php 
          if( $usuario->oculto == 0){
            echo '<button type="button" id="o_1"  class="btn set-oculto-reporte btn-danger btn-block" data-dismiss="modal">Ocultar</button>';
          }else{
            echo '<button type="button" id="o_0"  class="btn set-oculto-reporte btn-success btn-block" data-dismiss="modal">Mostar</button>';
          }        
        ?>
       
      </div>
      <div class="col-md-10">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
        
      </div>
      </div>
      

<script>
	$('.set-status-reporte').click(function(e){

                            e.preventDefault();
                            
                            var s = $(this).attr('id');
                            s = s.split('_');
                            var $this =  $(this)
                            var content = $this.html();
                            var img = '<img src="'+site_url+'assets/img/searchloader.gif" />';
                           $this.html(img);
                           console.log(s);
                            console.log(site_url+"administracion/ajax_set_reporte_status/"+s[1]+"/"+$('#reporte_id_h').val());
                            $.get( site_url+"administracion/ajax_set_reporte_status/"+s[1]+"/"+$('#reporte_id_h').val(), function(data) {
                            
                               $this.html(content);
                                if(data == '1'){
                                   
                                        alert('El reporte fue procesado exitosamente');
                              
                                }else{
                                    alert('Ha ocurrido un error, intente nuevamente');
                                }   
                               location.reload();
                            });
                         });

  $('.set-oculto-reporte').click(function(e){

                            e.preventDefault();
                            
                            var s = $(this).attr('id');
                            s = s.split('_');
                            var $this =  $(this)
                            var content = $this.html();
                            var img = '<img src="'+site_url+'assets/img/searchloader.gif" />';
                           $this.html(img);
                           console.log(s);
                            console.log(site_url+"administracion/ajax_set_reporte_oculto/"+s[1]+"/"+$('#reporte_id_h').val());
                            $.get( site_url+"administracion/ajax_set_reporte_oculto/"+s[1]+"/"+$('#reporte_id_h').val(), function(data) {
                            
                               $this.html(content);
                                if(data == '1'){
                                   
                                        alert('El reporte fue procesado exitosamente');
                              
                                }else{
                                    alert('Ha ocurrido un error, intente nuevamente');
                                }   
                               location.reload();
                            });
                         });
</script>