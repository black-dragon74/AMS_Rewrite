<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Notices
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Notices</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#view-notices" data-toggle="tab">View Notices</a>
                        </li>
                        <li>
                            <a href="#add-notices" data-toggle="tab">Add Notices</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="view-notices">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title">Notices for users</h3>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table class="table table-bordered table-hover table-striped text-center" id="notice-data-table">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Notice</th>
                                                    <th>Stream</th>
                                                    <th>Manage</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $this->db->order_by('notice_id', 'asc');
                                                $qry = $this->db->get('notices');
                                                $th = 0;
                                                if ($qry->num_rows() == 0){
                                                    echo "<tr>
                                        <th colspan='4'>No Notices found!</th>
                                  </tr>";
                                                }
                                                else{
                                                    foreach ($qry->result() as $row){
                                                        // Incerement row count
                                                        $th++;
                                                        ?>
                                                        <tr>
                                                            <th><?php echo $th ?></th>
                                                            <td><?php echo $row->notice ?></td>
                                                            <td><span class="label label-danger" style="padding: 5px; font-size: 12px;"><?php echo $row->stream ?></span></td>
                                                            <td>
                                                                <a href="#" onclick="showEditModal(
                                                                    '<?php echo $row->notice_id?>',
                                                                        '<?php echo $row->notice ?>',
                                                                        '<?php echo $row->stream?>'
                                                                        )">
                                                                    <span class="label label-success margin-r-5" style="font-size: 18px; text-align: center"><i class="fa fa-pencil"></i> </span>
                                                                </a>
                                                                <a href="#" onclick="confirmDeletionFor(
                                                                    '<?php echo site_url('admin/delete_notice/'.$row->notice_id)?>')">
                                                                    <span class="label label-danger margin-r-5" style="font-size: 18px; text-align: center"><i class="fa fa-trash"></i> </span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php }}
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="add-notices">
                            <form class="" autocomplete="off" method="post" action="<?php echo site_url('admin/add_notice')?>">
                                <div class="form-group">
                                    <label for="notice" class="control-label">Notice</label>
                                    <textarea class="form-control" name="notice" id="notice" rows="5" placeholder="Notice to add" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="notice" class="control-label">Select Stream</label>
                                    <select class="form-control select2" name="stream" style="width: 100%" required>
                                        <option value="">-- SELECT --</option>
                                        <option value="All">SHOW TO ALL</option>
                                        <?php
                                        // Get unique streams for the students
                                        $this->db->distinct();
                                        $this->db->select('name');
                                        $result = $this->db->get('stream');
                                        foreach ($result->result() as $row){
                                            echo "<option value='$row->name'>$row->name</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" class="col-xs-offset-5 btn btn-danger" name="add-notice" value="Add Notice">
                            </form>
                        </div>
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
                        <strong>Are you sure you want to delete this notice?</strong>
                    </div>
                    <div class="modal-footer">
                        <a id="confirm-modal-yes"><button type="button" class="btn btn-danger">Yes</button></a>
                        <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal to edit a notice -->
        <div class="modal fade in" id="modal-edit-notice">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Notice</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <form action="<?php echo site_url('admin/edit_notice')?>" id="modal-notice-edit-form" method="post">
                                    <div class="form-group">
                                        <label for="" class="control-label">Notice ID</label>
                                        <input type="text" class="form-control" name="modal-notice-id" id="modal-notice-id" readonly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label">Notice</label>
                                        <textarea rows="5" class="form-control" name="modal-notice" id="modal-notice"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label">Stream</label>
                                        <select name="" id="modal-notice-stream" class="form-control" disabled>
                                            <option value="">B.C.A</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="modal-notice-edit-form" class="btn btn-success">Update</button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php if ($this->session->flashdata('notice_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('notice_success');?>'
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

<script type="text/javascript">
    // Function to show the confirm modal with the delete action
    function confirmDeletionFor(delete_url) {
        $('#confirm-modal').modal('show');
        $('#confirm-modal-yes').attr('href', delete_url);
    }

    // Function to show the edit notice modal
    function showEditModal(notice_id, notice, stream){
        // Set the values based on params
        $('#modal-notice-id').val(notice_id);
        $('#modal-notice').val(notice);
        $('#modal-notice-stream > option').html(stream);

        // Show the modal
        $('#modal-edit-notice').modal('show');
    }
</script>
<script>
    $(function () {
        $('ul.sidebar-menu > li:nth-child(7)').addClass('active');
    })

    $(document).ready(function () {
        $('#notice-data-table').DataTable({
            responsive: true,
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50, 100],
            // Show recent first
            "order": [[0, 'desc']]
        });

        $('.select2').select2();
    });
</script>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>