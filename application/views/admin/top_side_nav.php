<?php
// Initialize variables for this form
$adminInfo = $this->db->get_where('admin', array('admin_id' => $this->session->userdata('admin_id')))->row();
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url('admin') ?>" class="logo">
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
                        <img src="<?php echo $this->crud_model->get_profile_pic('admin', $this->session->userdata('admin_id'))?>" class="user-image" alt="User Image">
                        <span class="hidden-xs">Welcome, <?php echo ucfirst($adminInfo->uid) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $this->crud_model->get_profile_pic('admin', $this->session->userdata('admin_id'))?>" class="img-circle" alt="User Image">

                            <p>
                                <?php echo $adminInfo->name ?>
                                <small>MUJ AMS ADMINISTRATOR</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo site_url('admin/account_settings') ?>" class="btn btn-default btn-flat">Profile</a>
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
                <img src="<?php echo $this->crud_model->get_profile_pic('admin', $this->session->userdata('admin_id'))?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $adminInfo->name ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Main Section -->
            <li class="header">Main Menu</li>
            <li>
                <a href="<?php echo site_url('admin') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <!-- Use this to add some msg to the right of menu -->
                    <!-- span class="pull-right-container">
                      <small class="label pull-right bg-red">•</small>
                    </span> -->
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-group"></i> <span>Students</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i>Admit Students</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Bulk Admit Students</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Student Information</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Student Promotions</a></li>
                </ul>
            </li>

            <li>
                <a href="#">
                    <i class="glyphicon glyphicon-user"></i>
                    <span>Teachers</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Parents</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="glyphicon glyphicon-blackboard"></i>
                    <span>Stream Manager</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu stream-menu">
                    <li><a href="<?php echo site_url('admin/manage_streams')?>"><i class="fa fa-circle-o"></i>Manage Streams</a></li>
                    <li><a href="<?php echo site_url('admin/manage_sections')?>"><i class="fa fa-circle-o"></i>Manage Sections</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i>Placeholder</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo site_url('admin/manage_notices')?>">
                    <i class="glyphicon glyphicon-pushpin"></i>
                    <span>Manage Notices</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i> <span>Academic Status</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-dollar"></i> <span>Financial Details</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('admin/staff_numbers')?>">
                    <i class="fa fa-phone"></i> <span>Staff Numbers</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-red"><i class="fa fa-info"></i></small>
            </span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('admin/account_settings') ?>">
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
                <a href="#" data-toggle="modal" data-target="#feedback-modal">
                    <i class="fa fa-edit"></i> <span>Feedback</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<div class="modal modal-success fade in" id="feedback-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Feedback</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form id="feedback-form" method="post" autocomplete="off">
                            <input type="hidden" name="ams_ajax" value="true">
                            <div class="form-group">
                                <label for="feedback-name" class="control-label">Name</label>
                                <input type="text" class="form-control" id="feedback-name" placeholder="Your Name" required>
                            </div>
                            <div class="form-group">
                                <label for="feedback-email" class="control-label">Email</label>
                                <input type="email" class="form-control" id="feedback-email" placeholder="Your Email" required>
                            </div>
                            <div class="form-group">
                                <label for="feedback-feedback" class="control-label">Feedback</label>
                                <textarea id="feedback-feedback" class="form-control no-resize" rows="5" placeholder="Your detailed feedback" required></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="feedback-form" class="btn btn-warning" id="send-feedback-btn"><i class="fa fa-paper-plane margin-r-5"></i>Send</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close margin-r-5"></i>Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#send-feedback-btn').click(function (e) {
        e.preventDefault();

        if ($('#feedback-name').val() == '' || $('#feedback-email').val() == '' || $('#feedback-feedback').val() == ''){
            alert('Fill all the fields in the form!');
            return;
        }

        $.ajax({
            url: '<?php echo site_url('ajax/send_feedback')?>',
            data: {
                "ams_ajax": true,
                "feedback-name": $('#feedback-name').val(),
                "feedback-email": $('#feedback-email').val(),
                "feedback-feedback": $('#feedback-feedback').val()
            },
            type: "post",
            success: function (response) {
                if (response == 'sent'){
                    alert ('Thanks for your feedback!');
                    location.reload();
                }
                else {
                    alert ('A Server error occurred!\n'+response);
                    location.reload();
                }
            },
            error: function () {
                alert('Server error occurred in sending the mail');
                location.reload();
            }
        });
    });
</script>