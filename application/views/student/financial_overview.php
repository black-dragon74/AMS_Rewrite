<?php include_once 'top_scripts.php'; include_once 'top_side_nav.php'; ?>
<script>
    $(function () {
        $('ul.sidebar-menu li:nth-child(4)').addClass('active');
    })
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Financial Details
            <small>of student</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Financial Details</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Row 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>Placeholder</h3>
                        <p>Placeholder</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row">
            <div class="col-lg-12 text-center text-red">
                <h1>No data!</h1>
            </div>
        </div>
    </section>
</div>
<?php include_once 'footer.php'; include_once 'bottom_scripts.php'?>
