<?php
// Initialize variables for this form
$studentInfo = $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')))->row();
?>
<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>MS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Manipal</b>AMS</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <!-- For screen readers -->
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $this->crud_model->get_profile_pic('student', $this->session->userdata('student_id'))?>" class="user-image" alt="User Image">
                        <span class="hidden-xs">Welcome, <?php echo ucfirst($studentInfo->uid) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $this->crud_model->get_profile_pic('student', $this->session->userdata('student_id'))?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $studentInfo->name ?>
                                <small><?php echo $studentInfo->stream ?></small>
                                <small>Semester 1</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo site_url('student/account_settings') ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo site_url('login/logout')?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo $this->crud_model->get_profile_pic('student', $this->session->userdata('student_id'))?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $studentInfo->name ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Main Section -->
            <li class="header">Main Menu</li>
            <li>
                <a href="<?php echo site_url('student') ?>">
                    <i class="fa fa-user"></i> <span>Profile Info</span>
                    <!-- Use this to add some msg to the right of menu -->
                    <!-- span class="pull-right-container">
                      <small class="label pull-right bg-red">•</small>
                    </span> -->
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('student/academic_overview') ?>">
                    <i class="fa fa-bar-chart-o"></i> <span>Academic Status</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('student/financial_overview') ?>">
                    <i class="fa fa-dollar"></i> <span>Financial Details</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('student/helpful_numbers') ?>">
                    <i class="fa fa-phone"></i> <span>Helpful Numbers</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-red"><i class="fa fa-info"></i></small>
            </span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('student/account_settings') ?>">
                    <i class="fa fa-gear"></i> <span>Account Settings</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>

            <!-- Other section -->
            <li class="header">Miscellaneous Links</li>
            <li>
                <a href="https://jaipur.manipal.edu?referrer=AmsNick" target="_blank">
                    <i class="fa fa-institution"></i> <span>Manipal's Website</span>
                </a>
            </li>
            <li>
                <a href="https://jaipur.manipal.edu/muj/pay_fee.html" target="_blank">
                    <i class="fa fa-mouse-pointer"></i> <span>Pay Fees Online</span>
                </a>
            </li>
            <li>
                <a href="#not-added-yet">
                    <i class="fa fa-edit"></i> <span>Feedback</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>