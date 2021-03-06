<!DOCTYPE html>
<html>
<head>
    <?php include_once('includes/header.php'); ?>
</head>
<body>
<div class="main-content-wrapper">
    <div class="login-area">
        <div class="login-header">
            <a href="<?php echo site_url('login/forgot_password') ?>" class="logo">
                <img src="<?php echo base_url('assets/img/logo.png')?>" height="60" alt="">
            </a>
            <h2 class="title">Manipal University, Jaipur</h2>
        </div>
        <div class="login-content">
            <form method="post" role="form" id="form_login" action="<?php echo site_url('login/reset_password')?>">
                <div class="form-group">
                    <input type="email" class="input-field" id="email" name="email" placeholder="Email" required autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary">Reset Password<i class="fa fa-unlock"></i></button>
            </form>

            <div class="login-bottom-links">
                <a href="<?php echo site_url('')?>" class="link"><i class="fa fa-lock"></i>Return To Login Page</a>
            </div>
        </div>
    </div>
    <div class="image-area forgot-pass"></div>
</div>
<script>
    $(document).ready(function () {
        $('#email').focus();
    });
</script>
<!-- If there is an error in flash_data show that here-->
<?php if ($this->session->flashdata('reset_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            title: "<b>Error:</b> ",
            message: '<?php echo $this->session->flashdata('reset_error');?>'
        },{
            type: 'danger',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            }
        });
    </script>
<?php } ?>
<?php if ($this->session->flashdata('reset_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            title: "<b>Success:</b> ",
            message: '<?php echo $this->session->flashdata('reset_success');?>'
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