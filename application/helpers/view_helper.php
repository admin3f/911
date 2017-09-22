<?php

function get_ultimos_reportes(){
	$CI =& get_instance();

	$CI->load->model('Reportes_model', 'Reportes_model');
	return $CI->Reportes_model->get_ultimos();
}