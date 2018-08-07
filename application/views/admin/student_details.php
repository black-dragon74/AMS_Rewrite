<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<script>
    $(document).ready(function () {
        $('ul.sidebar-menu > li:nth-child(3)').addClass('active');
        $('ul.treeview-menu.student-menu > li:nth-child(3)').addClass('active');
        $('.select2').select2();
    });
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Student Info
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Student Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Select Class</label>
                                <select class="form-control select2" id="student-class" name="student-class" onchange="populateSection()" required>
                                    <option value="">-- SELECT --</option>
                                    <?php 
                                        $classes = $this->db->get('stream');
                                        if ($classes->num_rows() > 0){
                                            foreach ($classes->result() as $stream) {
                                                echo '<option value="'.$stream->name.'">'.$stream->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Select Section (Optional)</label>
                                <select class="form-control" id="student-section" name="student-section">
                                    <option value="">-- SELECT CLASS FIRST --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Click me!</label>
                                <input type="submit" value="Get Data" class="form-control btn btn-success" id="send-ajax">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h4 class="box-title">List of selected students</h4>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table table-striped table-bordered text-center data-table">
                                    <thead>
                                        <th>Reg No</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                    </thead>
                                    <tbody id="student-ajax-repsonse">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.data-table').dataTable({
            // Order alphabetically
            "order": [[1, "asc"]],
            "pageLength": 25
        });
    });
</script>
<script>
    function populateSection(){
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
                        }).html("<option value='empty'>NOT REQUIRED</option>");
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
<script type="text/javascript">
    $('#send-ajax').on('click', function(e){
        // Stop form from submitting
        e.preventDefault();

        // Ajax handler to fetch the student data from the server as per the submitted request
        let stream_id = $.trim($('#student-class').val());
        let section_name = $('#student-section').val();

        $.ajax({
            "url": '<?php echo site_url('ajax/student_ajax_table')?>',
            "data": {
                "ams_ajax": true,
                "stream_id": stream_id,
                'section_name': section_name
            },
            type: 'post',
            success: function(resposne) {
                $('#student-ajax-repsonse').html(resposne);
            },
            error: function(){
                alert('Server error!');
            }
        });
    });
</script>
<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>
