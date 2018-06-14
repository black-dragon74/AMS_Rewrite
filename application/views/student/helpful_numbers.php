<?php include_once 'top_scripts.php'; include_once 'top_side_nav.php'; ?>

<script>
    $(function () {
        $('ul.sidebar-menu li:nth-child(5)').addClass('active');
    })
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Helpful Contacts
            <small>using student data for demo</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Helpful Numbers</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            // Display student info as of now
            $teacher = $this->db->get('student');
            foreach ($teacher->result() as $row) { ?>
                <div class="col-lg-4 col-md-6">
                    <div class="box box-widget widget-user">
                        <div class="widget-user-header bg-green-gradient">
                            <h3 class="widget-user-username"><?php echo $row->name?></h3>
                            <h5 class="widget-user-desc">Professor</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?php echo $this->crud_model->get_profile_pic('student', $row->student_id)?>" alt="User Avatar">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 border-bottom">
                                    <div class="description-block">
                                        <h5 class="description-header"><i class="fa fa-envelope"></i></h5>
                                        <span class="description-text"><?php echo $row->email ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6 border-right border-bottom">
                                    <div class="description-block">
                                        <h5 class="description-header"><i class="fa fa-graduation-cap"></i></h5>
                                        <span class="description-text"><?php echo $row->stream ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6 border-right border-bottom">
                                    <div class="description-block">
                                        <h5 class="description-header"><i class="fa fa-phone"></i></h5>
                                        <span class="description-text"><?php echo '+91-'.$row->phone ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="description-block">
                                        <h5 class="description-header"><i class="fa fa-map-marker"></i></h5>
                                        <span class="description-text"><?php echo $row->address ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
</div>
<?php include_once 'footer.php'; include_once 'bottom_scripts.php';?>
