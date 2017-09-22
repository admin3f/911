<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html>
<html style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>La Muni en tu barrio</title>
</head>
<body bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; -webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; margin: 0; padding: 0;">

<!-- body -->
<table class="body-wrap" bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 20px;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
    <td class="container" bgcolor="#FFFFFF" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; clear: both !important; display: block !important; max-width: 600px !important; Margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">

      <!-- content -->
      <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; display: block; max-width: 600px; margin: 0 auto; padding: 0;">
      <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 18px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">Reporte Nº <?php echo $reporte; ?></p>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;">Categoría: <?php echo $categoria; ?></p>
            
            <h1 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 24px; line-height: 1.2em; color: #111111; font-weight: 200; margin: 40px 0 10px; padding: 0;"><?php echo $titulo; ?></h1>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;"><?php echo $texto; ?></p>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;"><strong>Dirección: </strong><?php echo $direccion; ?> <a target="_blank" href="<?php echo $mapa; ?>">Ver en Mapa</a></p>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;"><?php if(isset($imagen)){ echo '<p><img src="'.base_url().'assets/subidas/'.$imagen .'" alt="" style="width:100%;height:auto;"></p>';  } ?></p>
            <h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 18px; line-height: 1.2em; color: #111111; font-weight: 200; margin: 40px 0 10px; padding: 0;">Usuario Nº <?php echo $usuario; ?></h3>
            <p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6em; font-weight: normal; margin: 0 0 10px; padding: 0;"> 
            <strong>Nombre: </strong> <?php echo $nombre; ?><br>
            <strong>Email: </strong>  <a href="mailto:<?php echo $email; ?>"> <?php echo $email; ?> </a><br>
            <strong>Celular: </strong> <?php echo $celular; ?><br>
            <strong>DNI: </strong> <?php echo $dni; ?> <br><br></p>
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.6em; width: 100% !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; line-height: 1.6em; text-align: center; vertical-align: top;  margin: 0; padding: 0;" align="center" bgcolor="#348eda" valign="top">
                  <a href="<?php echo site_url('/administracion/ficha_reporte').'/'.$hash;?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 2; color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; text-decoration: none;  margin: 0; padding: 0; border-color: #348eda; border-style: solid; border-width: 10px 20px;">Ver reporte en el sistema</a> 
                </td>
              </tr></table>
<!-- /button -->
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.4em; width: 100% !important; Margin: 0 0 5px; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; line-height: 1.6em; text-align: center; vertical-align: top;  margin: 0; padding: 0;" align="center" bgcolor="#286090" valign="top">
                  <a href="<?php echo site_url('/administracion/set_reporte_status').'/1/'.$hash;?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 2; color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; text-decoration: none;  margin: 0; padding: 0; border-color: #286090; border-style: solid; border-width: 10px 20px;">Aprobar</a> 
                </td>
              </tr></table>
<!-- /button -->
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.4em; width: 100% !important; Margin: 0 0 5px; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; line-height: 1.6em; text-align: center; vertical-align: top; margin: 0; padding: 0;" align="center" bgcolor="#f0ad4e" valign="top">
                  <a href="<?php echo site_url('/administracion/set_reporte_status').'/2/'.$hash;?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 2; color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; text-decoration: none; margin: 0; padding: 0; border-color: #f0ad4e; border-style: solid; border-width: 10px 20px;">En proceso</a> 
                </td>
              </tr></table>
<!-- /button -->
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.4em; width: 100% !important; Margin: 0 0 5px; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; line-height: 1.6em; text-align: center; vertical-align: top;  margin: 0; padding: 0;" align="center" bgcolor="#5cb85c" valign="top">
                  <a href="<?php echo site_url('/administracion/set_reporte_status').'/3/'.$hash;?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 2; color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; text-decoration: none;  margin: 0; padding: 0; border-color: #5cb85c; border-style: solid; border-width: 10px 20px;">Finalizado</a> 
                </td>
              </tr></table>
<!-- /button -->
            <!-- button -->
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.4em; width: 100% !important; Margin: 0 0 10px; padding: 0;"><tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<td style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 14px; line-height: 1.6em; text-align: center; vertical-align: top;  margin: 0; padding: 0;" align="center" bgcolor="#d9534f" valign="top">
                  <a href="<?php echo site_url('/administracion/set_reporte_status').'/-1/'.$hash;?>" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 2; color: #ffffff; display: inline-block; cursor: pointer; font-weight: bold; text-decoration: none;  margin: 0; padding: 0; border-color: #d9534f; border-style: solid; border-width: 10px 20px;">Rechazar</a> 
                </td>
              </tr></table>
<!-- /button -->



          </td>
        </tr></table>
</div>
      <!-- /content -->
      
    </td>
    <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
  </tr></table>
<!-- /body -->
</body>
</html>