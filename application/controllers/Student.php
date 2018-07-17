<?php
/**
 * Created by nick.
 */

defined ('BASEPATH') or die('Direct access prohibitted');

class Student extends CI_Controller {


    private function studentOrGTFO(){ // Student or get the fuck out!
        if ($this->session->userdata('student_login') != 1){
            // Only students should access this area
            $this->session->set_flashdata('login_error', "You must login first!");
            redirect(site_url('login'.'?redirect='.uri_string()), 'refresh');
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->studentOrGTFO();
        $this->crud_model->clear_cache();
    }

    public function index(){
        // Student should never be able to use forceLogin parameter
        if ($this->crud_model->get_config('site_offline') == 'yes'){
            $data['title'] = 'Maintenance';
            $this->load->view('maintenance', $data);
            return;
        }

        $data['usertype'] = $this->session->userdata('login_type');
        $data['title'] = 'Student Dashboard';
        $this->load->view('student/dashboard', $data);
    }

    public function academic_overview(){
        $data['title'] = 'Acad Overview';
        $this->load->view('student/academic_overview', $data);
    }

    public function financial_overview(){
        $data['title'] = 'Financial Overview';
        $this->load->view('student/financial_overview', $data);
    }

    public function helpful_numbers(){
        $data['title'] = 'Helpful Numbers';
        $this->load->view('student/helpful_numbers', $data);
    }

    public function account_settings(){
        $data['title'] = 'Account Settings';
        $this->load->view('student/account_settings', $data);
    }

    public function update_password(){
        $password = $this->input->post('current-password');
        $newpassword = $this->input->post('new-password');
        $repassword = $this->input->post('re-password');

        // If all three passwords are same, redirect
        if ($password == $newpassword && $password == $repassword){
            $this->session->set_flashdata('error', "All three values are same");
            redirect(site_url('student/account_settings'), 'refresh');
        }

        // First of all, existing password should be correct
        $studID = $this->session->userdata('student_id');

        // Check for the password in the db
        $dbPass = $this->db->get_where('student', array('student_id' => $studID))->row()->password;

        // Verify db pass with the current password
        if (!password_verify($password, $dbPass)){
            $this->session->set_flashdata('error', "Existing password is incorrect!");
            redirect(site_url('student/account_settings'), 'refresh');
        }

        // Verify if the password and re password are equal
        if ($newpassword != $repassword) {
            $this->session->set_flashdata('error', "The new passwords do not match");
            redirect(site_url('student/account_settings'), 'refresh');
        }

        // Now if we are here it means that the both the new password and old passwords match
        // Update the data in the database;
        $this->db->where('student_id', $studID);
        $result = $this->db->update('student', array('password' => password_hash($newpassword, PASSWORD_BCRYPT)));

        if ($result){
            // Password is updated successfully
            $this->session->set_flashdata('success', "Password updated successfully!");
            redirect(site_url('student/account_settings'), 'refresh');
        }
        else {
            // This case won't ever come, still
            $this->session->set_flashdata('error', 'System error occoured!');
            redirect(site_url('student/account_settings'), 'refresh');
        }
    }

    function update_profile(){

        $username = $this->input->post('inputUser');
        $email = $this->input->post('inputEmail');

        // If all fields are empty, redirect with error
        if ($username == '' && $email == '' && $_FILES['inputImage']['tmp_name'] == '') {
            $this->session->set_flashdata('error', 'Empty values not allowed!');
            redirect(site_url('student/account_settings'), 'refresh');
        }

        // If username is not empty, update the username
        if (!empty($username)){

            // Student can't use a reserved username
            $disallowed_usernames = array(
                'admin',
                'administrator',
                'student',
                'parent',
                'teacher',
                'teachers'
            );

            foreach ($disallowed_usernames as $barred) {
                if ($username == $barred){
                    $this->session->set_flashdata('error', 'Chosen username is disallowed.');
                    redirect(site_url('student/account_settings'), 'refresh');
                }
            }

            // Check if it is taken
            $uid_taken = $this->db->get_where('student', array('uid' => $username));

            if ($uid_taken->num_rows() == 1) {
                // It is taken and hence we can't use this
                $this->session->set_flashdata('error', 'Username is already taken.');
                redirect(site_url('student/account_settings'), 'refresh');
            }
            else {
                // Update and updating profile details
                $this->db->where('student_id', $this->session->userdata('student_id'));
                $this->db->update('student', array('uid' => $username));
            }
        }

        // if email is not empty, update email
        if (!empty($email)) {
            // Connect to the db and check if the email address is already taken
            $result = $this->db->get_where('student', array('email' => $email));

            if ($result->num_rows() == 1){
                // Mail is already taken
                $this->session->set_flashdata('error', "Email is already taken. Use another email.");
                redirect(site_url('student/account_settings'), 'refresh');
            }
            else {
                // Email is unique, need to update it in the db
                $this->db->where('student_id', $this->session->userdata('student_id'));
                $this->db->update('student', array('email' => $email));
            }
        }

        // Update profile pic
        $this->crud_model->update_profile_pic('inputImage', 'student');

        // Redirect
        $this->session->set_flashdata('success', "Profile updated successfully!");
        redirect(site_url('student/account_settings'), 'header');
    }
}