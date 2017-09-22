<?php 
require(FCPATH.'/system/core/MY_Model.php');
class Reportes_dt_model extends MY_Model implements DatatableModel{


        public function appendToSelectStr() {
                return array(
//                    'city_state_zip' => 'concat(s.s_name, \'  \', c.c_name, \'  \', c.c_zip)'
                );
        }

        public function fromTableStr() {
            return 'reportes r';
        }



        public function joinArray(){
            return array(
              'users u' => 'u.id = r.user_id'
              );
        }

        public function whereClauseArray(){
            return array(
//                'u.id' => $this -> ion_auth -> get_user_id() 
                );
        }
   }