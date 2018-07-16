<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                List of teachers
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Dashboard</li>
                <li class="active">Teachers</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Button to open modal for add section -->
            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#add-teacher-modal"><i class="fa fa-plus-circle margin-r-5"></i>Add New Teacher</button>
            <div style="clear: both; margin-bottom: 10px;"></div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List of all teachers</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive table-striped text-center" id="teacher-table">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Stream</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Manage</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // Connect to the db and fetch teachers
                                    $teachers = $this->db->get('teacher')->result();
                                    foreach ($teachers as $teacher){
                                        $deleteURL = site_url('admin/delete_teacher/').$teacher->teacher_id;
                                        echo "<tr>
                                            <td>$teacher->uid</td>
                                            <td>$teacher->name</td>
                                            <td>$teacher->designation</td>
                                            <td>$teacher->stream</td>
                                            <td>$teacher->email</td>
                                            <td>$teacher->phone</td>
                                            <td>$teacher->address</td>
                                            <td>
                                                <a href='#' onclick='openEditModal(\"$teacher->teacher_id\")'><span class='label label-success margin-r-5' style='font-size: 18px;'><i class='fa fa-pencil'></i></span></a>
                                                <a href='#' onclick='openConfirmModal(\"$deleteURL\")'><span class='label label-danger margin-r-5 text-center' style='font-size: 18px;'><i class='fa fa-trash'></i></span></a>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade in" id="add-teacher-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close pull-right" data-dismiss="modal">x</span>
                    <h4 class="modal-title">Add New Teacher</h4>
                </div>
                <div class="modal-body modal-body-scroll">
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="text-center text-red text-bold">Fields marked with an asterisk '*' must be unique.</p>
                            <form action="<?php echo site_url('admin/add_teachers')?>" method="post" autocomplete="off" id="add-teacher-form">
                                <div class="form-group">
                                    <label for="teacher-uid" class="control-label">User ID*</label>
                                    <input type="text" name="teacher-uid" class="form-control" placeholder="Teacher User ID" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-name" class="control-label">Name</label>
                                    <input type="text" name="teacher-name" class="form-control" placeholder="Teacher Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-stream" class="control-label">Stream (optional)</label>
                                    <select name="teacher-stream" class="form-control select2">
                                        <option value="">-- SELECT --</option>
                                        <!-- Filled by PHP -->
                                        <?php
                                        $streams = $this->db->get('stream');
                                        foreach ($streams->result() as $stream){
                                            echo '<option value="'.$stream->name.'">'.$stream->name.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-designation" class="control-label">Designation</label>
                                    <input type="text" name="teacher-designation" class="form-control" placeholder="Teacher Designation" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-birthday" class="control-label">Birthday</label>
                                    <input type="text" name="teacher-birthday" class="form-control datepicker" placeholder="Birthday(dd/mm/yyyy)" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-sex" class="control-label">Sex</label>
                                    <select name="teacher-sex" class="form-control" required>
                                        <option value="">-- SELECT --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-blood" class="control-label">Blood Group</label>
                                    <select name="teacher-blood" class="form-control" required>
                                        <option value="">-- SELECT --</option>
                                        <option value="A +ve">A +ve</option>
                                        <option value="A -ve">A -ve</option>
                                        <option value="B -ve">B +ve</option>
                                        <option value="B -ve">B -ve</option>
                                        <option value="O -ve">O +ve</option>
                                        <option value="0 -ve">O -ve</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-email" class="control-label">Email*</label>
                                    <input type="email" name="teacher-email" class="form-control" placeholder="Teacher Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-password" class="control-label">Password</label>
                                    <input type="password" name="teacher-password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-password-hint" class="control-label">Password Hint</label>
                                    <input type="text" name="teacher-password-hint" class="form-control" placeholder="Password Hint" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-address" class="control-label">Address</label>
                                    <textarea name="teacher-address" rows="5" class="no-resize form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-phone" class="control-label">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <strong>+91</strong>
                                        </div>
                                        <input type="text" pattern="\d*" name="teacher-phone" class="form-control" placeholder="Phone Number" maxlength="10" minlength="10" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" form="add-teacher-form"><i class="fa fa-check margin-r-5"></i>Add Teacher</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-close margin-r-5"></i>Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="edit-teacher-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close pull-right" data-dismiss="modal">x</span>
                    <h4 class="modal-title">Edit teacher</h4>
                </div>
                <div class="modal-body modal-body-scroll" id="edit-modal-body">
                    <!-- Will be filled using ajax -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" form="edit-teacher-form"><i class="fa fa-check margin-r-5"></i>Update</button>
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-close margin-r-5"></i>Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to confirm an AMS action -->
    <div class="modal fade in" id="confirm-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                    <h4 class="modal-title">Confirm</h4>
                </div>
                <div class="modal-body">
                    <strong>Are you sure you want to delete this teacher?</strong>
                </div>
                <div class="modal-footer">
                    <a id="confirm-modal-yes"><button type="button" class="btn btn-danger">Yes</button></a>
                    <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('ul.sidebar-menu > li:nth-child(4)').addClass('active');
        })

        $(document).ready(function () {
            $('#teacher-table').dataTable({
                // Order alphabetically
                "order": [[1, "asc"]]
            });

            $('.select2').select2();

            $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                endDate: '<?php echo date('d-m-Y')?>',
                startView: 2
            });
        });

        function openConfirmModal(delURL){
            $('#confirm-modal').modal('show');
            $('#confirm-modal-yes').attr('href', delURL);
        }

        function openEditModal(teacherID){
            // Send ajax request to the server with the teacher ID
            $.ajax({
                url: '<?php echo site_url('ajax/edit_teacher_modal/')?>',
                data: {
                    "ams_ajax": true,
                    "teacherID": teacherID
                },
                type: "post",
                success: function (response) {
                    $('#edit-modal-body').html(response);
                },
                error: function () {
                    alert ('Server error!');
                }
            });

            // Display the modal
            $('#edit-teacher-modal').modal('show');

            setTimeout(function () {
                $('.select2').select2();
            }, 300);
        }
    </script>

<?php if ($this->session->flashdata('teacher_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('teacher_success');?>'
        },{
            type: 'success',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            },
            placement: {
                from: "top",
                align: "center"
            }
        });
    </script>
<?php } ?>

<?php if ($this->session->flashdata('teacher_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('teacher_error');?>'
        },{
            type: 'danger',
            animate: {
                enter: 'animated bounceInDown',
                exit: 'animated bounceOutUp'
            },
            placement: {
                from: "top",
                align: "center"
            }
        });
    </script>
<?php } ?>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>