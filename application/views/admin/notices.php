<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

    <script>
        $(function () {
            $('ul.sidebar-menu li:nth-child(6)').addClass('active');
        })
    </script>

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
                                        <div class="box-header" style="text-align: center;">
                                            <h3 class="box-title">Notices for users</h3>
                                        </div>
                                        <div class="box-body table-responsive no-padding text-center">
                                            <table class="table table-bordered table-hover table-striped">
                                                <tbody>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Notice</th>
                                                    <th>Stream</th>
                                                    <th>Manage</th>
                                                </tr>
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
                                                                <a href="#" onclick="confirmDeletionFor('<?php echo site_url('admin/delete_notice/'.$row->notice_id)?>')"><span style="font-size: 20px;"><i class="fa fa-trash"></i> </span></a>
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
                                    <select class="form-control" name="stream" required>
                                        <option value="">-- SELECT --</option>
                                        <?php
                                            // Get unique streams for the students
                                        $this->db->distinct();
                                        $this->db->select('stream');
                                        $result = $this->db->get('student');
                                        foreach ($result->result() as $row){
                                            echo "<option value='$row->stream'>$row->stream</option>";
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
</script>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>