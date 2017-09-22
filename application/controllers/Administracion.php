<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administracion extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('SimpleLoginSecure');
		$this->load->model('admin_model');
                $this->load->model('reportes_model');

	}

	function index()
	{
		if($this->session->logged_in) {
			//Lo redirijo al panel
			redirect('administracion/listado');
		}else{
			//Lo redirijo al login
			redirect('administracion/login');
		}


	}

	function _is_logged_in(){
		if($this->session->userdata('logged_in')) {
			return TRUE;
		}
		return FALSE;
	}

	function login(){
		$this -> load -> library('form_validation');
		$this -> load -> helper('form');


		if( $this->session->userdata('logged_in') ) {
			//Lo redirijo al panel
          redirect('administracion/listado');
      }else{
			//Vista de logeo
         $this->form_validation->set_rules('name', 'Usuario', 'trim|required');

         $this->form_validation->set_rules('user', 'Contraseña', 'trim|required|callback_check_login');




         if ($this->form_validation->run() == FALSE)
         {

            $this->load->view('admin/template/header');
			$this->load->view('template/navbar');
            $this->load->view('admin/login');
            $this->load->view('admin/template/footer');

        }
        else
        {
            	//redirijo a panel
           $this->session->unset_userdata('intento');
           $user = $this->admin_model->get_user($_POST['name']);
           if($user){
               $this->session->set_userdata('user_id', $user->id);
               $this->session->set_userdata('es_admin', $user->es_admin);
               $this->session->set_userdata('user_nombre', $user->nombre);
               $this->session->set_userdata('user_apellido', $user->apellido);
           }

           redirect('/reportes/cargar');
       }


   }
}

function nuevo($nombre, $password){

    if($this->session->logged_in) {
        $this->simpleloginsecure->create($nombre, $password, false);
    }



}

function logout(){

  $this->simpleloginsecure->logout();
  redirect('');
}

function check_login($password)
{
   $username = $this->input->post('name');


   if (!$this->simpleloginsecure->login($username,$password))
   {
    $this->form_validation->set_message('check_login', 'Error, nombre de usuario o contraseña incorrecta');
    $this->session->set_userdata('intento', '1');
    return FALSE;
}
else
{
    return TRUE;
}
}

function check_recaptcha(){
  $this -> recaptcha -> recaptcha_check_answer();

  if ($this -> recaptcha -> getIsValid()){
     return TRUE;
 }else{
     $this->form_validation->set_message('check_recaptcha', 'Error, recaptcha incorrecto');
     return FALSE;
 }
}



function descartar($id = 0){
    $this->load->library('user_agent');

    $anu = $this->admin_model->descartar($id);
    $referrer = $this->agent->referrer();
    if($anu){
      redirect($referrer);
  }

}


function listado(){
    error_reporting(E_ALL);
    set_time_limit(0);

	$this->load->helper('mysql_to_excel_helper');
	$this -> load -> helper('form');
    if(!$this->session->userdata('logged_in')) {
        redirect('administracion/index');
    }

    $this->load->library('pagination');

    $data['autorizado'] = FALSE;
    $config = array();

   $filtro_campo = FALSE;
   $pagination_url = '/administracion/listado/';

  if( $this->input->post('limpiar')){
    $this->session->filtros = '';
  }elseif($this->input->post() &&  !$this->input->post('imprimir') && !$this->input->post('exportar') ){
    $this->session->filtros = $this->input->post(); /// filtros
  }



    if ($filtro_orden_key = array_search( 'campo', $this->uri->segments)){
        $filtro_campo = $this->uri->segment( $filtro_orden_key + 1);
         $pagination_url .= 'campo/'.$filtro_campo.'/';
    }

    if ($filtro_orden_key = array_search( 'orden', $this->uri->segments)){
        $filtro_orden = $this->uri->segment( $filtro_orden_key + 1);
         $pagination_url .= 'orden/'.$filtro_orden.'/';


    }else{
       $filtro_orden = 'desc';
    }

    $data['orden'] =   $filtro_orden ;
    $data['campo'] =   $filtro_campo ;

    $config['num_tag_open']     = '<li>';
    $config['num_tag_close']    = '</li>';
    $config['cur_tag_open']     = '<li class="active"><a href="">';
    $config['cur_tag_close']    = '</a></li>';
    $config['next_tag_open']    = '<li>';
    $config['next_tag_close']   = '</li>';
    $config['prev_tag_open']    = '<li>';
    $config['prev_tag_close']   = '</li>';
    $config['last_tag_open']    = '<li>';
    $config['last_tag_close']   = '</li>';
    $config['first_tag_open']   = '<li>';
    $config['first_tag_close']  = '</li>';


    $config["per_page"]         = 10;

    $start = ($this->uri->segment(3) !== false ? $this->uri->segment(3) : 0);
    if ($start = array_search( 'pagina', $this->uri->segments)){
       $config['uri_segment'] = $start + 1;
       $start = $this->uri->segment( $config['uri_segment'] );
    }else{
      $start = 0;
    }




    $config['base_url'] = base_url().$pagination_url.'pagina/';
    $config['total_rows'] =  $this->admin_model->get_reportes_count($config['per_page'], 0,$this->session->filtros);





    $this->pagination->initialize($config);

    $data['total_rows'] = $config["total_rows"]  ;
    $data['count_start'] = $start;


    $data["pagination_links"] = $this->pagination->create_links();


    $data['print']= "";

       if ( $this->input->post('imprimir') ){
            $config["per_page"] =0;
       $data['print']= '<script>$(function(){
                                    window.print();
                                    setTimeout("redir()",500);
                        });
                        function redir(){
                          location.assign("'. site_url("administracion/listado") .'");
                        }
                        </script>';
        }elseif( $this->input->post('exportar') ){
            if (ob_get_level()) {
                ob_end_clean();
            }
            $filename = "reportes_".date('Y-m-d H:i:s');
            header("Content-type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;Filename=\"".$filename.".xls\"");
            header( "Pragma: no-cache" );
            header( "Expires: 0" );

            flush(); //hago esto para q empiece la descarga


            $config["per_page"] = 100;
            $last_id = 0;
            $continue = true;
            $lap = 1;
            while($continue){
                $data = $this->admin_model->get_reportes($config['per_page'], $start,$this->session->filtros, TRUE, TRUE, false, 'desc', $last_id);

                if(!$data){
                    $continue = false;

                    break;
                }else{
                    $last_id = $data[count($data) - 1]['id'];
                }
                if($lap == 1){
                    $headers = '';
                    foreach ($data[0] as $field => $name) {
                        $headers .= $field . "\t";
                    }

                    echo mb_convert_encoding("$headers\n",'utf-16','utf-8');
                }


                foreach($data as $row){
                    //$row['Categoría'] = $this->reportes_model->obtener_nombre_categoria($row['Categoría'], TRUE);
                    //switch ( $row['Estado']) {
                    //    case '1':
                    //        $row['Estado'] = 'Reportado';
                    //        break;
                    //    case '2':
                    //        $row['Estado'] = 'En proceso';
                    //        break;
                    //     case '3':
                    //        $row['Estado'] = 'Finalizado';
                    //        break;
                    //     case '0':
                    //        $row['Estado'] = 'Sin procesar';
                    //        break;
                    //}
                    $row['link Mapa'] = 'http://maps.google.com/maps?q=loc:'.$row['LATITUD'].','.$row['LONGITUD'];

                    $line = '';
                    foreach($row as $value) {
                         if ((!isset($value)) OR ($value == "")) {
                              $value = "\t";
                         } else {
                              $value = str_replace('"', '""', $value);
                              $value = '"' . $value . '"' . "\t";
                         }
                         $line .= $value;
                     }
      //               $data .= trim($line)."\n";
                     $line = trim($line)."\n";
                     echo mb_convert_encoding(str_replace("\r","",$line),'utf-16','utf-8');
                }

                flush();
                $lap++;
            }

//            to_excel(   $data  , "reportes_".date('Y-m-d H:i:s') );
            return false;
        }

      if(  $filtro_campo){
           $data['results'] = $this->admin_model->get_reportes($config['per_page'], $start,$this->session->filtros, FALSE, FALSE, $filtro_campo, $filtro_orden);
      } else{
           $data['results'] = $this->admin_model->get_reportes($config['per_page'], $start,$this->session->filtros);
      }

      $data['categorias'] = $this->admin_model->obtener_categorias_activas();


$this->load->view('admin/template/header',$data);
$this->load->view('admin/listado2');
$this->load->view('admin/template/footer');
}


function check_pass($password){
   $username = $this->session->userdata('user_email');
   if (!$this->simpleloginsecure->login($username,$password))
   {
      $this->form_validation->set_message('check_pass', 'Error, contraseña incorrecta');
      return FALSE;
  }
  else
  {
    return TRUE;
}
}


function cambiar_categoria($reporte_id = 0, $categoria_id = 0){
//    $reporte_id = $this->post->input('reporte_id');
//    $categoria_id = $this->post->input('categoria_id');

    $this->load->library('user_agent');

    $this->admin_model->set_reporte_categoria($reporte_id, $categoria_id);

    redirect($this->agent->referrer());
}

function ajax_ficha_reporte($reporte_id){

    if(!$this->session->userdata('logged_in')) {
                    //Lo redirijo al login
        echo '<h4>Por favor acceda al sistema haciendo clic <a href="'.site_url("administracion/login").'">acá (+)</a></h4>';
        die;
    }
    $reporte = $this->admin_model->get_reporte($reporte_id);

    $data_view = array();
    $data_view['categorias'] = $this->admin_model->obtener_categorias_activas();

    $data_view['usuario'] = $reporte[0];
    $data_view['categoria_actual'] = $this->admin_model->get_categoria_by_id($reporte[0]->categoria);
    $data_view['categoria_actual'] = $data_view['categoria_actual'][0];
//    echo '<pre>';
//    var_dump($data_view);
//    die;

    $this->load->view('admin/ajax_ficha_reporte',$data_view); //array('usuario'=>$reporte[0]));
}

function ajax_set_reporte_status($estado = 0, $reporte_id = 0){

    if(!$this->session->userdata('logged_in')) {
            //Lo redirijo al login
        redirect('adminsitracion');
    }


    $data = $this->admin_model->update_estado($estado, $reporte_id);


    if(!empty($data)){
        echo '1';
    }

}
function ajax_set_reporte_oculto($estado = 0, $reporte_id = 0){

    if(!$this->session->userdata('logged_in')) {
            //Lo redirijo al login
        redirect('adminsitracion');
    }


    $data = $this->admin_model->update_oculto($estado, $reporte_id);


    if(!empty($data)){
        echo '1';
    }

}

/*Accesos directos con hash*/
/* hash_reporte: SHA1(CONCAT_WS(':', id, fecha)*/


    function ficha_reporte( $hash = false ){

        if( !$hash){
          die('No autorizado');
      }

      if( $reporte_id = $this->admin_model->hash_exist( $hash ) ){

        $reporte = $this->admin_model->get_reporte($reporte_id);
        $this->load->view('admin/template/header');
        $this->load->view('admin/ficha_reporte',array('usuario'=>$reporte[0], 'hash' => $hash));
        $this->load->view('admin/template/footer');
    }else{
        die('No autorizado');
    }

    }


    function set_reporte_status($estado = 0, $hash){

    if( $reporte_id = $this->admin_model->hash_exist( $hash ) ){

        $data = $this->admin_model->update_estado($estado, $reporte_id);


        if(!empty($data)){
            redirect( 'administracion/ficha_reporte/'.$hash );
        }
    }
     die('No autorizado');


}



}


if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
                );
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
            ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
        return false;
    }
    if (isset($params[2])
        && !is_int($params[2])
        && !is_float($params[2])
        && !is_string($params[2])
        && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
        trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
    return false;
}
$paramsInput = $params[0];
$paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
$paramsIndexKey = null;
if (isset($params[2])) {
    if (is_float($params[2]) || is_int($params[2])) {
        $paramsIndexKey = (int) $params[2];
    } else {
        $paramsIndexKey = (string) $params[2];
    }
}
$resultArray = array();
foreach ($paramsInput as $row) {
    $key = $value = null;
    $keySet = $valueSet = false;
    if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
        $keySet = true;
        $key = (string) $row[$paramsIndexKey];
    }
    if ($paramsColumnKey === null) {
        $valueSet = true;
        $value = $row;
    } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
        $valueSet = true;
        $value = $row[$paramsColumnKey];
    }
    if ($valueSet) {
        if ($keySet) {
            $resultArray[$key] = $value;
        } else {
            $resultArray[] = $value;
        }
    }
}
return $resultArray;
}
}
