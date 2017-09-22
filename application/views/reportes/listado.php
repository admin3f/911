
          <?php
            $atributos = array(
        'class' => "navbar-form  navbar-right" ,
        'id'=>'form-export'
      );
          ?>
<div class="container-fluid<?php if( $print != '' ) echo " visible-print" ?> admin">
<div class="col-sm-12">

  <a href="<?php echo site_url('/administracion/logout'); ?>" class="btn btn-default hidden-print"><i></i><span>Salir</span></a>
        <?php echo form_open( 'administracion/listado' ,$atributos); ?>
                  <div class="btn-group" role="group" aria-label="...">
                     <button type="submit" name="imprimir" value="true" class="btn  btn-gray">Imprimir</button>
                     <span id="exportar-btn-container">
                        <button type="submit" name="exportar" id="exportar-btn" value="true" class="btn  btn-primary">Exportar</button>
                     </span>
                     <div id="loading-export" style="display: none;text-align: center;">
                         <img src="<?php echo base_url(); ?>assets/img/searchloader.gif" />
                         <span> Generando el listado, por favor aguarde..</span>
                     </div>
                     <span id="btn-container">
                        <a href="<?php echo site_url('/reportes'); ?>" id="exportar-btn" class="btn  btn-primary">Nuevo</a>
                     </span>
                  </div>
                  </form>

  <h2>Listado de Reportes</h2>
  <div class="infoHeader hidden-print">

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="collapse navbar-collapse">


          <?php echo form_open( 'reportes/listado' ,$atributos); ?>

          <ul class="nav navbar-nav" role="tablist">
              <li>
              <!--<li role="presentation" class="dropdown"> <a id="drop4" href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Zona <span class="caret"></span> </a>-->
<!--                <ul id="menu1" class="dropdown-menu" aria-labelledby="drop4">
          <?php

//              $status = array(
//                '-1'=>'Descartado',
//                '0'=>'Sin revisar',
//                '1'=>'Aprobado',
//                '2'=>'En proceso',
//                '3'=>'Finalizado'
//                );

              foreach($zonas as $k=>$zona):
                  $st = $zona['nombre'];
                ?>
              <li style="padding: 10px 3px;"><input id="st-<?php echo $k; ?>"
                <?php
                if(isset($filtros['zona_id'])):
                  if(in_array($k, $filtros['zona_id'])):
                    ?>
                  checked="checked"
                  <?php
                  endif;
                  endif;
                  ?>
                  type="checkbox" value="<?php echo $k; ?>" name="zona_id[]"><label for="st-<?php echo $k; ?>"><?php echo $st; ?></label></li>
                  <?php
                  endforeach;
                  ?>
                </ul>-->

                <select data-selected-text-format="count"  multiple name="zona_id[]" id="zonaReporte" data-none-selected-text="Zonas" class="selectpicker form-control" data-live-search="true" placeholder="Zona">
                    <!--<option selected="selected" value="" disabled="disabled">Seleccione una Zonssa</option>-->
                    <option></option>
                    <?php foreach ($zonas as $zona): ?>
					<?php $selected = (in_array($zona["id"], $filtros["zona_id"])) ? "selected" : ""; ?>
                  <option <?php echo $selected;?> value="<?php echo $zona["id"]; ?>" data-tokens="<?php echo $zona["nombre"]; ?>" ><?php echo $zona["nombre"]; ?></option>
            <?php endforeach; ?>
                </select>
            </li>
            <li>
                <!--<li role="presentation" class="dropdown"> <a id="drop5" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Eventos <span class="caret"></span> </a>-->
<!--              <ul id="menu2" class="dropdown-menu" aria-labelledby="drop5">
   <?php


                foreach($eventos as $evento):
                    $evento = (array) $evento;
                  ?>
                <li style="padding: 10px 3px;"><input id="cat-<?php echo $evento['id']; ?>"
                  <?php
                  if(isset($filtros['categorias'])):
                    if($evento['id'] == $filtros['categorias']):
                      ?>
                    checked="checked"
                    <?php
                    endif;
                    endif;
                    ?>
                    type="radio" value="<?php echo $evento['id']; ?>" name="categorias"><label for="cat-<?php echo $evento['id']; ?>"><?php echo $evento['nombre']; ?></label></li>
                    <?php
                    endforeach;
                    ?>
              </ul>-->
        <select multiple  data-selected-text-format="count" name="evento_id[]" data-none-selected-text="Eventos" class="selectpicker form-control" data-live-search="true" id="eventoReporte" placeholder="Evento">
            <!--<option selected="selected" disabled="disabled" value="">Seleccione un Evento</option>-->
            <option></option>
                <?php foreach ($eventos as $evento): ?>
				<?php $selected = (in_array($evento["id"], $filtros["evento_id"])) ? "selected" : ""; ?>
              <option <?php echo $selected;?> value="<?php echo $evento["id"]; ?>" data-tokens="<?php echo $evento["nombre"]; ?>" ><?php echo $evento["nombre"]; ?></option>
        <?php endforeach; ?>
          </select>
          </li>



                <!--<label>Desde</label>-->
                <?php if(!empty($filtros) && isset($filtros['fecha_desde']) && !empty($filtros['fecha_desde'])):
                $val = date('d-m-Y', strtotime($filtros['fecha_desde']));
                else:
                  $val = '';
                endif; ?>
                <input placeholder="Desde" value="<?php echo $val; ?>" class="selector-fecha form-control" name="fecha_desde" style="
                width: 15%;"/>
                <!--<a href="#" class="dropdown-toggle" id="avanzado-trigger" data-toggle="dropdown">Avanzado <b class="caret"></b></a>-->
                <?php if(!empty($filtros) && isset($filtros['fecha_hasta']) && !empty($filtros['fecha_hasta'])):
                $val = date('d-m-Y', strtotime($filtros['fecha_hasta']));
                else:
                  $val = '';
                endif; ?>
                <input placeholder="Hasta" value="<?php echo $val; ?>" class="selector-fecha form-control" name="fecha_hasta" style="
                width: 15%;"/>
                <!--<a href="#" class="dropdown-toggle" id="avanzado-trigger" data-toggle="dropdown">Avanzado <b class="caret"></b></a>-->

                <!--<label>Hasta</label>-->
                <?php if(!empty($filtros) && isset($filtros['buscar']) && !empty($filtros['buscar'])):
                $val = $filtros['buscar'];
                else:
                  $val = '';
                endif; ?>
                <input placeholder="Buscar..." value="<?php echo $val; ?>" class="form-control" name="buscar" />

				 <div class="form-group">
               		<div class="btn-group" role="group" aria-label="...">
                		<button  type="submit" class="btn btn-success">Filtrar</button>
                		<button type="submit" name="limpiar" value="limpiar" class="btn  btn-danger">Limpiar</button>
              		</div>
                  </div>
                  </ul>
               </form>






        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <!--  -->
  </div>
<!--   <div id="filtros-avanzado">
  <?php //$CI->load->view('admin/partials_dirigentes/filtros_avanzado', $permisos); ?>
   </div>
 -->
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
 <div class="up-box hidden-print row">
     <div class="col-md-6">
<!--    <a href="<?php echo site_url('/admin/dirigentes/export'); ?>" class="btn btn-default sub1">Exportar Contactos</a>
  <a href="#" id="export-sel-btn" class="btn btn-default sub1">Exportar Contactos Seleccionados</a>-->
  <?php if(!empty($filtros) && isset($filtros['fecha_desde']) && !empty($filtros['fecha_desde'])): ?>
  <p>Filtro actual: <?php echo date('d/m/Y', strtotime($filtros['fecha_desde'])) . ' 00:00'; ?> - <?php echo date('d/m/Y', strtotime($filtros['fecha_hasta'])) . ' 23:59'; ?></p>
<?php endif; ?>
<p>
  <!--<span>14 seleccionados</span>-->
  <strong><?php echo $total_rows; ?> reportes</strong>
</p>
     </div>
<!--     <div class="col-md-6">
         <span class="pull-right"><span>Web</span><div style="width: 36px"><img style="width: 100%" src="<?php echo base_url() . 'assets/img/web.png'; ?>" alt="Origen" /></div></span>
         <span class="pull-right"><span>App</span><div style="width: 36px"><img style="width: 100%" src="<?php echo base_url() . 'assets/img/app.png'; ?>" alt="Origen" /></div></span>
     </div>-->
</div>
<div class="panel panel-default">


 <?php  if( !empty($results) ):
     $no_mostrar = array();
?>
      <table class="table table-hover table-condensed ">
        <thead>
          <tr>
          <?php $nuevo_orden = ($orden == 'desc' ) ? 'asc' : 'desc';
                $nuevo_orden_ico =    ($orden == 'desc' ) ? '&#x25BC' : '&#x25B2' ;
          foreach ( array_keys($results[0] )  as $value) {
            if( $value == 'Calle' ){
                  echo "<th><a href='".site_url('/administracion/listado')."/campo/calle/orden/".( ($campo != 'calle') ? 'desc' : $nuevo_orden )."'>".$value."&nbsp;".( ($campo != 'calle') ? '&#x25BC' : $nuevo_orden_ico )."</a></th>";
            }elseif( $value == 'Direcciónx' ){
                  echo "<th><a href='".site_url('/administracion/listado')."/campo/direccion/orden/".( ($campo != 'direccion') ? 'desc' : $nuevo_orden )."'>".$value."&nbsp;".( ($campo != 'direccion') ? '&#x25BC' : $nuevo_orden_ico )."</a></th>";
            }elseif( $value == 'Localidad' ){
                  echo "<th><a href='".site_url('/administracion/listado')."/campo/localidad/orden/".( ($campo != 'localidad') ? 'desc' : $nuevo_orden )."'>".$value."&nbsp;".( ($campo != 'localidad') ? '&#x25BC' : $nuevo_orden_ico )."</a></th>";
            }elseif( $value == 'idx' ){
                  echo "<th><a href='".site_url('/administracion/listado')."/campo/id/orden/".( ($campo != 'id') ? 'desc' : $nuevo_orden )."'>".$value."&nbsp;".( ($campo != 'id') ? '&#x25BC' : $nuevo_orden_ico )."</a></th>";
            }else{
                if(!in_array($value, $no_mostrar)){
                    echo "<th>$value</th>";
                }
            }

          }?>
          <th></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
          <?php foreach ( array_keys($results[0] )  as $key => $value) {

              echo "<th>$value</th>";


          }?>
          <th></th>
          </tr>
        </tfoot>
        <tbody>
          <?php foreach ( $results  as $array): ?>
          <tr>
            <?php foreach ( $array  as $key => $value): ?>
              <?php if( $key == 'Categoría'): ?>
             <td><?php echo ( $categorias[ array_search($value, array_column($categorias, 'id'))]['nombre']  );?></td>
              <?php elseif( $key == 'Estado' ):
                   switch ($value) {
                            case '-1':
                                echo '<td><span class="label label-danger">'.$status['-1'].'</span></td>';
                              break;
                            case '1':
                                echo '<td><span class="label label-primary">'.$status['1'].'</span></td>';
                              break;
                             case '2':
                                 echo '<td><span class="label label-warning">'.$status['2'].'</span</td>';
                              break;
                              case '3':
                                echo '<td><span class="label label-success">'.$status['3'].'</span></td>';
                              break;
                              case '0':
                                echo '<td><span class="label label-default">'.$status['0'].'</span></td>';
                              break;
                        }
              elseif( $key == 'Visible' ):
                if( $value== 1 ){
                   echo '<td><h4 class="text-danger text-center"><span class="glyphicon glyphicon-eye-close"></span></h4></td>';

                }else{
                   echo '<td><h4 class="text-success text-center"><span class="glyphicon glyphicon-eye-open"></span></h4></td>';
                }
              else: ?>
              <td><?php
                if(!in_array($key, $no_mostrar)){
                    echo $value;
                }

                ?></td>
              <?php endif; ?>
              <?php endforeach; ?>
              <!--<td > <div style="width: 36px"><img style="width: 100%" src="<?php echo base_url() . 'assets/img/' . ($array['origen'] == 1  ? 'app.png' : 'web.png');?>" alt="Origen" /></div></td>-->
              <td style="white-space: nowrap;">
				<a href="#" data-id="<?php echo $array['id']; ?>" class="btn btn-primary ver_popup">Ver</a>
				<a href="<?php echo site_url('/reportes/editar/'.$array['id']); ?>" class="btn btn-success">Ampliar</a>
			  </td>

          </tr>
          <?php endforeach; ?>


        </tbody>
      </table>
    <?php endif; ?>


</div>
<div class="paginationCont hidden-print">
<ul class="pagination"><?php echo $pagination_links; ?></ul>
</div>
</div>
</div>
<!-- end main -->
<div class="modal fade" id="datosUsuarios" tabindex="-1" role="dialog" aria-labelledby="datosUsuarios" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="ficha-usuario">

    </div>
  </div>
</div>

<script type="text/javascript">
   var site_url = '<?php echo base_url(); ?>';
</script>
<div id="export-div">

</div>
<script type="text/javascript">
    $(function(){
       $('#exportar-btn').click(function(e){
         e.preventDefault();

         $( "#form-export" ).append('<input type="hidden" name="exportar" value="1" />')
         $('#exportar-btn-container').hide();
         $('#loading-export').fadeIn('slow');
         $('#form-export').submit();
         setTimeout(function(){
             $('#loading-export').hide();
             $('#exportar-btn-container').show();
         }, 10000);
       });

	  $('.ver_popup').click(function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var content = $(this).html();
		var img = '<img src="'+site_url+'/assets/img/searchloader.gif" />';
		$(this).html(img);
		var link = $(this);

		$.get(site_url+"/reportes/ajax_get_reporte/"+id, function(data) {
		  $('#ficha-usuario').html(data);
		  $('#datosUsuarios').modal();
		});
		$(this).html(content);
		  return false;
	   });

	  $(document).on("click", ".close_popup", function()
	  {
		$('#datosUsuarios').modal('toggle');
	  });
    });
</script>
