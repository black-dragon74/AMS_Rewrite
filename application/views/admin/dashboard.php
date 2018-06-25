<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<script>
    $(function () {
        $('ul.sidebar-menu > li:nth-child(2)').addClass('active');
    })
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
                        <h3><?php echo $this->crud_model->get_count_of('student') ?></h3>
                        <h4>Students</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $this->crud_model->get_count_of('teacher') ?></h3>
                        <h4>Teachers</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php echo $this->crud_model->get_count_of('parent') ?></h3>
                        <h4>Parents</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>1</h3>
                        <h4>Placeholder</h4>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>
