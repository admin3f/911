<div class="container">
    <a href="<?php echo site_url('/administracion/login'); ?>" class="btn btn-success"><i></i><span>Login</span></a>

      
      <div class="modal-header">
      <input type="hidden" id="reporte_id_h" value="<?php echo $usuario->id; ?>" />

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
        }?>    	
        </h4>
        <strong>Reporte: </strong>
            <p><?php 
                echo $usuario->texto ?></p>
         <strong>Dirección: </strong>
                <p><?php echo ucwords ( strtolower ($usuario->direccion)); ?></p>
                                <?php if( $usuario->imagen != '' && $usuario->imagen != NULL): ?>
                   <img src="<?php echo base_url().'assets/subidas/'.$usuario->imagen ?>" alt="" class="img-responsive">
                <?php endif;?>  
        
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

                        <a  href="<?php echo site_url('/administracion/set_reporte_status').'/1/'.$hash;?>" id="ap_1" class="<?php if( $usuario->estado == 1){ echo 'active '; }?>set-status-reporte  btn-block btn btn-primary ">APROBAR</a>
                        </div>
                    <div class="col-md-3">  
                         <a  href="<?php echo site_url('/administracion/set_reporte_status').'/2/'.$hash;?>" id="ap_2" class="<?php if( $usuario->estado == 2){ echo 'active '; }?>set-status-reporte  btn-block btn btn-warning ">EN PROCESO</a>
                         </div>
                       <div class="col-md-3"> 
                        <a  href="<?php echo site_url('/administracion/set_reporte_status').'/3/'.$hash;?>" id="ap_3" class="<?php if( $usuario->estado == 3){ echo 'active '; }?>set-status-reporte  btn-block btn btn-success ">FINALIZADO</a>
                        </div>
                         <div class="col-md-3">                                          
                         <a  href="<?php echo site_url('/administracion/set_reporte_status').'/-1/'.$hash;?>" id="ap_-1" class="<?php if( $usuario->estado == -1){ echo 'active '; }?>set-status-reporte  btn-block btn btn-danger ">RECHAZAR</a>
                         </div>
                </div>
              </div>
             
          </div>
        </div>
      </div>
      </div>
      <div class="modal-footer">
      <div class="row">

        
      </div>
      </div>
      
</div>
</div>
