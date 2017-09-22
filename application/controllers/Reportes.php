<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reportes extends CI_Controller {


	function __construct()
  	{
            parent::__construct();
            $this->load->model('reportes_model');

            if(!$this->session->userdata('user_id')){
                redirect('/administracion/login');
            }
  	}

        function listado(){

            $this->load->model('admin_model');
            error_reporting(E_ALL);
            set_time_limit(0);

            $this->load->helper('mysql_to_excel_helper');
            $this->load->helper('form');

            $this->load->library('pagination');

            $data['autorizado'] = FALSE;
            $config = array();

           $filtro_campo = FALSE;
           $pagination_url = '/reportes/listado/';

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
                                  location.assign("'. site_url("reportes/listado") .'");
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
                            $row['Link Mapa'] = 'http://maps.google.com/maps?q=loc:'.$row['Latitud'].','.$row['Longitud'];

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

        $data['zonas'] = $this->reportes_model->get_zonas();
        $data['eventos'] = $this->reportes_model->get_eventos();

        $data['filtros'] = $this->session->filtros;
//        echo '<pre>';
//        var_dump($data['results']);
//        die;
        $this->load->view('admin/template/header',$data);
		$this->load->view('template/navbar');
        $this->load->view('reportes/listado');
        $this->load->view('admin/template/footer');
        }



        public function guardar(){
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');



                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('reporte_error', 'La informacion en el formulario es incompleta');
//			$this->load->view('template/header', $data);
//			$this->load->view('template/navbar');
//			$this->load->view('portada');
//			$this->load->view('template/footer');
		}else{

//                    $reporte = array();
//                    $reporte['lat'] = (float)$this->input->post('latReportes');
//                    $reporte['lng'] = (float)$this->input->post('lngReportes');
//                    $reporte['direccion'] = $this->input->post('direccionReporte');
//                    $reporte['fecha'] = $this->input->post('fecha');
//                    $reporte['hora'] = $this->input->post('horaReporte');
//                    $reporte['zona_id'] = $this->input->post('zonaReporte');
//                    $reporte['evento_id'] = $this->input->post('eventoReporte');
//                    $reporte['interseccion'] = $this->input->post('interseccionReporte');
////                    $reporte['es_delito'] = (isset($_POST['esDelitoReporte']) ? 1 : 0);
//                    $reporte['comentarios'] = $this->input->post('comentariosReporte');
////                    $reporte['ampliacion1'] = $this->input->post('ampliacion1Reporte');
////                    $reporte['ampliacion2'] = $this->input->post('ampliacion2Reporte');
//
//                    $reporte['imputado_nombre'] = $this->input->post('imputado_nombre');
//                    $reporte['imputado_apellido'] = $this->input->post('imputado_apellido');
//                    $reporte['imputado_dni'] = $this->input->post('imputado_dni');
//
//                    $reporte['victima_nombre'] = $this->input->post('victima_nombre');
//                    $reporte['victima_apellido'] = $this->input->post('victima_apellido');
//                    $reporte['victima_dni'] = $this->input->post('victima_dni');

					$reporte = $_POST;
					//checkbox
					$reporte['privacion_libertad'] = (isset($_POST['privacion_libertad']) ? 1 : 0);
					$reporte['con_autores'] = (isset($_POST['con_autores']) ? 1 : 0);
					$reporte['menores_edad'] = (isset($_POST['menores_edad']) ? 1 : 0);
					$reporte['armas'] = (isset($_POST['armas']) ? 1 : 0);
					$reporte['ambulancia'] = (isset($_POST['ambulancia']) ? 1 : 0);

                    $reporte['user_id'] = $this->session->userdata('user_id');

                    if($id_reporte = $this->reportes_model->nuevo_reporte( $reporte ) ){
                            //redirect('reportes/cargado');
                            $this->session->set_flashdata('reporte_success', 'Los datos fueron cargados exitosamente!');

                    }else{
                        $this->session->set_flashdata('reporte_error', 'Hubo un problema al cargar los datos');

//                             $this->load->view('template/header', $data);
//                             $this->load->view('template/navbar');
//                             $this->load->view('portada');
//                             $this->load->view('template/footer');
                    }

		}
//                die;
                redirect('reportes/cargar');
        }

        public function guardar_edit($id){
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('direccion', 'Dirección', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                    $this->session->set_flashdata('reporte_error', 'La informacion en el formulario es incompleta');
//			$this->load->view('template/header', $data);
//			$this->load->view('template/navbar');
//			$this->load->view('portada');
//			$this->load->view('template/footer');
		}else{

//                    $reporte = array();
//                    $reporte['lat'] = $this->input->post('latReportes');
//                    $reporte['lng'] = $this->input->post('lngReportes');
//                    $reporte['direccion'] = $this->input->post('direccionReporte');
//                    $reporte['fecha'] = $this->input->post('fecha');
//                    $reporte['hora'] = $this->input->post('horaReporte');
//                    $reporte['zona_id'] = $this->input->post('zonaReporte');
//                    $reporte['evento_id'] = $this->input->post('eventoReporte');
//                    $reporte['interseccion'] = $this->input->post('interseccionReporte');
////                    $reporte['es_delito'] = (isset($_POST['esDelitoReporte']) ? 1 : 0);
//                    $reporte['comentarios'] = $this->input->post('comentariosReporte');
////                    $reporte['ampliacion1'] = $this->input->post('ampliacion1Reporte');
////                    $reporte['ampliacion2'] = $this->input->post('ampliacion2Reporte');
//
//                    $reporte['imputado_nombre'] = $this->input->post('imputado_nombre');
//                    $reporte['imputado_apellido'] = $this->input->post('imputado_apellido');
//                    $reporte['imputado_dni'] = $this->input->post('imputado_dni');
//
//                    $reporte['victima_nombre'] = $this->input->post('victima_nombre');
//                    $reporte['victima_apellido'] = $this->input->post('victima_apellido');
//                    $reporte['victima_dni'] = $this->input->post('victima_dni');
//
//                    $reporte['user_id'] = $this->session->userdata('user_id');
//                    $ampliacion = $this->input->post('victima_dni');

					$reporte = $_POST;
					//checkbox
					$reporte['privacion_libertad'] = (isset($_POST['privacion_libertad']) ? 1 : 0);
					$reporte['con_autores'] = (isset($_POST['con_autores']) ? 1 : 0);
					$reporte['menores_edad'] = (isset($_POST['menores_edad']) ? 1 : 0);
					$reporte['armas'] = (isset($_POST['armas']) ? 1 : 0);
					$reporte['ambulancia'] = (isset($_POST['ambulancia']) ? 1 : 0);

                    if($this->reportes_model->editar_reporte( $id, $reporte ) ){
                            //redirect('reportes/cargado');
                            $this->session->set_flashdata('reporte_success', 'El reporte fue guardado exitosamente!');

                    }else{
                        $this->session->set_flashdata('reporte_error', 'Hubo un problema al cargar los datos');

//                             $this->load->view('template/header', $data);
//                             $this->load->view('template/navbar');
//                             $this->load->view('portada');
//                             $this->load->view('template/footer');
                    }
                    if(!empty($ampliacion)){
                        $this->reportes_model->add_ampliacion($ampliacion, $reporte['user_id'], $id);
                    }

		}
//                die;
                redirect('reportes/listado');
        }

	public function index()
	{
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
		$this->load->helper('url');
		$this->load->helper('form');

                $data['user_nombre'] = $this->session->userdata('user_nombre');
		//$data['title'] = 'Seguridad | Municipalidad de Tres de Febrero';
		//$data['description'] = '';

                $data['reporte_success'] = $this->session->flashdata('reporte_success');
                $data['reporte_error'] = $this->session->flashdata('reporte_error');

                $data['gracias'] =  false;
//		if($this->uri->segment(2) == 'cargado'){
//			$data['gracias'] =  true;
//			$data['num_reporte'] = $this->uri->segment(3) ;
//		}

//		$data['cargar'] =  false;

//		if($this->uri->segment(2) == 'cargar'){
                $data['cargar'] =  true;

//$data['title'] = 'La Muni en tu barrio | Municipalidad de Tres de Febrero';
		//$data['description'] = 'El sistema de reportes es una propuesta para que los vecinos de cada una de las localidades de Tres de Febrero, tengan la oportunidad de recibir una respuesta concreta a las necesidades cotidianas.';


		if($this->uri->segment(1) == 'centrar' && $this->uri->segment(3) && $this->uri->segment(2)){
		    //centrar
			$data['lat'] = $this->uri->segment(3);
			$data['lng'] = $this->uri->segment(2);

		}
		$data['gracias'] =  false;
		if($this->uri->segment(2) == 'cargado'){
			$data['gracias'] =  true;
			$data['num_reporte'] = $this->uri->segment(3) ;
		}

		$data['cargar'] =  false;

		if($this->uri->segment(2) == 'cargar'){
			$data['cargar'] =  true;


		}

		if($data['cargar']){
			//$data['title'] = 'Carga de reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';
			//$data['description'] = 'Completa los datos para realizar un reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';

		}
//		}

//		if($data['cargar']){
//			$data['title'] = 'Carga de reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';
//			$data['description'] = 'Completa los datos para realizar un reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';
//
//		}


		$data['zonas'] = $this->reportes_model->get_zonas();
		$data['eventos'] = $this->reportes_model->get_eventos();

		$data['mapa_camaras'] = $this->get_mapa_camaras();
		$data['mapa_zonas'] = $this->get_mapa_zonas();

                $this->load->view('template/header', $data);
                //$this->load->view('template/navbar');
                $this->load->view('reportes/crear');
                $this->load->view('template/footer');
	}

        public function del_ampliacion($id, $reporte_id) {

            $this->reportes_model->del_ampliacion($id);

            redirect('reportes/editar/'.$reporte_id);
        }



	public function editar($id)
	{
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $this->load->helper('url');
            $this->load->helper('form');

            $data['id'] = $id;
            $data['reporte'] = $this->reportes_model->obtener_reporte($id);

            $data['reporte']->ampliaciones = $this->reportes_model->get_ampliaciones($data['reporte']->id);

            $data['user_nombre'] = $this->session->userdata('user_nombre');
            //$data['title'] = 'Seguridad | Municipalidad de Tres de Febrero';
            //$data['description'] = '';

            $data['reporte_success'] = $this->session->flashdata('reporte_success');
            $data['reporte_error'] = $this->session->flashdata('reporte_error');

            $data['gracias'] =  false;
            $data['cargar'] =  true;

            if($this->uri->segment(1) == 'centrar' && $this->uri->segment(3) && $this->uri->segment(2)){
                //centrar
                    $data['lat'] = $this->uri->segment(3);
                    $data['lng'] = $this->uri->segment(2);
            }

            $data['gracias'] =  false;
            if($this->uri->segment(2) == 'cargado'){
                    $data['gracias'] =  true;
                    $data['num_reporte'] = $this->uri->segment(3) ;
            }

            $data['cargar'] =  false;

            if($this->uri->segment(2) == 'cargar'){
                $data['cargar'] =  true;
            }

            if($data['cargar']){
                $data['title'] = 'Carga de reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';
                $data['description'] = 'Completa los datos para realizar un reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';

            }
//		}

//		if($data['cargar']){
//			$data['title'] = 'Carga de reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';
//			$data['description'] = 'Completa los datos para realizar un reporte en el sistema de reportes de la Municipalidad de Tres de Febrero';
//
//		}


            $data['zonas'] = $this->reportes_model->get_zonas();
            $data['eventos'] = $this->reportes_model->get_eventos();

			$data['mapa_camaras'] = $this->get_mapa_camaras();
			$data['mapa_zonas'] = $this->get_mapa_zonas();

			$forms = $this->_getForms();
			$form = (empty($forms[$data['reporte']->evento_id])) ? $forms[0] : $forms[$data['reporte']->evento_id];
			$valores = json_decode(json_encode($data['reporte']), true);

			$data['form_reporte'] = $this->_crearForm($form, $valores);

			$this->load->view('template/header', $data);
            //$this->load->view('template/navbar');
            $this->load->view('reportes/editar');
            $this->load->view('template/footer');
	}

	public function acerca(){

		$data['title'] = 'Aceca del sistema de reportes de la Municipalidad de Tres de Febrero';
		$data['description'] = 'El sistema es una propuesta para que los vecinos de cada una de las localidades de Tres de Febrero, tengan la oportunidad de recibir una respuesta concreta a las necesidades cotidianas.';

		$this->load->view('template/header', $data);
		$this->load->view('template/navbar');
		$this->load->view('informacion');

	}

//	public function direccion_check()
//	{
//		if ( $this->input->post('latReportes') == '' ||
// 			$this->input->post('lngReportes') == '')
//		{
//			$this->form_validation->set_message('direccion_check', 'La dirección no es correcta');
//			return FALSE;
//		}
//		else
//		{
//			return TRUE;
//		}
//	}
	public function foto_check()
	{

		if( $_FILES['imagenReporte']['error'] == 0 ){


			//SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
			//var_dump($this->upload->do_upload('imagenReporte')); die;
			if (!$this->upload->do_upload('imagenReporte')) {
				$this->form_validation->set_message('foto_check', $this->upload->display_errors());
				return FALSE;
			}
			else
			{


				return TRUE;
			}
		}else{
			return TRUE;
		}

	}
	public function cargar_reporte()
	{
		redirect('reportes');
		$this->load->helper('form');
		$this->load->library('form_validation');

//		$data['categorias'] = $this->reportes_model->obtener_categorias_activas();
		$data['zonas'] = $this->reportes_model->get_zonas();
		$data['eventos'] = $this->reportes_model->get_eventos();
                echo "<pre>";
                var_dump($data);
                die;

		$this->form_validation->set_rules('direccionReporte', 'Dirección', 'trim|required|callback_direccion_check');
		$this->form_validation->set_rules('latReportes', 'Longitud y latitud', 'trim');
		$this->form_validation->set_rules('lngReportes', 'Longitud y latitud', 'trim');
		$this->form_validation->set_rules('textoReporte', 'Descripción', 'trim|required');
		$this->form_validation->set_rules('tituloReporte', 'Titulo', 'trim|required');
		$this->form_validation->set_rules('nombreReporte', 'Nombre', 'trim|required');
		$this->form_validation->set_rules('apellidoReporte', 'Apellido', 'trim|required');
		$this->form_validation->set_rules('dniReporte', 'Documento', 'trim|required|numeric|min_length[6]|max_length[8]');
		$this->form_validation->set_rules('generoReporte', 'Genero', 'trim|required');
		$this->form_validation->set_rules('celularAreaReporte', 'Aréa', 'trim|required|numeric|min_length[2]|max_length[4]');
		$this->form_validation->set_rules('celularReporte', 'Celular', 'trim|required|numeric|min_length[6]|max_length[8]');
		$this->form_validation->set_rules('emailReporte', 'E-mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('categoriaReporte', 'Categoria', 'required');
		$this->form_validation->set_rules('imagenReporte', 'Foto', 'callback_foto_check');

		$uniq_name= uniqid();
		$config['upload_path'] = './assets/subidas/';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size'] = '2000';
		//$config['max_width'] = '2024';
		//$config['max_height'] = '2008';
		$config['file_name'] = $uniq_name;
		$this->load->library('upload', $config);



		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == FALSE)
        {

			$this->load->view('template/header');
			$this->load->view('cargar_reporte', $data);
			$this->load->view('template/footer');
        }else
		{









	  			$lat = $this->input->post('latReportes');
	  			$lng = $this->input->post('lngReportes');
	  			$direccion = $this->input->post('direccionReporte');
	  			$titulo = $this->input->post('tituloReporte');
	  			$texto = $this->input->post('textoReporte');
	  			$nombre = $this->input->post('nombreReporte');
	  			$apellido = $this->input->post('apellidoReporte');
	  			$dni = $this->input->post('dniReporte');
	  			$celularArea = $this->input->post('celularAreaReporte');
	  			$celular = $this->input->post('celularReporte');
	  			$email = $this->input->post('emailReporte');
	  			$genero = ($this->input->post('generoReporte') == 'f')? 2 : 1;
	  			$categoria =  $this->input->post('categoriaReporte');
	  			if($_FILES['imagenReporte']['error'] == 0){

	  				$imagen  = $this->upload->data('file_name');
	  				$this->_create_thumbnail($imagen);
	  			}else{
	  				$imagen = NULL;
	  			}




				$usuario = array(  'email' => $email,
									'genero' => $genero,
									'dni'  =>  $dni,
									'celular_area' => $celularArea,
									'celular' => $celular,
									'nombre' => $nombre,
									'apellido' => $apellido
								);

				$reporte = array(
									'lng' => $lng,
									'lat' => $lat,
									'direccion' =>  $direccion,
									'texto' => $texto,
									'titulo' => $titulo ,
									'imagen' => $imagen,
									'estado' => '1',
									'fecha_cierre' => NULL,
									'sub_categoria' => NULL,
									'categoria' => $categoria,
								);


				if( $id_reporte = $this->reportes_model->nuevo_reporte( $reporte, $usuario ) ){


					redirect('reportes/cargar');
				}else{
					 $data['error'] = 'No pudimos cargar tu reporte';
					 $this->load->view('template/header');
					 $this->load->view('cargar_reporte', $data);
					 $this->load->view('template/footer');
				}




		}

	}


    function _create_thumbnail($filename){

		$this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/subidas/'.$filename;
        $config['maintain_ratio'] = TRUE;
        $config['quality'] = '60';
        $config['width'] = 1024;
        $config['height'] = 768;
 		$this->image_lib->initialize($config);
 		$this->image_lib->resize();
 		$this->image_lib->clear();

        $config1['image_library'] = 'gd2';

        $config1['source_image'] = './assets/subidas/'.$filename;
        $config1['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;

        $config1['new_image']='./assets/subidas/thumbs/';
        $config1['width'] = 200;
        $config1['height'] = 150;
 		$this->image_lib->initialize($config1);
 		$this->image_lib->resize();
 		$this->image_lib->clear();




    }

	public function listar($tiempo = 30)
	{
		/*Lista en formato json los ultimos reportes
		  $tiempo: cantidad en días
		*/

		$fecha =  date('Y-m-d 00:00:00', strtotime("-$tiempo days"));




		$lista = $this->reportes_model->obtener_reportes($fecha);

		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($lista));


	}
	public function test_email(){


		 $test = $this->reportes_model->obtener_users_de_categoria( 1 );

		 var_dump($test); die;

		$reporte = $this->reportes_model->obtener_reporte(151);

		if( $reporte ){
			$usuario = $this->reportes_model->obtener_usuario( $reporte->id_usuario );
		}


		$datos['reporte'] = $reporte->id;
		$datos['imagen'] = $reporte->imagen;
		$datos['titulo'] = $reporte->titulo;
		$datos['texto'] = $reporte->texto;
		$datos['hash'] = sha1($reporte->id.':'.$reporte->fecha);
		$datos['direccion'] = $reporte->direccion;
		$datos['mapa'] = 'https://www.google.com/maps/place/'.$reporte->lat.','.$reporte->lng;
		$datos['categoria'] = $this->reportes_model->obtener_nombre_categoria($reporte->categoria);
		$datos['usuario'] = $reporte->id_usuario;
		$datos['nombre'] = $usuario->nombre.' '.$usuario->apellido;
		$datos['email'] = $usuario->email;
		$datos['celular'] = $usuario->celular_area.' - '.$usuario->celular;
		$datos['dni'] = $usuario->dni;






		$body = $this->load->view('emails/reporte_nuevo', $datos, TRUE);


		$result = $this->_enviar_correo( $body, 'federoulet@gmail.com',  'Reporte vía web Nº: '.$reporte->id );

		var_dump($result ); die;

	}

	function _enviar_correo( $html, $para,$asunto){


		$this ->load-> library('email');

		$this->email->from('reportes@tresdefebrero.gov.ar', 'Sistema de reportes Municipalidad de Tres de Febrero');

		$this->email->to($para);

		$this->email->subject($asunto);

		$this->email->message($html);


		return  $this->email->send();

	}


        private function get_address_info($lat,$lng)
        {
           $url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.GMAP_GEO_API_KEY.'&latlng='.trim($lat).','.trim($lng).'&sensor=false';
           $json = @file_get_contents($url);
           $data=json_decode($json);
           $status = $data->status;

           $info = array();



           if($status=="OK")
           {
             foreach($data->results[0]->address_components as $item){

                  if(in_array('street_number', $item->types)){
                      $info['numero'] = $item->long_name;
                  }

                  if(in_array('route', $item->types)){
                      $info['calle'] = $item->long_name;
                  }

                  if(in_array('locality', $item->types)){
                      $info['localidad'] = $item->long_name;
                  }

                  if(in_array('administrative_area_level_2', $item->types)){
                      $info['municipio'] = $item->long_name;
                  }



              }

              return $info;
           }
           else
           {

               echo "Problema con ". $url . "\r\n";
             return false;
           }
        }
//        http://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyA0MDWGTVrWBzLeh2CSRX0YtIhKMFQmAJA&latlng=-34.599377,-58.558468&sensor=false

        public function fix_domicilios() {

            $sql = "SELECT * FROM reportes
                    WHERE localidad IS NULL
                    AND lat IS NOT NULL
                    AND geocode_fix = 0
                    LIMIT 1000";

            $items = $this->db->query($sql)->result();
            if(!$items)
                die("No hay items para procesar");

            foreach($items as $reporte){
                $address_info = $this->get_address_info($reporte->lat, $reporte->lng);

                if($address_info && $address_info['municipio'] == 'Tres de Febrero'){

                    $data_update = array(
                        'localidad'=> $address_info['localidad'],
                        'calle'=> $address_info['calle'],
                        'altura'=> $address_info['numero'],
                        'geocode_fix'=>1
                    );

                    echo '<pre>';
                    echo 'ID: ' . $reporte->id;
                    var_dump($data_update);

                    $this->db->where('id', $reporte->id);
                    $this->db->update('reportes', $data_update);
                }else{
                    $data_update = array(
                        'geocode_fix'=>2
                    );
                    $this->db->where('id', $reporte->id);
                    $this->db->update('reportes', $data_update);
                    echo "No proceso la direccion \r\n ";
                }
            }
        }


        public function dataTable() {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        //Important to NOT load the model and let the library load it instead.
        $this -> load -> library('Datatable', array('model' => 'Reportes_dt_model', 'rowIdCol' => 'reportes.id'));

        //format array is optional, but shown here for the sake of example
        $json = $this -> datatable -> datatableJson(
            array(
                'fecha' => 'date',
//                'a_boolean_col' => 'boolean',
//                'a_percent_col' => 'percent',
//                'a_currency_col' => 'currency'
            )
        );

        $this -> output -> set_header("Pragma: no-cache");
        $this -> output -> set_header("Cache-Control: no-store, no-cache");
        $this -> output -> set_content_type('application/json') -> set_output(json_encode($json));

    }

    public function test_listado(){
        $this->load->view('admin/template/header');
        $this->load->view('reportes/listado_a');
        $this->load->view('admin/template/footer');


    }

	public function ajax_get_reporte($id)
	{
		$data["reporte"] = $this->reportes_model->obtener_reporte($id);

		echo $this->load->view('reportes/popup', $data, TRUE);
	}

	public function ajax_get_form($id)
	{
		$forms = $this->_getForms();

		echo (empty($forms[$id])) ? $this->_crearForm($forms[0]) : $this->_crearForm($forms[$id]);
	}

	private function _getForms()
	{
		return json_decode(file_get_contents("assets/forms.txt"), true);
	}

	private function _crearForm($form, $valores = array())
	{
		$html = "";

		foreach($form as $item)
		{
			$html .= "<div class='form-group'>";

			if(isset($item["campos"]))
			{
				if(!empty($item["etiqueta"]))
				{
					$html .= "</div>";
					$html .= "<h5 style='border-bottom: 1px solid rgb(222, 222, 222); color: rgb(119, 119, 119);'>{$item["etiqueta"]}</h5>";
					$html .= "<div class='form-group'>";
				}

				$items = count($item["campos"]);

				foreach($item["campos"] as $sub_item)
				{
					$valor = (empty($valores)) ? "" : $valores[$sub_item["nombre"]];

					$html .= $this->_crearCampo($sub_item, $valor, $items);
				}
			}
			else
			{
				$valor = (empty($valores)) ? "" : $valores[$item["nombre"]];

				$html .= $this->_crearCampo($item, $valor);
			}

			$html .= "</div>";
		}

		return $html;
	}

	private function _crearCampo($campo, $valor = "", $campos = 1)
	{
		//echo "<pre>";
		//print_r($campo);
		//echo "</pre>";
		//die;
		$bootstrap_cols = 12 / $campos;
		$html = "";
		$html .= "<div class='col-md-{$bootstrap_cols}'>";

		switch($campo["tipo"])
		{
			case "texto":
				$html .= "<input value='{$valor}' class='form-control' type='text' id='{$campo["nombre"]}' name='{$campo["nombre"]}' placeholder='{$campo["etiqueta"]}'>";

				break;

			case "libre":
				$html .= "<textarea class='form-control' id='{$campo["nombre"]}' name='{$campo["nombre"]}' placeholder='{$campo["etiqueta"]}'>{$valor}</textarea>";

				break;

			case "combo":
				$html .= "<label class='control-label'>{$campo["etiqueta"]}</label>";
				$html .= "<select class='form-control' id='{$campo["nombre"]}' name='{$campo["nombre"]}'>";

				foreach($campo["valores"] as $valor_option)
				{
					$selected = ($valor_option == $valor) ? "selected" : "";
					$html .= "<option $selected value='{$valor_option}'>{$valor_option}</option>";
				}

				$html .= "</select>";

				break;

			case "si/no":
				$checked = ($valor == 1) ? "checked" : "";
				$html .= "<label class='control-label'>{$campo["etiqueta"]}</label>";
				$html .= "<input $checked class='form-control' type='checkbox' id='{$campo["nombre"]}' name='{$campo["nombre"]}'>";

				break;
		}

		$html .= "</div>";

		return $html;
	}

	private function get_mapa_camaras()
	{
		$kml_path = 'assets/map/camaras.kml';

		$camaras = array();

		//$xml = simplexml_load_file($kml_path);
		$xml = simplexml_load_string(file_get_contents($kml_path));

		$tipos = $xml->Document->Folder;

		foreach($tipos->Folder as $tipo)
		{
			$nombre = (string)$tipo->name;

			foreach($tipo as $camara)
			{
				if(!isset($camara->name)) continue;

				list($lng, $lat) = explode(',', $camara->Point->coordinates);

				$camaras[] = array("tipo" => $nombre, "ubicacion" => (string)$camara->name, "lat" => $lat, "lng" => $lng);
			}
		}

		return json_encode($camaras, JSON_HEX_APOS);
	}

	private function get_mapa_zonas()
	{
		$kml_path = 'assets/map/zonas.kml';

		$zonas = array();

		//$xml = simplexml_load_file($kml_path);
		$xml = simplexml_load_string(file_get_contents($kml_path));


		$placemarks = $xml->Document->Placemark;

		foreach($placemarks as $placemark)
		{
			$nombre = (string)$placemark->name;

			$poligono = $placemark->Polygon->outerBoundaryIs->LinearRing->coordinates;

			$coordinadas = explode(' ', $poligono);

			$poligono = array();

			foreach($coordinadas as $coordinada)
			{
				list($lng, $lat) = explode(',', $coordinada);

				$poligono[] = array("lat" => $lat, "lng" => $lng);
			}

			$zonas[] = array("nombre" => $nombre, "poligono" => $poligono);
		}

		return json_encode($zonas, JSON_HEX_APOS);
	}
}
