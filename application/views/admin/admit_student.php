<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<script>
    $(document).ready(function () {
        $('ul.sidebar-menu > li:nth-child(3)').addClass('active');
        $('ul.treeview-menu.student-menu > li:nth-child(1)').addClass('active');
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
            endDate: '<?php echo date('d-m-Y')?>',
            startView: 2
        });
        $('.select2').select2();
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
                <div class="callout callout-info" style="text-transform: uppercase;">
                    <h4><i class="fa fa-warning margin-r-5"></i>Please note</h4>
                    <p>
                    Admitting a student will also create a enrollment for the student in the selected class, so, fill the form carefully.
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
                        <div class="row">
                            <div class="col-xs-12 text-center text-bold text-danger">
                                Fields marked with an asterisk(*) are required.
                            </div>
                        </div>
                        <br>
                        <form action="<?php echo site_url('admin/enroll_student')?>" class="form-horizontal" method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="student-user-id" class="col-sm-3 control-label">User ID *</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="student-user-id" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Reg No *</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="student-reg-no" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Full Name *</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="student-full-name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Select Parent *</label>
                                <div class="col-sm-6">
                                    <select name="student-parent" required class="form-control select2">
                                        <option value="">-- SELECT --</option>
                                        <?php 
                                            $parents = $this->db->get('parent');
                                            if ($parents->num_rows() > 0){
                                                foreach ($parents->result() as $parent){
                                                    echo '<option value="'.$parent->parent_id.'">'.$parent->name.' ('.$parent->uid.')'.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Select Class *</label>
                                <div class="col-sm-6">
                                    <select name="student-class" id="student-class" class="form-control select2" onchange="populateStream()" required>
                                        <option value="">-- SELECT --</option>
                                        <?php
                                            $classes = $this->db->get('stream')->result();
                                            foreach ($classes as $class){
                                                echo '<option value="'.$class->name.'">'.$class->name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Select Section</label>
                                <div class="col-sm-6">
                                    <select name="student-section" id="student-section" class="form-control" required>
                                        <option value="">-- SELECT CLASS FIRST --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Birthday *</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control datepicker" name="student-birthday" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Gender *</label>
                                <div class="col-sm-6">
                                    <select name="student-gender" class="form-control" required>
                                        <option value="">-- SELECT --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="student-blood" class="col-sm-3 control-label">Blood Group</label>
                                <div class="col-sm-6">
                                    <select name="student-blood" id="" class="form-control">
                                        <option value="">-- SELECT --</option>
                                        <option value="A +ve">A +ve</option>
                                        <option value="A -ve">A -ve</option>
                                        <option value="B +ve">B +ve</option>
                                        <option value="B -ve">B -ve</option>
                                        <option value="AB +ve">AB +ve</option>
                                        <option value="AB -ve">AB -ve</option>
                                        <option value="O +ve">O +ve</option>
                                        <option value="O -ve">O -ve</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Address *</label>
                                <div class="col-sm-6">
                                    <textarea rows="5" name="student-address" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Phone *</label>
                                <div class="col-sm-6">
                                    <input type="text" maxlength="10" minlength="10" pattern="\d*" class="form-control" name="student-phone" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Email *</label>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control" name="student-email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Password *</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" align="student-password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Password Hint *</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="student-password-hint" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-3">
                                    <input type="submit"  value="Add Student" class="form-control btn btn-success">
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

<script>
    function populateStream(){
        let stream = $.trim($('#student-class').val());
        if (stream !== ''){
            // Send an AJAX request to populate the section list
            $.ajax({
                url: '<?php echo site_url('ajax/populate_stream_sections')?>',
                data: {
                    'ams_ajax': true,
                    'stream_id': stream
                },
                type: 'post',
                success: function(response){
                    if (response === 'empty'){
                        // Not required anymore, it is optional
                        $('#student-section').prop({
                            'required': false,
                            'disabled': true
                        }).html('<option>NOT REQUIRED</option>');
                    }
                    else {
                        $('#student-section').prop({
                            'required': true,
                            'disabled': false
                        }).html(response);
                    }
                },
                error: function(){
                    alert ('Server error!');
                }
            });
        }
    }
</script>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>
