<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<script>
    $(function () {
        $('ul.sidebar-menu li:nth-child(2)').addClass('active');
    })
</script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Student Info
        <small>Registration Details</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url('student') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('student') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Dashboard</li>
        <li class="active">My Info</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $studentInfo->stream ?></h3>

              <p>Stream</p>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-blackboard"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $studentInfo->student_code ?></h3>

              <p>Registration Number</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>40009022</h3>

              <p>Admission Number</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $studentInfo->student_id ?></h3>

              <p>Roll Number</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- Content Header (Page header) -->
      <section class="content-header-incontent">
        <h1>
          General Info
          <small>Notices and Calendars</small>
        </h1>
      </section>

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Notices -->
            <div class="box">
                <div class="box-header text-center">
                    <h3 class="box-title text-bold">Notices for <?php echo $studentInfo->stream ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding text-center">
                    <table class="table table-bordered table-responsive table-hover">
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Notice</th>
                                <th>Category</th>
                            </tr>
                              <?php
                              $this->db->where('stream', $studentInfo->stream);
                              $this->db->or_where('stream', 'all');
                              $this->db->order_by('notice_id', 'asc');
                              $qry = $this->db->get('notices');
                              $th = 0;
                              foreach ($qry->result() as $row){
                                  // Incerement row count
                                  $th++
                                  ?>
                                  <tr>
                                      <th><?php echo $th ?></th>
                                      <td><?php echo $row->notice ?></td>
                                      <td><span class="label label-danger" style="padding: 5px; font-size: 12px;"><?php echo $row->stream ?></span></td>
                                  </tr>
                              <?php }
                              ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </section>
        <section class="col-lg-5 connectedSortable">
          <!-- Calendar -->
          <div class="box box-solid bg-aqua-gradient" style="height: 311px;">
            <div class="box-header">
              <i class="fa fa-calendar"></i>
              <h3 class="box-title">Reference Calendar</h3>
            </div>
            <div class="box-body no-padding">
              <div id="calendar" style="width: 100%"></div>
            </div>
          </div>
        </section>
      </div>

    </section>
  </div>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>
