<!DOCTYPE html>
<html>
<head>
    <?php include_once('includes/header.php'); ?>
</head>
<body>
<div class="main-content-wrapper">
    <div class="login-area">
        <div class="login-header">
            <a href="http://localhost/management/login" class="logo">
                <img src="http://localhost/management/assets/login_page/img/logo.png" height="60" alt="">
            </a>
            <h2 class="title">Manipal University, Jaipur</h2>
        </div>
        <div class="login-content">
            <form method="post" role="form" id="form_login" action="<? echo site_url('login/validate_login')?>">
                <div class="form-group">
                    <input type="email" class="input-field" name="email" placeholder="Email" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" class="input-field" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login<i class="fa fa-lock"></i></button>
            </form>

            <div class="login-bottom-links">
                <a href="<?php echo site_url('login/forgot_password'); ?>" class="link">
                    Forgot Your Password ?
                </a>
            </div>
        </div>
    </div>
    <div class="image-area"></div>
</div>
<?php include_once('includes/footer.php') ?>
<!-- If there is an error in flash_data show that here-->
<?php if ($this->session->flashdata('login_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            title: "<b>Error:</b> ",
            message: '<?php echo $this->session->flashdata('login_error');?>'
        },{
            type: 'danger',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            }
        });
    </script>
<?php } ?>
<?php if ($this->session->flashdata('logout_notification') != '') { ?>
    <script type="text/javascript">
        $.notify({
            title: "<b>Success:</b> ",
            message: '<?php echo $this->session->flashdata('logout_notification');?>'
        },{
            type: 'success',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            }
        });
    </script>
<?php } ?>
</body>
</html>