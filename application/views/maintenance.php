<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($title) ? $title.' | MUJ AMS' : ' | MUJ AMS' ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url('bower_components/Ionicons/css/ionicons.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('dist/css/AdminLTE.min.css') ?>">
    <!-- For favicon -->
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico')?>" />
    <meta name="theme-color" content="#d2d6de">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="lockscreen" id="particles-js" style="user-select: none;">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper" style="margin: unset; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <div class="lockscreen-logo">
        <b>Manipal</b>AMS
    </div>
    <div class="lockscreen-name">Offline for scheduled maintenance.</div>
</div>

<!-- jQuery 3 -->
<script src="<?php echo base_url('bower_components/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- Particles JS -->
<script src="<?php echo base_url('bower_components/particlesjs/particles.min.js') ?>"></script>
<script src="<?php echo base_url('bower_components/particlesjs/app.js') ?>"></script>
</body>
</html>
