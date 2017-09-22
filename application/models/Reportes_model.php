<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_model extends CI_Model {

  function __construct()
  {
      parent::__construct();
      $this->load->database('default');
  }

  public function del_ampliacion($id) {

      $this->db->where('id', $id);
      return $this->db->delete('reportes_ampliaciones');

  }

  public function get_ampliaciones($reporte_id) {
      $this->db->order_by('fecha', 'asc');
      $this->db->where('reporte_id', $reporte_id);
      return $this->db->get('reportes_ampliaciones')->result();

  }

  public function add_ampliacion($texto, $user_id, $reporte_id) {
      $data = array(
        'texto'=>$texto,
        'fecha'=>date('Y-m-d H:i:s'),
        'user_id'=>$user_id,
        'reporte_id'=>$reporte_id
      );

      return $this->db->insert('reportes_ampliaciones', $data);
  }

  function obtener_reportes( $tiempo= FALSE, $lat = FALSE, $lng = FALSE, $distancia = 100, $categoria_id = FALSE, $subcategoria_id = FALSE, $estado = FALSE, $oculto = FALSE, $desde = 0, $limit = FALSE)
  {

//  	if( $lat && $lng ){
//  		$categoria = '';
//  		if( $categoria_id )
//  			 $categoria = "AND categoria = $categoria_id";
//  		$subcategoria = '';
//  		if( $subcategoria_id )
//  			$subcategoria_id = "AND subcategoria_id = $subcategoria_id";
//      if( $tiempo)
//          $tiempo = "AND fecha > $tiempo";
//      if( $estado)
//          $estado = "AND estado = $estado";
//      if( $oculto)
//          $estado = "AND oculto = $oculto";
//      if( $desde)
//          $desde = "AND id > $desde";
//
//	   $sql = sprintf("SELECT id, titulo, texto, imagen, categoria, estado, direccion, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( latitud ) ) * cos( radians( longitud ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( latitud ) ) ) )
//	    	AS distance FROM reportes WHERE  lat != '' AND  lng != '' '%s' '%s' HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
//					$this->db->escape( $center_latitud),
//					$this->db->escape( $center_longitud),
//					$this->db->escape( $center_latitud),
//					$this->db->escape( $categoria),
//					$this->db->escape( $subcategoria),
//					$this->db->escape( $radius)
//					);
//	    $this->db->query( $sql );
//
//
//  	}else{
//
//        $this->db->select('id, titulo, texto, imagen, categoria, estado, direccion, lat, lng');
//        $this->db->from('reportes');
//
//        if( $categoria_id )
//          $this->db->where('categoria',$categoria_id);
//        if( $subcategoria_id )
//          $this->db->where('subcategoria',$subcategoria_id );
//        if( $tiempo)
//          $this->db->where('fecha >', $tiempo);
//        if( $estado)
//           $this->db->where('estado', $estado);
//        if( $oculto)
//             $this->db->where('oculto', $oculto);
//        if( $desde)
//            $this->db->where('id >', $desde);
//        if( $limit)
//            $this->db->limit($limit);
//  	}
//
//    $this->db->where('estado <>', '-1');
//     $this->db->where('oculto', '0');
      $this->db->from("reportes");
    $query = $this->db->get();


    return $query->result();

}

  public function get_zonas(){
    $this->db->from("zonas");
    $this->db->order_by("orden", "asc");
    $zonas = $this->db->get()->result_array();
    return $zonas;
  }

  public function get_eventos(){
    $this->db->from("eventos");
    $this->db->order_by("nombre", "asc");
    $eventos = $this->db->get()->result_array();
    
    return $eventos;
  }

  function nuevo_usuario($usuario){
    $u = $this->existe_usuario($usuario);

    $usuario['fecha_actualizacion'] = date('Y-m-d H:i:s');
    if( $u == null  ){
      $usuario['fecha_creacion'] = $usuario['fecha_actualizacion'];
      if($this->db->insert('usuarios', $usuario))
        return $this->db->insert_id();
    }else{
        $this->db->where('id', $u->id);
        if($this->db->update('usuarios', $usuario))
          return $u->id;
      }

    return false;
  }

  function nuevo_reporte( $datos )
  {


    $this->db->cache_delete_all();


    //$datos['fecha'] = date('Y-m-d H:i:s');
    $datos['fecha'] = join("-", array_reverse(explode("-", $datos['fecha'])));
    $a = $this->db->insert('reportes', $datos);
//    echo $this->db->last_query();
    if($a){
      return $this->db->insert_id();
    }else{
      return null;
    }
  }
  function editar_reporte($id,$datos )
  {

    $this->db->cache_delete_all();

    //if(isset($datos['fecha'])) $datos['fecha'] = join("-", array_reverse(explode("-", $datos['fecha'])));

    $this->db->where('id', $id);
    $a = $this->db->update('reportes', $datos);
//    echo $this->db->last_query();
    return $a;
  }

  function existe_usuario($usuario)
  {
        $this->db->select('id');
        $this->db->from('usuarios');
        $this->db->where('dni', $usuario['dni']);
        $this->db->where('genero', $usuario['genero']);

        $query = $this->db->get();


       return $query->first_row();
  }

  function obtener_usuario($id_usuario)
  {
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('id', $id_usuario);


        $query = $this->db->get();


       return $query->first_row();
  }

  function obtener_reporte($id_reporte)
  {
        $this->db->select('r.*, concat(u.nombre, ,u.apellido) as usuario, z.nombre as zona, e.nombre as evento');
        $this->db->from('reportes r');
        $this->db->join('users u', 'u.id = r.user_id');
        $this->db->join('zonas z', 'z.id = r.zona_id');
        $this->db->join('eventos e', 'e.id = r.evento_id');
        $this->db->where('r.id', $id_reporte);


        $query = $this->db->get();


       return $query->first_row();
  }



  function obtener_categorias_activas(){

      $this->db->select('*');
      $this->db->from('categorias');
      $this->db->where('activa', '1');
      $query = $this->db->get();

      return $query->result_array();
  }

    function obtener_sub_categorias_activas(){

      $this->db->select('*');
      $this->db->from('sub_categorias');
      $this->db->where('activa', '1');
      $query = $this->db->get();
      return $query->result_array();
  }


  function obtener_categorias(){

      $this->db->select('*');
      $this->db->from('categorias');
      $query = $this->db->get();
      return $query->result_array();
  }

    function obtener_sub_categorias(){

      $this->db->select('*');
      $this->db->from('sub_categorias');
      $query = $this->db->get();
      return $query->result_array();
  }

  function obtener_nombre_categoria( $id_categoria ){

      $this->db->select('nombre');
      $this->db->from('categorias');
    $this->db->where('id', $id_categoria);
      $query = $this->db->get();

       $ret = $query->first_row();
       return $ret->nombre;
  }

    function obtener_users_de_categoria( $id_categoria ){

      $this->db->select('user_email');
      $this->db->from('users');
      $this->db->like('categories', $id_categoria);
      $query = $this->db->get();
      return $query->result_array();
  }

  public function get_ultimos(){

    $es_admin = $this->session->userdata('es_admin');

    $this->db->select('reportes.id AS id, reportes.direccion AS Dirección,
                                reportes.comentarios AS Descripción,
                                eventos.nombre AS Evento,
                                (CASE eventos.es_delito WHEN 1 THEN "Si" ELSE "No" END) as Delito,
                                zonas.nombre AS Zona,
                                reportes.fecha AS Fecha,
                                reportes.hora,
                                reportes.interseccion,
                                reportes.imputado_apellido,
                                reportes.victima_apellido,
                                CONCAT(users.nombre, " ", users.apellido) as Usuario');

    $this->db->from('reportes');
    $this->db->join('users', 'reportes.user_id = users.id');
    $this->db->join('zonas', 'reportes.zona_id = zonas.id', 'left');
    $this->db->join('eventos', 'reportes.evento_id = eventos.id', 'left');

    if(!$es_admin){
        $this->db->where('reportes.user_id', $this->session->userdata('user_id'));
    }

    $this->db->order_by('id', 'desc');
    $this->db->limit(5);
    return $this->db->get()->result_array();

  }

}
