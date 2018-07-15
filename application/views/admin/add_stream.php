<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Stream Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li>Stream Manager</li>
            <li class="active">Manage Stream</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- This wil contain the add new stream button -->
        <div class="row">
            <div class="col-xs-12">
                <!-- Add new stream button -->
                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#add-stream-modal"><i class="fa fa-plus-circle margin-r-5"></i>Add New Stream</button>
                <div class="clear-both margin-bottom"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="callout callout-danger">
                    <p><strong>Note: </strong>You can only edit the teacher for a selected stream. To edit the stream name, delete the stream and re-add it.</p>
                </div>
            </div>
        </div>
        <!-- stream list -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List of Streams</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center" id="stream-list-table">
                            <thead>
                            <tr>
                                <th>Stream ID</th>
                                <th>Stream Name</th>
                                <th>Class Teacher</th>
                                <th>Manage</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Connect to the db and get the stream data
                            $streams = $this->db->get('stream')->result();
                            foreach ($streams as $row){
                                $teacher = $row->teacher_id;
                                $teacher_name = $this->db->get_where('teacher', array('teacher_id' => $teacher))->row()->name;
                                $stream_id = $row->stream_id;
                                $stream_name = $row->name; ?>
                                <tr>
                                    <th><?php echo $stream_id?></th>
                                    <td><?php echo $stream_name?></td>
                                    <td><?php echo $teacher_name?></td>
                                    <td>
                                        <a href="#" onclick="showStreamEditModal('<?php echo $stream_id?>')"><span class='label label-success margin-r-5' style='font-size: 18px;'><i class="fa fa-pencil"></i></span></a>
                                        <a href="#" onclick="showConfirmModal('<?php echo site_url('admin/delete_stream/').$stream_id?>')"><span class='label label-danger margin-r-5' style='font-size: 18px;'><i class="fa fa-trash"></i></span></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
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
                        <strong>Are you sure you want to delete this stream?</strong>
                    </div>
                    <div class="modal-footer">
                        <a id="confirm-modal-yes"><button type="button" class="btn btn-danger">Yes</button></a>
                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to be filled by AJAX for stream edit -->
        <div class="modal fade in" id="edit-stream-modal">
            <!-- Filled by AJAX -->
        </div>

        <!-- Modal to add new stream -->
        <div class="modal fade in" id="add-stream-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close pull-right" data-dismiss="modal">x</span>
                        <h4 class="modal-title">
                            Add New Stream
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <form action="<?php echo site_url('admin/add_stream')?>" method="post" id="stream-add-form">
                                    <div class="form-group">
                                        <label>Stream Name</label>
                                        <input type="text" class="form-control" name="stream-name" placeholder="Name of the stream (Unique)" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Select Teacher</label>
                                        <select name="stream-teacher" id="" class="form-control select2" style="width: 100%" required>
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            // Connect to the teacher db and fetch the details
                                            $teacher_data = $this->db->get('teacher')->result();
                                            foreach ($teacher_data as $teacher_d){
                                                echo "<option value='$teacher_d->teacher_id'>$teacher_d->name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success" form="stream-add-form" value="Add Stream">
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    // Make stream list a data-table
    $(document).ready(function () {
        $('#stream-list-table').dataTable({
            "order": [[1, "asc"]]
        });

        $('ul.sidebar-menu > li:nth-child(6)').addClass('active');
        $('ul.treeview-menu.stream-menu > li:nth-child(1)').addClass('active');


        $('.select2').select2();
    });

    // Function to show confirm modal once the user clicks on the delete button
    function showConfirmModal(deleteURL){
        $('#confirm-modal').modal('show');
        $('#confirm-modal-yes').attr('href', deleteURL);
    }

    // Function to show the stream edit modal
    function showStreamEditModal(stream_id){
        // Send an ajax request with the stream ID

        $.ajax({
            url: '<?php echo site_url('ajax/dump_stream_edit_modal')?>',
            data: {
                "ams_ajax": true,
                "stream_id": stream_id
            },
            type: "post",
            success: function (response) {
                $('#edit-stream-modal').html(response);
            },
            error: function () {
                alert('Server error occurred!');
            }
        });

        $('#edit-stream-modal').modal('show');

        // Wait for the select to be there in the DOM
        setTimeout(function () {
            $('.select2').select2();
        }, 100);
    }
</script>

<?php if ($this->session->flashdata('stream_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('stream_success');?>'
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

<?php if ($this->session->flashdata('stream_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('stream_error');?>'
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
