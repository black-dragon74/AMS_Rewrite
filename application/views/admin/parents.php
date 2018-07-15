<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            List of parents
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Parents</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Button to open modal for add section -->
        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#add-parent-modal"><i class="fa fa-plus-circle margin-r-5"></i>Add New Parent</button>
        <div style="clear: both; margin-bottom: 10px;"></div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List of all parents</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-responsive table-striped text-center" id="parent-table">
                                <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Connect to the db and fetch parents
                                $parents = $this->db->get('parent')->result();
                                foreach ($parents as $parent){
                                    $deleteURL = site_url('admin/delete_parent/').$parent->parent_id;
                                    echo "<tr>
                                            <td>$parent->uid</td>
                                            <td>$parent->name</td>
                                            <td>$parent->email</td>
                                            <td>$parent->phone</td>
                                            <td>$parent->address</td>
                                            <td>
                                                <a href='#' onclick='openEditModal(\"$parent->parent_id\")'><span class='label label-success margin-r-5' style='font-size: 18px;'><i class='fa fa-pencil'></i></span></a>
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

<div class="modal fade in" id="add-parent-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close pull-right" data-dismiss="modal">x</span>
                <h4 class="modal-title">Add New Parent</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-center text-red text-bold">Fields marked with an asterisk '*' must be unique.</p>
                        <form action="<?php echo site_url('admin/add_parents')?>" method="post" autocomplete="off" id="add-parent-form">
                            <div class="form-group">
                                <label for="parent-uid" class="control-label">User ID*</label>
                                <input type="text" name="parent-uid" class="form-control" placeholder="Parent User ID" required>
                            </div>
                            <div class="form-group">
                                <label for="parent-name" class="control-label">Name</label>
                                <input type="text" name="parent-name" class="form-control" placeholder="Parent Name" required>
                            </div>
                            <div class="form-group">
                                <label for="parent-email" class="control-label">Email*</label>
                                <input type="email" name="parent-email" class="form-control" placeholder="Parent Email" required>
                            </div>
                            <div class="form-group">
                                <label for="parent-password" class="control-label">Password</label>
                                <input type="password" name="parent-password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="parent-password-hint" class="control-label">Password Hint</label>
                                <input type="text" name="parent-password-hint" class="form-control" placeholder="Password Hint" required>
                            </div>
                            <div class="form-group">
                                <label for="parent-phone" class="control-label">Phone Number</label>
                                <input type="text" name="parent-phone" class="form-control" placeholder="Phone Number" required>
                            </div>

                            <div class="form-group">
                                <label for="parent-profession" class="control-label">Profession</label>
                                <input type="text" name="parent-profession" class="form-control" placeholder="Profession" required>
                            </div>
                            <div class="form-group">
                                <label for="parent-address" class="control-label">Address</label>
                                <textarea name="parent-address" rows="5" class="no-resize form-control" required></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="submit" form="add-parent-form"><i class="fa fa-plus-circle margin-r-5"></i>Add Parent</button>
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-close margin-r-5"></i>Close</button>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade in" id="edit-parent-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close pull-right" data-dismiss="modal">x</span>
                    <h4 class="modal-title">Edit Parent</h4>
                </div>
                <div class="modal-body" id="edit-modal-body">
                    <!-- Will be filled using ajax -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" form="edit-parent-form"><i class="fa fa-check margin-r-5"></i>Update</button>
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
                <strong>Are you sure you want to delete this parent?</strong>
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
        $('ul.sidebar-menu > li:nth-child(5)').addClass('active');
    })

    $(document).ready(function () {
        $('#parent-table').dataTable({
            // Order alphabetically
            "order": [[1, "asc"]]
        });
    });

    function openConfirmModal(delURL){
        $('#confirm-modal').modal('show');
        $('#confirm-modal-yes').attr('href', delURL);
    }

    function openEditModal(parentID){
        // Send ajax request to the server with the parent ID
        $.ajax({
            url: '<?php echo site_url('ajax/edit_parent_modal/')?>',
            data: {
                "ams_ajax": true,
                "parentID": parentID
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
        $('#edit-parent-modal').modal('show');
    }
</script>

<?php if ($this->session->flashdata('parent_success') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('parent_success');?>'
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

<?php if ($this->session->flashdata('parent_error') != '') { ?>
    <script type="text/javascript">
        $.notify({
            message: '<?php echo $this->session->flashdata('parent_error');?>'
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