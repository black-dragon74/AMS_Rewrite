<?php include_once 'top_scripts.php'; include_once 'top_side_nav.php'; ?>

<script>
    $(function () {
        $('ul.sidebar-menu li:nth-child(5)').addClass('active');
    })
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Helpful Contacts
            <small>using student data for demo</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('student') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Helpful Numbers</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <form method="post">
                    <div class="form-group">
                        <label>Department</label>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <select class="form-control" id="input-select-stream" required>
                                    <option value="">-- SELECT --</option>
                                    <?php
                                    $this->db->distinct();
                                    $this->db->select('stream');
                                    $res = $this->db->get('student');
                                    foreach ($res->result() as $tmp_row_stream){
                                        echo "<option value='{$tmp_row_stream->stream}'>$tmp_row_stream->stream</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <input type="submit" id="get-faculty-numbers" class="form-control btn btn-danger" value="Get Details">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="faculty-numbers" class="row">

        </div>
    </section>
</div>
<script>
    $('#get-faculty-numbers').on('click', function (e) {
        // Get selected stream from DOM
        const selected_stream = $('#input-select-stream').val();

        // Stop the submit button from posting the content
        e.preventDefault();

        if (selected_stream === ''){
            alert ('Select a stream first');
            return;
        }

        // Send an AJAX request to the AJAX handler to fetch list of items
        $.ajax({
            url: '<?php echo site_url("ajax/get_faculty_numbers")?>'+'/'+decodeURI(selected_stream),
            data: {
                'ams_ajax': 'true',
            },
            type: 'post',
            beforeSend: function () {
                $('#get-faculty-numbers').attr('value', "Loading...").prop("disabled", true);
            },
            success: function (response) {
                $('#get-faculty-numbers').attr('value', "Get Details").prop("disabled", false);
                $('div#faculty-numbers').empty().html(response);
            },
            error: function () {
                $('#get-faculty-numbers').attr('value', "Get Details").prop("disabled", false);
                alert('SERVER ERROR OCCOURED');
            }
        });
    });
</script>
<?php include_once 'footer.php'; include_once 'bottom_scripts.php';?>
