<?php //Only meant for login page ?>
<!-- For responsiveness -->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<!-- For colored status bar on Android -->
<meta name="theme-color" content="#0d1b28" />
<!-- For favicon -->
<link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico')?>" />


<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico')?>" />
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url('assets/img/favicon.ico')?>" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url('assets/img/favicon.ico')?>" />
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url('assets/img/favicon.ico')?>" />
<link rel="apple-touch-icon" href="<?php echo base_url('assets/img/favicon.ico')?>" />
<!-- Stylesheet -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/stylesheets/style.css'); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
<link rel="stylesheet" type="text/css" href="https://necolas.github.io/normalize.css/8.0.0/normalize.css">
<!-- JQuery and custom scripts -->
<script src="<?php echo base_url('assets/js/jquery.js');?>"></script>
<script src="<? echo base_url('assets/js/bootstrap-notify.js');?>"></script>
<script type="text/javascript" src="<? echo base_url('assets/js/script.js')?>"></script>
<!-- Title -->
<title>
    <?php echo isset($title) ? $title." | MUJ AMS" : "| MUJ AMS" ?>
</title>