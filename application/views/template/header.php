<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo ( isset($title) ? $title : 'Secretaria de Seguridad - Centro de Operaciones y Monitoreo' );?></title>
        <meta name="description" content="<?php echo ( isset($description) ? $description : 'La Muni en tu barrio - Municipalidad de Tres de Febrero' );?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <meta property="og:url" content="<?php echo current_url();?>" />
        <meta property="og:title" content="<?php echo ( isset($title) ? $title : 'La Muni en tu barrio' );?>" />
        <meta property="og:description" content="<?php echo ( isset($description) ? $description : 'La Muni en tu barrio - Municipalidad de Tres de Febrero' );?>" />
        <meta property="og:site_name" content="La Muni en tu barrio - Municipalidad de Tres de Febrero" />
        <meta property="og:image" content="http://reportes.tresdefebrero.gov.ar/assets/img/tres-de-febrero-avanza.png" />
        <meta property="og:type"   content="website" />

        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">

        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-select/css/bootstrap-select.css">

        <script src="<?php echo base_url();?>assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/datepicker/jquery.datetimepicker.css" />
    </head>
    <body>
