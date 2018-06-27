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
}