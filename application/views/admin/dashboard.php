<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<script>
    $(function () {
        $('ul.sidebar-menu > li:nth-child(2)').addClass('active');
    })

    function updateUserList() {
        // Get current value
        userType = $('#access-role').val();


        if (userType != ''){
            // Send ajax request and dump the user list
            $.ajax({
                url: '<?php echo site_url('ajax/get_users') ?>',
                data: {
                    'ams_ajax': true,
                    'userType': userType
                },
                type: "post",
                success: function (response) {
                    $('#access-user-list').html(response);
                    $('.select2').select2();
                },
                error: function () {
                    alert ('Server error occurred');
                }
            });
        }
    }

    function togglePassword(){
        const elem = $('#default-password');

        if (elem.prop('type') === 'text'){
            elem.prop('type', 'password');
        }
        else {
            elem.prop('type', 'text');
        }
    }

    $(document).ready(function () {
        $('#site-offline-select').val('<?php echo $this->crud_model->get_config('site_offline')?>');
    });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Admin Dashboard
            <small>MUJ AMS</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
        // If site is offline display a message to the admin
        if ($this->crud_model->get_config('site_offline') == 'yes'){ ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-danger text-bold" style="text-transform: uppercase;">
                    Please Note: Site is offline for parents and students.
                </div>
            </div>
        </div>
        <?php }
        ?>
        <div class="row">
            <div class="col-sm-9">
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-xs-12">
                        <div class="box box-solid bg-blue-gradient" style="height: 403px;">
                            <div class="box-header">
                                <i class="fa fa-calendar"></i>
                                <h3 class="box-title">Reference Calendar</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding" style="height: 100%;">
                                <!--The calendar -->
                                <div id="calendar" style="width: 100%; height: 100%;"></div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 class="count-slow"><?php echo $this->crud_model->get_count_of('student') ?></h3>
                        <h4>Students</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 class="count-slow"><?php echo $this->crud_model->get_count_of('teacher') ?></h3>
                        <h4>Teachers</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 class="count-slow"><?php echo $this->crud_model->get_count_of('parent') ?></h3>
                        <h4>Parents</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3 class="count-slow">23542435</h3>
                        <h4>Placeholder</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            Reset Account Credentials
                        </h3>
                    </div>
                    <div class="box-body">
                        <form action="<?php echo site_url('admin/reset_access')?>" method="post" id="reset-access-form">
                            <div class="form-group">
                                <label for="access-role" class="control-label">Select Access Level</label>
                                <select name="access-role" id="access-role" class="form-control" onchange="updateUserList();" required>
                                    <option value="">-- SELECT --</option>
                                    <option value="admin">Admin</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                    <option value="parent">Parent</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="access-user" class="control-label">Select User ID</label>
                                <select name="access-user" class="form-control select2" id="access-user-list" required>
                                    <!-- Will be filled by AJAX -->
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-danger" value="RESET CREDENTIALS">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            On The Go Settings
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <form action="<?php echo site_url('admin/update_default_password')?>" method="post">
                                    <label>Default reset password</label>
                                    <div class="input-group">
                                        <input type="password" id="default-password" name="default-password" class="form-control" placeholder="Default Password to reset to" value="<?php echo $this->crud_model->get_config('default_password')?>" required>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-success btn-flat">Update</button>
                                        </span>
                                    </div>
                                    <div class="checkbox">
                                        <label for="show-cb">
                                            <input type="checkbox" id="show-cb" onclick="togglePassword()"> Show Password
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <form action="<?php echo site_url('admin/update_site_status')?>" method="post">
                                    <label>Site Offline?</label>
                                    <div class="input-group">
                                        <select name="site-offline-select" id="site-offline-select" class="form-control">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-danger btn-flat">Update</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php if ($this->session->flashdata('admin_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('admin_success');?>'
        },{
            type: 'success',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            },
            delay: 100,
            placement: {
                from: "top",
                align: "center"
            }
        });
    </script>
<?php } ?>
<?php if ($this->session->flashdata('admin_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('admin_error');?>'
        },{
            type: 'error',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            },
            delay: 100,
            placement: {
                from: "top",
                align: "center"
            }
        });
    </script>
<?php } ?>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>
