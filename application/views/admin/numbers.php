<?php include_once 'top_scripts.php' ?>

<?php include_once 'top_side_nav.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Staff Numbers
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Dashboard</li>
            <li class="active">Staff Numbers</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <form method="post">
                    <div class="form-group">
                        <label>Select Department</label>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <select class="form-control" id="input-select-stream" required>
                                    <option value="">-- SELECT --</option>
                                    <?php
                                    $this->db->distinct();
                                    $this->db->select('name');
                                    $this->db->order_by('name', 'ASC');
                                    $res = $this->db->get('stream');
                                    foreach ($res->result() as $tmp_row_stream){
                                        echo "<option value='{$tmp_row_stream->name}'>$tmp_row_stream->name</option>";
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
                <div class="row text-bold text-center text-info">
                    - OR -
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xs-12">
                        <form method="post">
                            <div class="form-group">
                                <label>Live faculty search</label>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="input-group col-xs-12">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                            <input type="text" class="form-control" id="live-search-faculty">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6 text-center">
                                        <div class="callout callout-danger" id="live-search-result-number" style="padding: 7px !important; transition: all .5s;">Found 0 matches.</div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="faculty-numbers" class="row">

        </div>
    </section>
</div>
<script type="text/javascript">
    $(function () {
        // Set sidebar active
        $('ul.sidebar-menu > li:nth-child(10)').addClass('active');
    })
</script>
<!-- Script to handle AJAX request by stream type -->
<script>
    $('#get-faculty-numbers').on('click', function (e) {
        // Get selected stream from DOM
        const selected_stream = $('#input-select-stream').val();

        // Stop the submit button from posting the content
        e.preventDefault();

        if (selected_stream === ''){
            alert ('Please select a department');
            return;
        }

        // Send an AJAX request to the AJAX handler to fetch list of items
        $.ajax({
            url: '<?php echo site_url("ajax/get_faculty_numbers_where")?>'+'/'+'stream'+'/'+selected_stream,
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

<!-- AJAX request to handle live search -->
<script>
    $('#live-search-faculty').keyup(function () {
        var this_val = $.trim($(this).val());
        if (this_val === ''){
            $('div#faculty-numbers').empty();
            $('#live-search-result-number').empty().html('Found 0 matches.').removeClass().addClass('callout callout-danger');
            return;
        }

        // Allow only albhabets
        var regex = /^[a-zA-Z ]*$/;
        if (!regex.test(this_val)) {
            alert ('Only albhabets allowed');
            $('#live-search-faculty').val('').focus();
            $('div#faculty-numbers').empty();
            $('#live-search-result-number').empty().html('Found 0 matches.').removeClass().addClass('callout callout-danger');
            return;
        }

        // Ajax to fetch live values
        $.ajax({
            url: '<?php echo site_url("ajax/get_faculty_numbers_where")?>'+'/'+'name'+'/'+this_val,
            data: 'ams_ajax=true',
            type: 'post',
            success: function (response) {
                $('div#faculty-numbers').empty().html(response);
            },
            error: function () {
                alert('SERVER ERROR OCCOURED');
            }
        });

        // Delay the second ajax request to give some
        setTimeout(function () {
            // AJAX to update callout for num_rows
            $.ajax({
                url: '<?php echo site_url("ajax/ajax_num_rows")?>',
                data: 'ams_ajax=true',
                type: 'post',
                success: function (response) {
                    if (response > 0){
                        $('#live-search-result-number').empty().html('Found '+response+' matches.').removeClass().addClass('callout callout-success');
                    }
                    else {
                        $('#live-search-result-number').empty().html('Found 0 matches.').removeClass().addClass('callout callout-danger');
                    }
                }
            });
        },100);
    });
</script>

<?php include_once 'footer.php' ?>
<?php include_once 'bottom_scripts.php' ?>
