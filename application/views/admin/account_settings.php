<?php
include_once 'top_scripts.php'; include_once 'top_side_nav.php';
?>
    <script>
        $(function () {
            $('ul.sidebar-menu li:nth-child(6)').addClass('active');
        })
    </script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Account Settings
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Dashboard</li>
                <li class="active">Account Settings</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="<?php echo $this->crud_model->get_profile_pic('admin', $this->session->userdata('admin_id'))?>" alt="User profile picture">

                            <h3 class="profile-username text-center"><?php echo ucfirst($adminInfo->uid) ?></h3>

                            <p class="text-muted text-center"><?php echo ucfirst($this->session->userdata('login_type')) ?></p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Name</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $adminInfo->name ?></span>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <span class="pull-right text-red" style="font-weight: 600;"><?php echo $adminInfo->email ?></span>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Email &amp; Photo</a></li>
                            <li><a href="#password" data-toggle="tab" aria-expanded="true">Password</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal" enctype="multipart/form-data" autocomplete="off" method="post" action="<?php echo site_url('admin/update_profile') ?>">
                                    <div class="form-group">
                                        <label for="username" class="col-sm-2 control-label">Username</label>

                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="inputUser" id="username" placeholder="<?php echo $adminInfo->uid ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                        <div class="col-sm-8">
                                            <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Photo</label>
                                        <div class="col-sm-8">
                                            <img src="<?php echo $this->crud_model->get_profile_pic('admin', $this->session->userdata('admin_id'))?>" id="profile-img" alt="User Image" height="100px" width="100px" style="border-radius: 10px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">New Photo</label>
                                        <div class="col-sm-8">
                                            <label class="custom-file-upload">
                                                <input type="file" id="profile-image" accept="image/*" name="inputImage">
                                                Choose File
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="submit" class="btn btn-danger" id="update-profile">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Second tab for password -->
                            <div class="tab-pane" id="password">
                                <form class="form-horizontal" autocomplete="off" method="post" action="<?php echo site_url('admin/update_password')?>">
                                    <div class="form-group">
                                        <label for="current-password" class="col-sm-2 control-label">Current</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" required="required" name="current-password" current-password" placeholder="Current Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new-password" class="col-sm-2 control-label">New</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" required="required" name="new-password" id="new-password" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="re-password" class="col-sm-2 control-label">Retype</label>

                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" required="required" name="re-password" id="re-password" placeholder="Retype Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <input type="submit" class="btn btn-danger" name="submit" id="update-password">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php if ($this->session->flashdata('error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            title: "<strong>Error:</strong> ",
            message: '<?php echo $this->session->flashdata('error');?>'
        },{
            type: 'danger',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            }
        });
    </script>
<?php } ?>

<?php if ($this->session->flashdata('success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            title: "<strong>Success:</strong> ",
            message: '<?php echo $this->session->flashdata('success');?>'
        },{
            type: 'success',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            }
        });
    </script>
<?php } ?>

<?php include_once 'footer.php'; include_once 'bottom_scripts.php';?>