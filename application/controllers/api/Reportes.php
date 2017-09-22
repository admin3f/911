<?php

defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';


class Reportes extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    
        $this->load->model('admin_model');
        $this->load->model('reportes_model');


       // $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
       // $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
       // $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function reporte_get()
    {
        

        if(!$this->get('id'))
        {
            $response['status'] = 'failed';
            $response['errors'] = array( 'id' => 'El campo id es oblgatorio') ;
            $this->response( $response, 400);

        }else{

            $reporte = $this->admin_model->get_reporte( (int)$this->get('id') );
             
            if($reporte)
            {
                $this->response($reporte, 200); // 200 being the HTTP response code
            }
            else
            {

                $this->response( NULL, 404);
            }            
        }
 

    }

    public function reportes_get()
    {
       
        //Filtros: estado , categoria, limit, last_id
         $response['errors'] =  NULL;
        if(!$this->get('estado')){
            $estado = FALSE;
        }else{
            $estado = (int)$this->get('estado');

            if( $estado < 0 || $estado > 4){
                
                $response['errors']['estado'] = 'Estado no encontrado';
       
            }             
        }



        if(!$this->get('categoria')){
            $categoria = FALSE;
        }else{
             $categoria = (int)$this->get('categoria');
      
            if( $categoria < 0 || $categoria > 6){
      
                $response['errors']['categoria'] = 'Categoría no encontrada' ;
            }
        }      
        
        if( !empty($response['errors']) ){

            $response['status'] = 'failed';
            $this->response($response, 400);
        }

        if(!$this->get('last-id')){
            $last_id = '0';
        }else{
             $last_id =$this->get('last-id');
        }

        if(!$this->get('limit')){
            $limit = '1000';
        }else{
             $limit =$this->get('limit');
        }

        if(!$this->get('dias')){
            $dias =  date('Y-m-d 00:00:00', strtotime("-14 days")); 
        }else{
            $dias =$this->get('dias');
            $dias =  date('Y-m-d 00:00:00', strtotime("-$dias days")); 
             
        }

         $result = $this->reportes_model-> obtener_reportes( 
            $dias, 
            $lat = FALSE, 
            $lng = FALSE, 
            0, 
            $categoria, 
            FALSE, 
            $estado, 
            FALSE,
            $last_id,
            $limit 
        );

         if(!$result){
            $response['status'] = 'failed';
            $this->response($result, 200);
         }else{
            $this->response( $result, 200);            
         }




        
    }


    public function reporte_post()
    {


        $uniq_name= uniqid();
        $config['upload_path'] = './assets/subidas/';
        $config['allowed_types'] = 'gif|jpg|jpeg|bmp|pjpeg|png';
        $config['file_name'] = $uniq_name;
        $this->load->library('upload', $config);     

        $this->load->library('form_validation');



        $this->form_validation->set_rules('direccion', 'Dirección', 'trim|required|callback_direccion_check');
        $this->form_validation->set_rules('lat', 'Longitud y latitud', 'trim');
        $this->form_validation->set_rules('lng', 'Longitud y latitud', 'trim');
        $this->form_validation->set_rules('texto', 'Descripción', 'trim|required');      
        $this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');      
        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required');      
        $this->form_validation->set_rules('apellido', 'Apellido', 'trim|required');      
        $this->form_validation->set_rules('dni', 'Documento', 'trim|required|numeric|min_length[6]|max_length[8]');
        $this->form_validation->set_rules('genero', 'Genero', 'trim|required');
        $this->form_validation->set_rules('celular_area', 'Aréa', 'trim|required|numeric|min_length[2]|max_length[4]');
        $this->form_validation->set_rules('celular', 'Celular', 'trim|required|numeric|min_length[6]|max_length[8]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
        $this->form_validation->set_rules('categoria', 'Categoria', 'required');
        $this->form_validation->set_rules('imagen', 'Foto', 'callback_foto_check');
        $this->form_validation->set_error_delimiters('','');
        
        
        if ($this->form_validation->run() == FALSE)
        {
            $error=NULL;
            $post = $this->post();
            if( empty($post)){
                $error = array( 'error'=>'No se enviarón datos');
            }
            
            if($this->form_validation->error('direccion')){
                $error['direccion'] = $this->form_validation->error('direccion');
            }
            if($this->form_validation->error('lat')){
                $error['lat'] = $this->form_validation->error('lat');
            }

            if($this->form_validation->error('lng')){
                $error['lng'] = $this->form_validation->error('lng');    
            }
            
            if($this->form_validation->error('texto')   ){
             $error['texto'] = $this->form_validation->error('texto'); 
            }
            if($this->form_validation->error('titulo')){
             $error['titulo'] = $this->form_validation->error('titulo');   
            }
            if( $this->form_validation->error('nombre') ){
             $error['nombre'] = $this->form_validation->error('nombre');
            }
            if( $this->form_validation->error('apellido') ){
             $error['apellido'] = $this->form_validation->error('apellido');
            }
            if( $this->form_validation->error('dni') ){
             $error['dni'] = $this->form_validation->error('dni');
            }
            if( $this->form_validation->error('genero') ){
             $error['genero'] = $this->form_validation->error('genero');
            }
            if( $this->form_validation->error('celular_area') ){
             $error['celular_area'] = $this->form_validation->error('celular_area');
            }
            if( $this->form_validation->error('celular') ){
             $error['celular'] = $this->form_validation->error('celular');
            }
            if( $this->form_validation->error('email') ){
             $error['email'] = $this->form_validation->error('email');
            }
            if( $this->form_validation->error('imagen') ){
             $error['imagen'] = $this->form_validation->error('imagen');
            }
            if( $this->form_validation->error('categoria') ){
             $error['categoria'] = $this->form_validation->error('categoria');
            }
            
            $response['status'] = 'failed';
            $response['errors'] = $error;

            $this->response($response,400);
       

        }else{
   
   
            if( !empty($_FILES['imagen'])){

           
                if($_FILES['imagen']['error'] == 0){
                                        
                    $imagen  = $this->upload->data('file_name');
                   
                    $this->load->library('image_lib');

                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/subidas/'.$imagen;
                    $config['maintain_ratio'] = TRUE;
                    $config['quality'] = '60';
                    $config['width'] = 1024;
                    $config['height'] = 768;
                    $this->image_lib->initialize($config);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $config1['image_library'] = 'gd2';
                   
                    $config1['source_image'] = './assets/subidas/'.$imagen;
                    $config1['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                 
                    $config1['new_image']='./assets/subidas/thumbs/';
                    $config1['width'] = 200;
                    $config1['height'] = 150;
                    $this->image_lib->initialize($config1);
                    $this->image_lib->resize();
                    $this->image_lib->clear();


                }else{
                    $imagen = NULL;
                }
            }else{
                 $imagen = NULL;
            }   

            if(!$this->post('estado')){
                $estado = 1;
            }else{
                $estado = $this->post('estado');
            }
            
            $localidad = (!$this->post('localidad')) ? null : $this->post('localidad');
            $calle = (!$this->post('calle')) ? null : $this->post('calle');
            $altura = (!$this->post('altura')) ? null : $this->post('altura');
            
            $result = $this->reportes_model->nuevo_reporte( 
                array(
                      'lng' => $this->post('lng'),
                      'lat' => $this->post('lat'),
                      'direccion' => $this->post('direccion'),
                      'localidad' => $localidad,
                      'calle' => $calle,
                      'altura' => $altura,
                      'texto' => $this->post('texto'),
                      'titulo' => $this->post('titulo'),
                      'imagen' =>  $imagen,
                      'estado' => $estado, 
                      'categoria' => $this->post('categoria'),
                      'origen' => '1'

                    ),
                array(
                      'email' => $this->post('email'),
                      'genero' => $this->post('genero'),
                      'dni' => $this->post('dni'),
                      'celular_area' => $this->post('celular_area'),
                      'celular' => $this->post('celular'),
                      'nombre' => $this->post('nombre'),
                      'apellido' => $this->post('apellido')
                    )
            );


             
            if($result === FALSE)
            {
                $this->response(array('status' => 'failed'), 500);
            }
             
            else
            {
                $resp['status'] =  'success';
                $resp['img'] =  $imagen;
                $resp['id'] =  $result;

                $this->response($resp, 201);
            }         
        }



    }    
      
    public function direccion_check()
    {   
        if ( $this->input->post('lat') == '' ||
            $this->input->post('lng') == '')
        {
            $this->form_validation->set_message('direccion_check', 'La dirección no es correcta');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    public function foto_check()
    {   
        if( isset($_FILES['imagen'])){


            if( $_FILES['imagen']['error'] == 0 ){


                //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA UPLOAD_VIEW
                //var_dump($this->upload->do_upload('imagen')); die;
                if (!$this->upload->do_upload('imagen')) {
                    $this->form_validation->set_message('foto_check', $this->upload->display_errors());
                    return FALSE;       
                }
                else 
                {
                         

                    return TRUE;
                }
            }else{

                    $this->form_validation->set_message('foto_check',  'No se pudo cargar la foto');
                    return FALSE;     
         
            }
        }
        return TRUE;            
        
    }

    public function reporte_delete()
    {
        $id = (int) $this->get('id');

  

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = array(
            'id' => $id,
            'message' => 'Deleted the resource'
        );

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}


