<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($title) ? $title.' | MUJ AMS' : '| MUJ AMS' ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="theme-color" content="#dd4b39">
    <!-- Select 2 -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/select2/dist/css/select2.min.css')?>">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/font-awesome/css/font-awesome.min.css')?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/Ionicons/css/ionicons.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('dist/css/AdminLTE.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('dist/css/overrides.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('dist/css/skins/skin-green.min.css')?>">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/morris.js/morris.css')?>">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/jvectormap/jquery-jvectormap.css')?>">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/bootstrap-daterangepicker/daterangepicker.css')?>">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')?>">
    <!-- Data Tables -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico')?>" />
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico')?>" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url('assets/img/favicon.ico')?>" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url('assets/img/favicon.ico')?>" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url('assets/img/favicon.ico')?>" />
    <!-- jQuery 3 -->
    <script src="<?php echo base_url('bower_components/jquery/dist/jquery.min.js')?>"></script>
    <!-- Notify Script -->
    <script src="<?php echo base_url('assets/js/bootstrap-notify.js');?>"></script>
    <!-- PACE -->
    <script src="<?php echo base_url('bower_components/PACE/pace.min.js')?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('plugins/pace/pace.min.css')?>">
    <script>$(document).ajaxStart(function() { Pace.restart(); });</script>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Data Tables -->
    <script src="<?php echo base_url('bower_components/datatables.net/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')?>"></script>

    <!-- Select 2 -->
    <script src="<?php echo base_url('bower_components/select2/dist/js/select2.full.min.js')?>"></script>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">