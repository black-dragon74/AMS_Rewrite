<?php

defined('BASEPATH') or die('Access denied');

class Ajax extends CI_Controller {

    /* AJAX helper class will only respond to ajax calls */
    public function __construct()
    {
        parent::__construct();
        if (!isset($_POST['ams_ajax'])) {
            die('ONLY AJAX ALLOWED');
        }
    }

    public function index(){
        echo "I only respond to AJAX calls";
    }

    public function get_faculty_numbers_where($arg1 = '', $arg2 = ''){
        // Replace html special chars back to real string
        $arg2 = str_replace('%20', ' ', $arg2);

        // Using student details as of now
        //$this->db->where($arg1, $arg2);

        $this->db->like($arg1, $arg2, 'after');
        $this->db->order_by('name', "ASC");
        $teacher = $this->db->get('teacher');
        $bg_counter = rand(1,3); $bg_color = '';
        $this->session->set_userdata('ajax_num_rows', $teacher->num_rows());
        if ($teacher->num_rows() != 0){
            foreach ($teacher->result() as $row){
                $bg_counter++;
                if ($bg_counter > 3) {
                    $bg_counter = 1;
                }
                switch ($bg_counter){
                    case 1:
                        $bg_color = 'bg-red-active';
                        break;
                    case 2:
                        $bg_color = 'bg-green-active';
                        break;
                    case 3:
                        $bg_color = 'bg-blue-active';
                        break;
                    default:
                        break;
                }
                echo '<div class="col-lg-4 col-md-6">
                        <div class="box box-widget widget-user">
                            <div class="widget-user-header '.$bg_color.'">
                                <h3 class="widget-user-username">'.$row->name.'</h3>
                                <h5 class="widget-user-desc">'.$row->designation.'</h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" src="'.$this->crud_model->get_profile_pic("teacher", $row->teacher_id).'" alt="User Avatar">
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12 border-bottom">
                                        <div class="description-block">
                                            <h5 class="description-header"><i class="fa fa-envelope"></i></h5>
                                            <span class="description-text">'.$row->email.'</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6 border-right border-bottom">
                                        <div class="description-block">
                                            <h5 class="description-header"><i class="fa fa-graduation-cap"></i></h5>
                                            <span class="description-text">'.$row->stream.'</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6 border-right border-bottom">
                                        <div class="description-block">
                                            <h5 class="description-header"><i class="fa fa-phone"></i></h5>
                                            <span class="description-text">'.$row->phone.'</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="description-block">
                                            <h5 class="description-header"><i class="fa fa-map-marker"></i></h5>
                                            <span class="description-text">'.$row->address.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        else {
            echo '<div class="col-lg-12 col-md-12 col-xs-12 text-bold text-center text-red">NO DATA FOR SELECTED QUERY</div>';
        }
    }

    public function ajax_num_rows(){
        echo $this->session->userdata('ajax_num_rows');
    }

    public function dump_stream_edit_modal(){
        // Get the stream ID
        $stream_id = $this->input->post('stream_id');

        // Create the form action url
        $action_url = site_url('admin/edit_stream/').$stream_id;

        // Get the list of available teachers
        $teacher = $this->db->get('teacher')->result();

        $optns = '';

        foreach ($teacher as $row){
            $optns .= "<option value='$row->teacher_id'>$row->name</option>";
        }

        // Get the current stream data based on stream ID
        $stream_details = $this->db->get_where('stream', array('stream_id' => $stream_id))->row();

        // Time to generate the ajax response for the modal
        echo '<div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit Stream</h3>
                    </div>
                    <div class="modal-body">
                        <form action="'.$action_url.'" id="stream-modal-edit" method="post">
                            <div class="form-group">
                                <label for="" class="control-label">Stream (Non-Editable)</label>
                                <input type="text" name="stream-name" class="form-control" placeholder="Stream" value="'.$stream_details->name.'" readonly="true">
                            </div>
                            <div class="form-group">
                                <label for="">Edit Teacher</label>
                                <select name="stream-teacher" id="" class="select2 form-control" style="width: 100%">
                                    '.$optns.'
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" form="stream-modal-edit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>';
    }

    public function section_details($streamID){
        // Connect to the db with the section ID
        $result = $this->db->get_where('section', array('stream_id' => $streamID));
        if ($result->num_rows() == 0){
            echo "empty!";
            exit();
        }
        else {
            foreach ($result->result() as $row){
                $stream_name = $this->db->get_where('stream', array('stream_id' => $row->stream_id))->row()->name;
                $section = $row->name;
                $teacher_name = $this->db->get_where('teacher', array('teacher_id' => $row->teacher_id))->row()->name;
                $delete_url = site_url('admin/delete_section/').$row->section_id;
                echo "<tr><td>$stream_name</td><td>$section</td><td>$teacher_name</td><td><a href='#' onclick='showConfirmModal(\"$delete_url\")'><span class='label label-success margin-r-5' style='font-size: 18px;'><i class='fa fa-pencil'></i></span></a><a href='#' onclick='showConfirmModal(\"$delete_url\")'><span class='label label-danger margin-r-5' style='font-size: 18px;'><i class='fa fa-trash'></i></span></a></td></tr>";
            }
        }
    }

    public function send_feedback(){
        $reply = $this->input->post('feedback-email');
        $name = $this->input->post('feedback-name');
        $feedback = $this->input->post('feedback-feedback');

        $config['mailtype'] = 'html';

        $this->load->library('email', $config);
        $this->email->to('nickk.2974@gmail.com');
        $this->email->from('ams@muj.edu', 'Manipal AMS');
        $this->email->reply_to($reply, $name);
        $this->email->subject('AMS Feedback');
        $this->email->message($feedback);

        // Send email
        if (!$this->email->send()){
            echo $this->email->print_debugger();
        }
        else {
            echo "sent";
        }
    }

    public function edit_parent_modal(){
        $parentID = $this->input->post('parentID');
        // Connect to the db and fetch the details
        $parent = $this->db->get_where('parent', array('parent_id' => $parentID))->row();
        $uid = $parent->uid;
        $name = $parent->name;
        $email = $parent->email;
        $phone = $parent->phone;
        $address = $parent->address;
        $profession = $parent->profession;

        // Output the data
        echo '<div class="row">
                        <div class="col-xs-12">
                            <p class="text-center text-red text-bold">Fields marked with an asterisk \'*\' must be unique if being updated.</p>
                            <form action="'.site_url('admin/edit_parent').'" method="post" autocomplete="off" id="edit-parent-form">
                                <input type="hidden" name="parent-id" value="'.$parent->parent_id.'" required>
                                <div class="form-group">
                                    <label for="parent-uid" class="control-label">User ID*</label>
                                    <input type="text" name="parent-uid" class="form-control" placeholder="Parent User ID" value="'.$uid.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="parent-name" class="control-label">Name</label>
                                    <input type="text" name="parent-name" class="form-control" placeholder="Parent Name" value="'.$name.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="parent-email" class="control-label">Email*</label>
                                    <input type="email" name="parent-email" class="form-control" placeholder="Parent Email" value="'.$email.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="parent-phone" class="control-label">Phone Number</label>
                                    <input type="text" name="parent-phone" class="form-control" placeholder="Phone Number" value="'.$phone.'" required>
                                </div>

                                <div class="form-group">
                                    <label for="parent-profession" class="control-label">Profession</label>
                                    <input type="text" name="parent-profession" class="form-control" placeholder="Profession" value="'.$profession.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="parent-address" class="control-label">Address</label>
                                    <textarea name="parent-address" rows="5" class="no-resize form-control"required>'.$address.'</textarea>
                                </div>
                            </form>
                        </div>
                    </div>';
    }

    public function edit_teacher_modal(){
        $teacherID = $this->input->post('teacherID');
        // Connect to the db and fetch the details
        $teacher = $this->db->get_where('teacher', array('teacher_id' => $teacherID))->row();
        $uid = $teacher->uid;
        $name = $teacher->name;
        $email = $teacher->email;
        $phone = $teacher->phone;
        $address = $teacher->address;
        $designation = $teacher->designation;

        $list = $this->db->get('stream')->result();

        $streams = '';
        foreach ($list as $sname){
            $streams .= '<option value="'.$sname->name.'">'.$sname->name.'</option>';
        }

        // Output the data
        echo '<div class="row">
                        <div class="col-xs-12">
                            <p class="text-center text-red text-bold">Fields marked with an asterisk \'*\' must be unique if being updated.</p>
                            <form action="'.site_url('admin/edit_teacher').'" method="post" autocomplete="off" id="edit-teacher-form">
                            <input type="hidden" name="teacher-id" value="'.$teacherID.'" required>
                                <div class="form-group">
                                    <label for="teacher-uid" class="control-label">User ID*</label>
                                    <input type="text" name="teacher-uid" class="form-control" placeholder="Teacher User ID" value="'.$uid.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-name" class="control-label">Name</label>
                                    <input type="text" name="teacher-name" class="form-control" placeholder="Teacher Name" value="'.$name.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-stream" class="control-label">Stream</label>
                                    <select name="teacher-stream" class="form-control select2">
                                        <option value="">-- SELECT --</option>
                                        '.$streams.'
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-designation" class="control-label">Designation</label>
                                    <input type="text" name="teacher-designation" class="form-control" placeholder="Teacher Designation" value="'.$designation.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-email" class="control-label">Email*</label>
                                    <input type="email" name="teacher-email" class="form-control" placeholder="Teacher Email" value="'.$email.'" required>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-address" class="control-label">Address</label>
                                    <textarea name="teacher-address" rows="5" class="no-resize form-control" required>'.$address.'</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="teacher-phone" class="control-label">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <strong>+91</strong>
                                        </div>
                                        <input type="text" pattern="\d*" name="teacher-phone" class="form-control" placeholder="Phone Number" maxlength="10" minlength="10" value="'.$phone.'" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>';
    }

    public function get_users(){
        $userType = $this->input->post('userType');
        $user = '<option value="">-- SELECT --</option>';

        $users = $this->db->get($userType)->result();

        foreach ($users as $t){
            $user .= '<option value="'.$t->uid.'">'.$t->uid.'</option>';
        }

        echo $user;
    }

    public function populate_stream_sections(){
        $streamID = $this->input->post('stream_id');

        // Get the section list
        $sections = $this->db->get_where('section', array('stream_id' => $streamID));

        if ($sections->num_rows() == 0){
            echo 'empty';
        }
        else {
            foreach ($sections->result() as $section){
                echo '<option value="'.$section->name.'">'.$section->name.'</option>';
            }
        }
    }

    public function student_ajax_table(){
        $streamID = $this->input->post('stream_id');
        $sectionName = $this->input->post('section_name');
        $students = '';

        if ($sectionName === 'empty'){
            $students = $this->db->get_where('student', array('stream' => $streamID));
        }
        else {
            $students = $this->db->get_where('student', array('stream' => $streamID, 'section' => $sectionName));
        }

        if ($students->num_rows() > 0){
            foreach ($students->result() as $student) {
                echo '<tr>
                <td>'.$student->student_code.'</td>
                <td>'.$student->name.'</td>
                <td>'.$student->stream.'</td>
                <td>'.$student->section.'</td>
                </tr>';
            }
        }
        else {
            echo '';
        }
    }
}