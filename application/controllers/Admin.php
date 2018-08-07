<?php
/**
 * Created by nick.
 */

defined ('BASEPATH') or die('Direct access prohibitted');

class Admin extends CI_Controller {

    private function adminOrGTFO(){ // Admin or get the fuck out!
        if ($this->session->userdata('admin_login') != 1){
            // Only admins should access this area
            $this->session->set_flashdata('login_error', "You must login first!");
            redirect(site_url('login'.'?redirect='.uri_string()), 'refresh');
        }
    }


    public function __construct()
    {
        parent::__construct();
        $this->adminOrGTFO();
    }

    public function index(){
        if ($this->session->userdata('admin_login') != 1){
            // Only admins should access this area
            $this->session->set_flashdata('login_error', "Invalid admin access rerouted!");
            redirect(site_url('login'), 'refresh');
        }
        $data['usertype'] = $this->session->userdata('login_type');
        $data['title'] = 'Admin CP';
        $this->load->view('admin/dashboard', $data);
    }

    public function account_settings(){
        $data['title'] = 'Account Settings';
        $this->load->view('admin/account_settings', $data);
    }

    public function update_password(){
        $password = $this->input->post('current-password');
        $newpassword = $this->input->post('new-password');
        $repassword = $this->input->post('re-password');

        // If all three passwords are same, redirect
        if ($password == $newpassword && $password == $repassword){
            $this->session->set_flashdata('error', "All three values are same");
            redirect(site_url('admin/account_settings'), 'refresh');
        }

        // First of all, existing password should be correct
        $studID = $this->session->userdata('admin_id');

        // Check for the password in the db
        $dbPass = $this->db->get_where('admin', array('admin_id' => $studID))->row()->password;

        // Verify db pass with the current password
        if (!password_verify($password, $dbPass)){
            $this->session->set_flashdata('error', "Existing password is incorrect!");
            redirect(site_url('admin/account_settings'), 'refresh');
        }

        // Verify if the password and re password are equal
        if ($newpassword != $repassword) {
            $this->session->set_flashdata('error', "The new passwords do not match");
            redirect(site_url('admin/account_settings'), 'refresh');
        }

        // Now if we are here it means that the both the new password and old passwords match
        // Update the data in the database;
        $this->db->where('admin_id', $studID);
        $result = $this->db->update('admin', array('password' => password_hash($newpassword, PASSWORD_BCRYPT)));

        if ($result){
            // Password is updated successfully
            $this->session->set_flashdata('success', "Password updated successfully!");
            redirect(site_url('admin/account_settings'), 'refresh');
        }
        else {
            // This case won't ever come, still
            $this->session->set_flashdata('error', 'System error occoured!');
            redirect(site_url('admin/account_settings'), 'refresh');
        }
    }

    public function update_profile(){

        $username = $this->input->post('inputUser');
        $email = $this->input->post('inputEmail');

        // If all fields are empty, redirect with error
        if ($username == '' && $email == '' && $_FILES['inputImage']['tmp_name'] == '') {
            $this->session->set_flashdata('error', 'Empty values not allowed!');
            redirect(site_url('admin/account_settings'), 'refresh');
        }

        // If username is not empty, update the username
        if (!empty($username)){


            // Check if it is taken
            $uid_taken = $this->db->get_where('admin', array('uid' => $username));

            if ($uid_taken->num_rows() == 1) {
                // It is taken and hence we can't use this
                $this->session->set_flashdata('error', 'Username is already taken.');
                redirect(site_url('admin/account_settings'), 'refresh');
            }
            else {
                // Update and updating profile details
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', array('uid' => $username));
            }
        }

        // if email is not empty, update email
        if (!empty($email)) {
            // Connect to the db and check if the email address is already taken
            $result = $this->db->get_where('admin', array('email' => $email));

            if ($result->num_rows() == 1){
                // Mail is already taken
                $this->session->set_flashdata('error', "Email is already taken. Use another email.");
                redirect(site_url('admin/account_settings'), 'refresh');
            }
            else {
                // Email is unique, need to update it in the db
                $this->db->where('admin_id', $this->session->userdata('admin_id'));
                $this->db->update('admin', array('email' => $email));
            }
        }

        // Update profile pic
        $this->crud_model->update_profile_pic('inputImage', 'admin');

        // Redirect
        $this->session->set_flashdata('success', "Profile updated successfully!");
        redirect(site_url('admin/account_settings'), 'header');
    }

    // Function to initiate notice view
    public function manage_notices(){
        $data['title'] = 'Manage Notices';
        $this->load->view('admin/notices', $data);
    }

    // Function to add notice
    public function add_notice(){
        $notice=$this->input->post('notice');
        $stream=$this->input->post('stream');

        $this->db->insert('notices', array('notice' => $notice, 'stream' => $stream));

        // Set flash data
        $this->session->set_flashdata('notice_success', 'Notice added successfully!');

        // Refresh
        redirect(site_url('admin/manage_notices'), 'refresh');
    }

    // Function to delete a notice
    public function delete_notice($noticeID = ''){
        // Notice id is to be supplied by the form
        $this->db->delete('notices', array('notice_id' => $noticeID));

        // Set flash data
        $this->session->set_flashdata('notice_success', 'Notice trashed successfully!');

        // Refresh
        redirect(site_url('admin/manage_notices'), 'refresh');
    }

    public function edit_notice(){
        $noticeID = $this->input->post('modal-notice-id');
        $noticeContent = $this->input->post('modal-notice');

        // Update the notice in the db
        $this->db->where('notice_id', $noticeID);
        $this->db->update('notices', array('notice' => $noticeContent));

        // Set success flashdata and tell the user of the same
        $this->session->set_flashdata('notice_success', 'Notice edited successfully!');

        // Redirect
        redirect(site_url('admin/manage_notices'), 'refresh');
    }

    public function manage_streams(){
        $data['title'] = 'Add Streams';
        $this->load->view('admin/add_stream', $data);
    }

    public function delete_stream($streamID){
        // Delete the data
        $this->db->delete('stream', array('stream_id' => $streamID));

        // Set success flashdata and tell the user of the same
        $this->session->set_flashdata('stream_success', 'Stream deleted successfully!');

        // Redirect
        redirect(site_url('admin/manage_streams'), 'refresh');
    }

    public function add_stream(){
        // Get the POST data
        $stream_name = $this->input->post('stream-name');
        $stream_teacher = $this->input->post('stream-teacher');

        // Check if the data is already existent in the table
        $num_rows = $this->db->get_where('stream', array('name' => $stream_name))->num_rows();
        if ($num_rows > 0) {
            // Stream already exists and it is an error
            $this->session->set_flashdata('stream_error', "The stream already exists");
            redirect(site_url('admin/manage_streams'), 'refresh');
        }
        else {
            // Insert the data into the streams table
            $this->db->insert('stream', array('name' => $stream_name, 'teacher_id' => $stream_teacher));

            // Success
            $this->session->set_flashdata('stream_success', "Stream Added Successfully!");

            redirect(site_url('admin/manage_streams'), 'refresh');
        }
    }

    public function edit_stream($streamID){
        // Check if the stream name is existent in the DB
        $stream_name = $this->input->post('stream-name');
        $stream_teacher = $this->input->post('stream-teacher');

        // Update the details in the DB
        $this->db->where('stream_id', $streamID);
        $this->db->update('stream', array('name' => $stream_name, 'teacher_id' => $stream_teacher));

        // Redirect with success message
        $this->session->set_flashdata('stream_success', "Stream edited successfully!");

        redirect(site_url('admin/manage_streams'), 'refresh');

    }


    /* Handle Sections */
    public function manage_sections(){
        $data['title'] = 'Manage Sections';
        $this->load->view('admin/add_sections', $data);
    }

    public function add_section(){
        $section_name = $this->input->post('add-section-name');
        $section_teacher = $this->input->post('add-section-teacher');
        $section_stream = $this->input->post('add-section-stream');

        // Check if section already exists
        if ($this->db->get_where('section', array('name' => $section_name, 'stream_id' => $section_stream))->num_rows() > 0){
            $this->session->set_flashdata('section_error', "Section Already Exists!");
            redirect(site_url('admin/manage_sections'), 'refresh');
        }
        else {
            $this->db->insert('section', array('stream_id' => $section_stream, 'teacher_id' => $section_teacher, 'name' => $section_name));
            $this->session->set_flashdata('section_success', "Section Added Successfully!");
            redirect(site_url('admin/manage_sections'), 'refresh');
        }
    }

    public function delete_section($sectionID){
        if ($this->db->delete('section', array('section_id' => $sectionID))) {
            // Success
            $this->session->set_flashdata('section_success', 'Section deleted successfully!');
            redirect(site_url('admin/manage_sections'));
        }
        else {
            // Error
            $this->session->set_flashdata('section_error', 'Section delete failed!');
            redirect(site_url('admin/manage_sections'));
        }
    }

    public function staff_numbers(){
        $data['title'] = 'Staff Numbers';
        $this->load->view('admin/numbers', $data);
    }

    /* Handle Parents */
    public function manage_parents(){
        $data['title'] = 'Manage Parents';
        $this->load->view('admin/parents', $data);
    }

    // Function to add parents
    public function add_parents(){
        $userID = $this->input->post('parent-uid');
        $name = $this->input->post('parent-name');
        $email = $this->input->post('parent-email');
        $password = password_hash($this->input->post('parent-password'), PASSWORD_BCRYPT);
        $password_hint = $this->input->post('parent-password-hint');
        $phone = $this->input->post('parent-phone');
        $profession = $this->input->post('parent-profession');
        $address = $this->input->post('parent-address');

        // Check if the parent is existent in the db

        if ($this->db->get_where('parent', array('email' => $email))->num_rows() > 0){
            // Redirect with error
            $this->session->set_flashdata('parent_error', 'Email already taken!');
            redirect(site_url('admin/manage_parents'), 'refresh');
        }
        elseif ($this->db->get_where('parent', array('uid' => $userID))->num_rows() > 0){
            // Redirect with error
            $this->session->set_flashdata('parent_error', 'User ID already taken!');
            redirect(site_url('admin/manage_parents'), 'refresh');
        }
        else {
            // Insert the data in the db
            $result = $this->db->insert('parent', array(
                'uid' => $userID,
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'password_hint' => $password_hint,
                'phone' => $phone,
                'address' => $address,
                'profession' => $profession
            ));

            if ($result){
                // Redirect with success
                $this->session->set_flashdata('parent_success', 'Parent Added Successfully!');
                redirect(site_url('admin/manage_parents'), 'refresh');
            }
            else {
                // Redirect with error
                $this->session->set_flashdata('parent_error', 'Unable to add parent. Undefined Error!');
                redirect(site_url('admin/manage_parents'), 'refresh');
            }
        }
    }

    // Function to edit parents
    public function edit_parent(){
        $pID = $this->input->post('parent-id');
        $userID = $this->input->post('parent-uid');
        $name = $this->input->post('parent-name');
        $email = $this->input->post('parent-email');
        $phone = $this->input->post('parent-phone');
        $profession = $this->input->post('parent-profession');
        $address = $this->input->post('parent-address');

        // Check for userID uniqueness
        $this->db->where('uid', $userID);
        $result = $this->db->get('parent');
        // If there is a match it should be of the same user else it is an error
        if ($result->num_rows() > 0){
            // Check if it is of same user
            if ($result->row()->parent_id != $pID){
                // Redirect with error
                $this->session->set_flashdata('parent_error', 'User ID already taken!');
                redirect(site_url('admin/manage_parents'), 'refresh');
            }
        }

        // Check for email uniqueness
        $this->db->where('email', $email);
        $result = $this->db->get('parent');
        // If there is a match it should be of the same user else it is an error
        if ($result->num_rows() > 0){
            // Check if it is of same user
            if ($result->row()->parent_id != $pID){
                // Redirect with error
                $this->session->set_flashdata('parent_error', 'Email already taken!');
                redirect(site_url('admin/manage_parents'), 'refresh');
            }
        }

        // All checks passed, Insert data in the db
        $this->db->where('parent_id', $pID);
        $result = $this->db->update('parent', array(
            'uid' => $userID,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'profession' => $profession
        ));

        if ($result){
            // Redirect with success
            $this->session->set_flashdata('parent_success', 'Parent Updated Successfully!');
            redirect(site_url('admin/manage_parents'), 'refresh');
        }
        else {
            // Redirect with error
            $this->session->set_flashdata('parent_error', 'Unable to edit parent. Undefined Error!');
            redirect(site_url('admin/manage_parents'), 'refresh');
        }
    }

    // Function to delete parent
    public function delete_parent($parentID){
        $this->db->delete('parent', array('parent_id' => $parentID));
        // Redirect with success
        $this->session->set_flashdata('parent_success', 'Parent Deleted Successfully!');
        redirect(site_url('admin/manage_parents'), 'refresh');
    }

    /* Teachers section starts here */
    public function manage_teachers(){
        $data['title'] = 'Manage Teachers';
        $this->load->view('admin/teachers', $data);
    }

    public function add_teachers(){
        // Input fields to fetch from teacher modal
        $teacherUID = $this->input->post('teacher-uid');
        $teacherName = $this->input->post('teacher-name');
        $teacherStream = $this->input->post('teacher-stream');
        $teacherDesignation = $this->input->post('teacher-designation');
        $teacherBirthday = $this->input->post('teacher-birthday');
        $teacherSex = $this->input->post('teacher-sex');
        $teacherBlood = $this->input->post('teacher-blood');
        $teacherEmail = $this->input->post('teacher-email');
        $teacherPassword = $this->input->post('teacher-password');
        $teacherPasswordHint = $this->input->post('teacher-password-hint');
        $teacherAddress = $this->input->post('teacher-address');
        $teacherPhone = $this->input->post('teacher-phone');

        // Check if the user id is unique
        if ($this->db->get_where('teacher', array('uid' => $teacherUID))->num_rows() > 0){
            // Error, user id should be unique
            $this->crud_model->redirect('teacher_error', 'User ID is already taken', site_url('admin/manage_teachers'));
        }
        elseif ($this->db->get_where('teacher', array('email' => $teacherEmail))->num_rows() > 0) {
            // Error, email should be unique
            $this->crud_model->redirect('teacher_error', 'Email is already taken', site_url('admin/manage_teachers'));
        }
        else {
            // Valid entry, insert into db
            $this->db->insert('teacher', array(
                'uid' => $teacherUID,
                'name' => $teacherName,
                'email' => $teacherEmail,
                'password' => password_hash($teacherPassword, PASSWORD_BCRYPT),
                'hint' => $teacherPasswordHint,
                'designation' => $teacherDesignation,
                'blood_group' => $teacherBlood,
                'phone' => $teacherPhone,
                'address' => $teacherAddress,
                'sex' => $teacherSex,
                'stream' => $teacherStream,
                'birthday' => $teacherBirthday
            ));

            // Redirect with success
            $this->crud_model->redirect('teacher_success', 'Teacher Added Successfully!', site_url('admin/manage_teachers'));
        }
    }

    public function edit_teacher(){
        // Input fields to fetch
        $teacherID = $this->input->post('teacher-id');
        $teacherUID = $this->input->post('teacher-uid');
        $teacherName = $this->input->post('teacher-name');
        $teacherStream = $this->input->post('teacher-stream');
        $teacherDesignation = $this->input->post('teacher-designation');
        $teacherEmail = $this->input->post('teacher-email');
        $teacherAddress = $this->input->post('teacher-address');
        $teacherPhone = $this->input->post('teacher-phone');

        // Store the details of specific teacher as a row array
        $teacherDetails = $this->db->get_where('teacher', array('teacher_id' => $teacherID))->row();

        // Check if user name is already taken by another user
        if ($this->db->get_where('teacher', array('uid' => $teacherUID))->row()->teacher_id != $teacherDetails->teacher_id){
            // Galat ho gya na bhai
            $this->crud_model->redirect('teacher_error', 'User ID is already taken', site_url('admin/manage_teachers'));
        }
        // Same check for email
        elseif ($this->db->get_where('teacher', array('email' => $teacherEmail))->row()->teacher_id != $teacherDetails->teacher_id){
            // Galat ho gya na bhai
            $this->crud_model->redirect('teacher_error', 'Email is already taken', site_url('admin/manage_teachers'));
        }
        else {
            // Time to update the details
            $insertData = array(
                'uid' => $teacherUID,
                'name' => $teacherName,
                'designation' => $teacherDesignation,
                'email' => $teacherEmail,
                'address' => $teacherAddress,
                'phone' => $teacherPhone
            );

            // If stream is to be updated, add it to the array
            if ($teacherStream != ''){
                $insertData['stream'] = $teacherStream;
            }

            // Time to update the details
            $this->db->where('teacher_id', $teacherID);
            $this->db->update('teacher', $insertData);

            // Redirect with success
            $this->crud_model->redirect('teacher_success', 'Details Updated Successfully!', site_url('admin/manage_teachers'));
        }
    }

    public function delete_teacher($teacherID){
        $this->db->delete('teacher', array('teacher_id' => $teacherID));
        // Redirect with success
        $this->session->set_flashdata('teacher_success', 'Teacher Deleted Successfully!');
        redirect(site_url('admin/manage_teachers'), 'refresh');
    }

    public function reset_access(){
        $role = $this->input->post('access-role');
        $userID = $this->input->post('access-user');

        if ($role == '' || $userID == ''){
            $this->crud_model->redirect('admin_error', 'Direct access not allowed', site_url('admin'));
        }
        else {
            // Reset the user
            $defaultPassword = $this->crud_model->get_config('default_password');
            $password = password_hash($defaultPassword, PASSWORD_BCRYPT);
            $this->db->where('uid', $userID);
            $this->db->update($role, array('password' => $password));
            $this->crud_model->redirect('admin_success', 'Account reset to default password as per config.', site_url('admin'));
        }
    }

    public function update_default_password() {
        $defaultPass = $this->input->post('default-password');

        if  ($defaultPass == ''){
            $this->crud_model->redirect('admin_error', 'Direct Access not allowed', site_url('admin'));
        }
        else {
            if ($this->crud_model->set_config('default_password', $defaultPass)) {
                $this->crud_model->redirect('admin_success', 'Default password updated!', site_url('admin'));
            }
            else {
                $this->crud_model->redirect('admin_error', 'Undefined error!!', site_url('admin'));
            }
        }
    }

    public function update_site_status() {
        $siteState = $this->input->post('site-offline-select');

        if ($siteState == ''){
            $this->crud_model->redirect('admin_error', 'Invalid access re-routed', site_url('admin'));
        }
        else {
            // Set config and redirect
            if ($this->crud_model->set_config('site_offline', $siteState)) {
                $this->crud_model->redirect('admin_success', 'Site active state changed!', site_url('admin'));
            }
            else {
                $this->crud_model->redirect('admin_error', 'Undefined Error!', site_url('admin'));
            }
        }
    }

    public function admit_student(){
        $data['title'] = 'Admit Student';
        $this->load->view('admin/admit_student', $data);
    }

    public function enroll_student()
    {
        // Declare the variables to be used in student table
        $studentUID = $this->input->post('student-user-id');
        $studentRegNo = $this->input->post('student-reg-no');
        $studentName = $this->input->post('student-full-name');
        $studentParent = $this->input->post('student-parent');
        $studentClass = $this->input->post('student-class');
        $studentSection = !empty($this->input->post('student-section')) ? $this->input->post('student-section') : 'empty';
        $studentDOB = $this->input->post('student-birthday');
        $studentSex = $this->input->post('student-gender');
        $studentBlood = $this->input->post('student-blood');
        $studentAddress = $this->input->post('student-address');
        $studentPhone = $this->input->post('student-phone');
        $studentEmail = $this->input->post('student-email');
        $studentPassword = $this->input->post('student-password');
        $studentPasswordHint = $this->input->post('student-password-hint');

        // Prevent direct access
        if (! isset($studentDOB)){
            $this->crud_model->redirect('student_error', 'Invalid form submission.', site_url('admin/admit_student'));
        }

        // No need to worry about the empty values as they are taken care of in the form
        // Let's focus on putting the data in the db.
        $studentDataDB = array(
            'uid' => $studentUID,
            'student_code' => $studentRegNo,
            'name' => $studentName,
            'parent_id' => $studentParent,
            'stream' => $studentClass,
            'section' => $studentSection,
            'birthday' => $studentDOB,
            'sex' => $studentSex,
            'blood_group' => $studentBlood,
            'address' => $studentAddress,
            'phone' => $studentPhone,
            'email' => $studentEmail,
            'password' => password_hash($studentPassword, PASSWORD_BCRYPT),
            'password_hint' => $studentPasswordHint
        );

        // Check for duplicate userID
        if ($this->db->get_where('student', array('uid' => $studentDataDB['uid']))->num_rows() > 0) {
            $this->crud_model->redirect('student_error', 'User ID is already taken.', site_url('admin/admit_student'));
        }
        // Check for duplicate reg no
        elseif ($this->db->get_where('student', array('student_code' => $studentDataDB['student_code']))->num_rows() > 0) {
            $this->crud_model->redirect('student_error', 'Duplicate registration number.', site_url('admin/admit_student'));
        }
        // Check for duplicate email
        elseif ($this->db->get_where('student', array('email' => $studentDataDB['email']))->num_rows() > 0) {
            $this->crud_model->redirect('student_error', 'Duplicate email not allowed.', site_url('admin/admit_student'));
        }
        // DO your thing
        else {
            $dataInserted = $this->db->insert('student', $studentDataDB);

            if ($dataInserted){
                // Great!
                $this->crud_model->redirect('student_success', 'Data Inserted Successfully', site_url('admin/admit_student'));
            }
            else {
                $this->crud_model->redirect('student_error', 'Data Insertion Failed', site_url('admin/admit_student'));
            }
        }
    }

    public function student_details(){
        $this->load->view('admin/student_details', array('title' => 'Student Details'));
    }
}