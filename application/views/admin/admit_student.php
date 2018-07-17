<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<script>
    $(document).ready(function () {
        $('ul.sidebar-menu > li:nth-child(3)').addClass('active');
        $('ul.treeview-menu.student-menu > li:nth-child(1)').addClass('active');
    });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Admit Students
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Admit Students</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-danger text-bold" style="text-transform: uppercase;">
                    <h4><i class="fa fa-warning margin-r-5"></i>Please note</h4>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. A adipisci amet aut autem corporis cupiditate enim, eum excepturi exercitationem, ipsa iste magni nemo nobis non perspiciatis praesentium saepe vel voluptatem.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">
                            Admit new student
                        </h4>
                    </div>
                    <div class="box-body">
                        <form action="" class="form-horizontal" method="post">
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Full Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Select Parent</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Select Class</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Select Section</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Reg No</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Birthday</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Gender</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Address</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Phone</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Password Hint</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if ($this->session->flashdata('student_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('student_success');?>'
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
<?php if ($this->session->flashdata('student_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('student_error');?>'
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
