<?php

class Admin_model extends CI_Model {

    function __construct()
  {
      parent::__construct();
       $this->load->database('default');
  }

       /*
        status
        * 0 - Sin revisar
        * 1 - Aprobada
        * 2 - En proceso
        * 3 - Finalizado
        */

       /**
        * @federico
        * @param type $reporte_id
        * @return boole
        */

        function update_estado($estado, $reporte_id){
            $this->db->cache_delete_all();
            $d = array(
                'estado'=> $estado
            );
            $this->db->where('id', (int)$reporte_id);

           return $this->db->update('reportes', $d);
        }

       /**
        * @federico
        * @param type $reporte_id
        * @return boole
        */

        function descartar($reporte_id){
            $this->db->cache_delete_all();
            $d = array(
                'estado'=> '-1'
            );
            $this->db->where('id', (int)$reporte_id);

           return $this->db->update('reportes', $d);
        }

       /**
        * @federico
        * @param type $reporte_id
        * @return boole
        */

        function update_oculto($estado, $reporte_id){
            $this->db->cache_delete_all();
            $d = array(
                'oculto'=> $estado
            );
            $this->db->where('id', (int)$reporte_id);

           return $this->db->update('reportes', $d);
        }


       /**
        * @federico
        * @param type
        * @return type
        */
        function get_reporte($reporte_id){

            $this->db->select('reportes.origen AS origen, reportes.estado AS estado, reportes.oculto AS oculto, reportes.id AS id, reportes.direccion AS direccion, reportes.titulo AS titulo , reportes.texto  AS texto,
                            reportes.fecha AS fecha, reportes.categoria AS categoria, reportes.imagen,
                              usuarios.nombre AS nombre, usuarios.apellido AS apellido, usuarios.id AS usuario, usuarios.celular_area, usuarios.email , usuarios.celular, usuarios.dni
                              ');
            $this->db->from('reportes');
            $this->db->join('usuarios', 'reportes.id_usuario = usuarios.id and reportes.id='.$reporte_id.'');
            $query = $this->db->get();
            return $query->result();

        }

        function hash_exist(  $hash ){
         $this->db->select('id');
         $this->db->from('reportes');
         $this->db->where("SHA1(CONCAT_WS(':', id, fecha)) =", $hash);
         $query = $this->db->get();

         if( $ret = $query->first_row() ){
            return $ret->id;
         }else{
          return false;
         }




       }


    function get_reportes($pagination, $segment, $filtros, $csv = FALSE, $cache_off = FALSE, $order_by = FALSE, $order_dir = 'desc', $last_id = 0)
    {
        if($cache_off)
        {
            $this->db->cache_off();
        }

        if($csv)
        {
            $this->db->select('reportes.id AS id,
                reportes.fecha AS FECHA,
                reportes.hora AS HORA,
                zonas.nombre AS ZONA,
                eventos.nombre AS EVENTO,
                reportes.direccion AS DIRECCIÓN,
                reportes.interseccion AS INTERSECCIÓN,
                reportes.comentarios AS COMENTARIOS,
                reportes.imputado_nombre AS IMPUTADO_NOMBRE,
                reportes.imputado_apellido AS IMPUTADO_APELLIDO,
                reportes.imputado_dni AS IMPUTADO_DNI,
                reportes.victima_nombre AS VICTIMA_NOMBRE,
                reportes.victima_apellido AS VICTIMA_APELLIDO,
                reportes.victima_dni AS VICTIMA_DNI,
                reportes.marca AS MARCA,
                reportes.modelo AS MODELO,
                reportes.color AS COLOR,
                reportes.dominio AS DOMINIO,
                reportes.detalle_vehiculo AS DETALLE_VEHICULO,
                reportes.cant_nn AS CANT_NN,
                reportes.vehiculo_apoyo AS VEHICULO_APOYO,
                reportes.lugar_fuga AS LUGAR_FUGA,
                (CASE reportes.privacion_libertad WHEN 1 THEN "Si" ELSE "No" END) as PRIVACION_LIBERTAD,
                reportes.modalidad AS MODALIDAD,
                reportes.vivienda AS VIVIENDA,
                (CASE reportes.con_autores WHEN 1 THEN "Si" ELSE "No" END) as CON_AUTORES,
                reportes.descripcion AS DESCRIPCION,
                (CASE reportes.menores_edad WHEN 1 THEN "Si" ELSE "No" END) as MENORES_EDAD,
                (CASE reportes.armas WHEN 1 THEN "Si" ELSE "No" END) as ARMAS,
                reportes.lesiones AS LESIONES,
                (CASE reportes.ambulancia WHEN 1 THEN "Si" ELSE "No" END) as AMBULANCIA,
                reportes.elementos_sustraidos AS ELEMENTOS_SUSTRAIDOS,
                reportes.intervencion AS INTERVENCION,
                users.nombre AS USUARIO_NOMBRE,
                users.apellido AS USUARIO_APELLIDO,
                reportes.lat AS LATITUD,
                reportes.lng AS LONGITUD
            ');
        }
        else
        {
            $this->db->select('reportes.id AS id,
                reportes.fecha AS Fecha,
                reportes.hora AS Hora,
                zonas.nombre AS Zona,
                eventos.nombre AS Evento,
                reportes.direccion AS Dirección,
                reportes.comentarios AS Comentarios,
                (CASE eventos.es_delito WHEN 1 THEN "Si" ELSE "No" END) as Delito,
                CONCAT(users.nombre, " ", users.apellido) as Usuario
            ');
        }

        $this->db->from('reportes');
        $this->db->join('users', 'reportes.user_id = users.id');
        $this->db->join('zonas', 'reportes.zona_id = zonas.id', 'left');
        $this->db->join('eventos', 'reportes.evento_id = eventos.id', 'left');

        if($order_by)
        {
            $this->db->order_by("reportes." . $order_by, $order_dir);
        }
        else
        {
            $this->db->order_by('reportes.id', 'desc');
        }

        $this->db->limit($pagination, $segment);

        if($last_id > 0)
        {
            if($order_dir == 'desc')
            {
                $this->db->where('reportes.id < ' . $last_id);
            }
        }

        $es_admin = $this->session->userdata('es_admin');

        if(!$es_admin)
        {
            $this->db->where('reportes.user_id', $this->session->userdata('user_id'));
        }

        if(!empty($filtros['fecha_desde']) && !empty($filtros['fecha_hasta']))
        {
            $f_desde = date('Y-m-d H:i:s', strtotime($filtros['fecha_desde'] . ' 00:00:00'));
            $f_hasta = date('Y-m-d H:i:s', strtotime($filtros['fecha_hasta'] . ' 23:59:59'));
            $this->db->where('reportes.fecha >= ',$f_desde);
            $this->db->where('reportes.fecha <= ',$f_hasta);
        }

        if(!empty($filtros['buscar']))
        {
            $this->db->like('users.user_email', $filtros['buscar'], 'both');
            $this->db->or_like('LOWER(users.nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(users.apellido)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('reportes.id', $filtros['buscar'], 'both');

            $this->db->or_like('LOWER(reportes.direccion)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.localidad)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.calle)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.altura)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.comentarios)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.ampliacion1)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.ampliacion2)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.interseccion)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.imputado_nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.imputado_apellido)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.imputado_dni)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.victima_nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.victima_apellido)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.victima_dni)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.marca)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.modelo)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.dominio)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.detalle_vehiculo)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.vehiculo_apoyo)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.lugar_fuga)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.modalidad)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.vivienda)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.descripcion)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.lesiones)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.elementos_sustraidos)', strtolower($filtros['buscar']), 'both');

            $this->db->or_like('LOWER(zonas.nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(eventos.nombre)', strtolower($filtros['buscar']), 'both');
        }

        if(!empty($filtros['zona_id']))
        {
            $this->db->where_in('reportes.zona_id', join(", ", $filtros['zona_id']));
        }

        if(!empty($filtros['evento_id']))
        {
            $this->db->where_in('reportes.evento_id', join(", ", $filtros['evento_id']));
        }

        $data = $this->db->get()->result_array();

        //echo $this->db->last_query();
        //die;

        if($cache_off)
        {
            $this->db->cache_on();
        }

        return $data;
    }


  function get_categoria_by_id($categoria_id){

      $this->db->select('*');
      $this->db->from('categorias');
      $this->db->where('activa', '1');
      $this->db->where('id', $categoria_id);
      $query = $this->db->get()->result();

      return $query;
  }

  function obtener_categorias_activas(){

      $this->db->select('*');
      $this->db->from('categorias');
      $this->db->where('activa', '1');
      $query = $this->db->get();

      return $query->result_array();
  }


    function get_reportes_count($pagination, $segment, $filtros)
    {
        $this->db->from('reportes');
        $this->db->join('users', 'reportes.user_id = users.id');
        $this->db->join('zonas', 'reportes.zona_id = zonas.id', 'left');
        $this->db->join('eventos', 'reportes.evento_id = eventos.id', 'left');

        $es_admin = $this->session->userdata('es_admin');

        if(!$es_admin)
        {
            $this->db->where('reportes.user_id', $this->session->userdata('user_id'));
        }

        if(!empty($filtros['fecha_desde']) && !empty($filtros['fecha_hasta']))
        {
            $f_desde = date('Y-m-d H:i:s', strtotime($filtros['fecha_desde'] . ' 00:00:00'));
            $f_hasta = date('Y-m-d H:i:s', strtotime($filtros['fecha_hasta'] . ' 23:59:59'));
            $this->db->where('reportes.fecha >= ',$f_desde);
            $this->db->where('reportes.fecha <= ',$f_hasta);
        }

        if(!empty($filtros['buscar']))
        {
            $this->db->like('users.user_email', $filtros['buscar'], 'both');
            $this->db->or_like('LOWER(users.nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(users.apellido)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('reportes.id', $filtros['buscar'], 'both');

            $this->db->or_like('LOWER(reportes.direccion)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.localidad)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.calle)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.altura)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.comentarios)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.ampliacion1)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.ampliacion2)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.interseccion)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.imputado_nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.imputado_apellido)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.imputado_dni)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.victima_nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.victima_apellido)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.victima_dni)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.marca)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.modelo)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.dominio)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.detalle_vehiculo)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.vehiculo_apoyo)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.lugar_fuga)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.modalidad)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.vivienda)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.descripcion)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.lesiones)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(reportes.elementos_sustraidos)', strtolower($filtros['buscar']), 'both');

            $this->db->or_like('LOWER(zonas.nombre)', strtolower($filtros['buscar']), 'both');
            $this->db->or_like('LOWER(eventos.nombre)', strtolower($filtros['buscar']), 'both');
        }

        if(!empty($filtros['zona_id']))
        {
            $this->db->where_in('reportes.zona_id', join(", ", $filtros['zona_id']));
        }

        if(!empty($filtros['evento_id']))
        {
            $this->db->where_in('reportes.evento_id', join(", ", $filtros['evento_id']));
        }

        return $this->db->count_all_results();
    }


  public function set_reporte_categoria($reporte_id, $categoria) {
      $this->db->where('id', $reporte_id);

      $data = array(
          'categoria'=>$categoria
      );

      return $this->db->update('reportes', $data);
  }

  public function get_user($username) {
      $this->db->where('user_email', $username);
      $u = $this->db->get('users')->result();
      return ($u ? $u[0] : false);
  }

}
