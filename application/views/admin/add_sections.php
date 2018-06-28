<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Section Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li>Stream Manager</li>
            <li class="active">Manage Sections</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Button to open modal for add section -->
        <button type="button" class="btn btn-info pull-right" onclick="showSectionModal()" style="margin-bottom: 10px;"><i class="fa fa-plus-circle margin-r-5"></i>Add New Section</button>
        <div style="clear: both;"></div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">1. Select stream to get sections</label>
                    <select name="" id="stream-select-for-table" class="form-control select2" required>
                        <option value="">-- SELECT --</option>
                        <!-- Connect to db and fetch the details of streams -->
                        <?php
                        $streams = $this->db->get('stream')->result();
                        foreach ($streams as $stream){
                            echo "<option value='$stream->stream_id'>$stream->name</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="">2. Click Me!</label>
                    <button type="button" class="btn btn-success" style="width: 100%;" onclick="populateSectionTable()">Populate List</button>
                </div>
            </div>
        </div>
        <!-- Display a list of sections for the selected class here -->
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List of sections</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center" id="section-list-table">
                                <thead>
                                <tr>
                                    <th>Stream</th>
                                    <th>Section</th>
                                    <th>Class Teacher</th>
                                    <th>Manage</th>
                                </tr>
                                </thead>
                                <tbody id="section-list-table-body">
                                    <!-- Will be populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- A new modal to add sections -->
<div class="modal fade in" id="add-section-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Section</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('admin/add_section')?>" method="post" id="add-section-modal-form">
                    <div class="form-group">
                        <label for="" class="control-label">Name</label>
                        <input type="text" placeholder="Section Name" class="form-control" name="add-section-name" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Stream</label>
                        <select name="add-section-stream" id="" class="form-control select2">
                            <!-- Connect to the db and get the list of available streams-->
                            <?php
                            $streams = $this->db->get('stream')->result();
                            foreach ($streams as $stream){
                                echo "<option value='$stream->stream_id'>$stream->name</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Teacher</label>
                        <select name="add-section-teacher" id="" class="form-control select2">
                            <!-- Connect to the db and get the list of available streams-->
                            <?php
                            $teachers = $this->db->get('teacher')->result();
                            foreach ($teachers as $teacher){
                                echo "<option value='$teacher->teacher_id'>$teacher->name</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="add-section-modal-form" class="btn btn-success">Add Section</button>
                <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
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
                <strong>Are you sure you want to delete this section?</strong>
            </div>
            <div class="modal-footer">
                <a id="confirm-modal-yes"><button type="button" class="btn btn-danger">Yes</button></a>
                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Function to open the modal
    function showSectionModal() {
        $('#add-section-modal').modal('show');

        // Init select2 after 100ms
        setTimeout(function () {
            $('.select2').select2();
        },100);
    }

    function populateSectionTable(){
        stream_id = $('#stream-select-for-table').val();
        if (stream_id == ''){
            alert('Select a stream!');
        }
        else {
            // Send AJAX request to the AJAX controller and fetch the stream sections list.
            $.ajax({
                url: '<?php echo site_url('ajax/section_details/')?>'+stream_id,
                data: {
                    "ams_ajax": true,
                },
                type: "post",
                success: function (response) {
                    if (response == 'empty!'){
                        alert('No data found!');
                        $('#section-list-table-body').html("");
                    }
                    else {
                        $('#section-list-table-body').html(response);
                    }
                },
                error: function () {
                    alert ('Server error!');
                }
            });
        }
    }

    // Function to show confirm modal once the user clicks on the delete button
    function showConfirmModal(deleteURL){
        $('#confirm-modal').modal('show');
        $('#confirm-modal-yes').attr('href', deleteURL);
    }

    $(document).ready(function () {
        // Init Data Table
        $('#section-list-table').dataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 15, 50, 100],
        });

        // Set sidebar active
        $('ul.sidebar-menu > li:nth-child(6)').addClass('active');
        $('ul.treeview-menu.stream-menu > li:nth-child(2)').addClass('active');

        // Init select2
        $('.select2').select2();
    });
</script>

<?php if ($this->session->flashdata('section_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('section_success');?>'
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

<?php if ($this->session->flashdata('section_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('section_error');?>'
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

