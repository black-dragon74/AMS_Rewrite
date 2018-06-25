<?php
/**
 * Created by nick.
 */

defined ('BASEPATH') or die ('NO direct access allowes');

class Login extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        if ($this->session->userdata('admin_login') == 1){
            redirect(site_url('admin'), 'refresh');
        }
        if ($this->session->userdata('student_login') == 1){
            redirect(site_url('student'), 'refresh');
        }

        if ($this->session->userdata('parent_login') == 1){
            redirect(site_url('parents'), 'refresh');
        }

        $data['title'] = "Login";
        $this->load->view('view_login', $data);
    }

    private function checkAccess() {
    	if ($this->session->userdata('login_user_id') == '') {
    		// User not logged in yet, redirect
    		$this->session->set_flashdata('login_error', 'You must login first');
    		redirect (site_url('login'), 'refresh');
    	}
    }
    // TODO use CRUD for parent, teacher and admin auth

    public function validate_login(){

        $hint = '';

        $password = $this->input->post('password');

        // Check for admin
        $row = $this->crud_model->get_login_info('email', 'admin');
        if (isset($row->password)){
            if (password_verify($password, $row->password)){
                // Login is successful
                $this->session->set_userdata('admin_login', '1');
                $this->session->set_userdata('admin_id', $row->admin_id);
                $this->session->set_userdata('login_user_id', $row->admin_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'admin');

                // Action to do post login success (redirect)
                $redir = $this->input->get('redirect');
                if (!empty($redir)){
                    redirect(site_url($redir), 'refresh');
                }
                else {
                    redirect(site_url('admin'), 'refresh');
                }
            }
            $hint = $row->password_hint;
        }

        // Check for student
        $row = $this->crud_model->get_login_info('email', 'student');
        if (isset($row->password)){
            if (password_verify($password, $row->password)){
                // Login is successful
                $this->session->set_userdata('student_login', '1');
                $this->session->set_userdata('student_id', $row->student_id);
                $this->session->set_userdata('login_user_id', $row->student_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'student');

                // Action to do post login success (redirect)
                $redir = $this->input->get('redirect');
                if (!empty($redir)){
                    redirect(site_url($redir), 'refresh');
                }
                else {
                    redirect(site_url('student'), 'refresh');
                }
            }
            $hint = $row->password_hint;
        }

        // Check for parent
        $row = $this->crud_model->get_login_info('email', 'parent');
        if (isset($row->password)){
            if (password_verify($password, $row->password)){
                // Login is successful
                $this->session->set_userdata('parent_login', '1');
                $this->session->set_userdata('parent_id', $row->parent_id);
                $this->session->set_userdata('login_user_id', $row->parent_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'parent');

                // Action to do post login success (redirect)
                $redir = $this->input->get('redirect');
                if (!empty($redir)){
                    redirect(site_url($redir), 'refresh');
                }
                else {
                    redirect(site_url('parents'), 'refresh');
                }
            }
            $hint = $row->password_hint;
        }

        // Check for teacher
        $row = $this->crud_model->get_login_info('email', 'teacher');
        if (isset($row->password)){
            if (password_verify($password, $row->password)){
                // Login is successful
                $this->session->set_userdata('teacher_login', '1');
                $this->session->set_userdata('teacher_id', $row->teacher_id);
                $this->session->set_userdata('login_user_id', $row->teacher_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'teacher');

                // Action to do post login success (redirect)
                $redir = $this->input->get('redirect');
                if (!empty($redir)){
                    redirect(site_url($redir), 'refresh');
                }
                else {
                    redirect(site_url('teacher'), 'refresh');
                }
            }
            $hint = $row->password_hint;
        }

        // If code comes here it means login has failed
        // Redirect to login with the error message
        if (trim($hint) != ''){
            $this->session->set_flashdata('hint', $hint);
        }
        $this->session->set_flashdata('login_error', "Login failed. Check your credentials");
        redirect(site_url('login'), 'refresh');
    }

    // Forgot password method (just loads forgot password view)
    public function forgot_password(){
        $data['title'] = "Reset Password";
        $this->load->view('view_forgot', $data);
    }

    private function send_reset_mail($email, $msg){
        // Load the mailer library
        $config['mailtype'] = 'html';
        $this->load->library('email');

        $this->email->from('ams@muj.edu', 'Manipal AMS');
        $this->email->to($email);

        $this->email->subject("AMS Password Reset");
        $this->email->message($msg);

        if (!$this->email->send()){
            show_error($this->email->print_debugger());
        }
    }

    // Reset password method. Does the actual reset
    public function reset_password(){

        $email = $this->input->post('email');

        // Check if email is valid for admin
        $sql = $this->db->get_where('admin', array('email' => $email));
        if ($sql->num_rows() > 0) {
            // Email is of admin. Start resetting now
            $newpassword = substr( md5( rand(100000000,20000000000) ) , 0,7); // New random password

            // Hash the password
            $sendpassword = array(
              'password' => password_hash($newpassword, PASSWORD_BCRYPT)
            );

            // Update the new password in the dp
            $this->db->where('email', $email);
            $this->db->update('admin', $sendpassword);

            // Send password reset mail
            $this->send_reset_mail($email, "Hello,<br />Your new password is: <b>$newpassword</b><br/>-Manipal University, Jaipur");

            $this->session->set_flashdata('reset_success', "An Email with password has been sent.");
            redirect(site_url('login/forgot_password'), 'refresh');
        }

        // Check if email is valid for student
        $sql = $this->db->get_where('student', array('email' => $email));
        if ($sql->num_rows() > 0) {
            // Email is of student. Start resetting now
            $newpassword = substr( md5( rand(100000000,20000000000) ) , 0,7); // New random password

            // Hash the password
            $sendpassword = array(
                'password' => password_hash($newpassword, PASSWORD_BCRYPT)
            );

            // Update the new password in the dp
            $this->db->where('email', $email);
            $this->db->update('student', $sendpassword);

            // Send password reset mail
            $this->send_reset_mail($email, "Hello,<br />Your new password is: <b>$newpassword</b><br/>-Manipal University, Jaipur");

            $this->session->set_flashdata('reset_success', "An Email with password has been sent.");
            redirect(site_url('login/forgot_password'), 'refresh');
        }

        // Check if email is valid for parent
        $sql = $this->db->get_where('parent', array('email' => $email));
        if ($sql->num_rows() > 0) {
            // Email is of parent. Start resetting now
            $newpassword = substr( md5( rand(100000000,20000000000) ) , 0,7); // New random password

            // Hash the password
            $sendpassword = array(
                'password' => password_hash($newpassword, PASSWORD_BCRYPT)
            );

            // Update the new password in the dp
            $this->db->where('email', $email);
            $this->db->update('parent', $sendpassword);

            // Send password reset mail
            $this->send_reset_mail($email, "Hello,<br />Your new password is: <b>$newpassword</b><br/>-Manipal University, Jaipur");

            $this->session->set_flashdata('reset_success', "An Email with password has been sent.");
            redirect(site_url('login/forgot_password'), 'refresh');
        }

        // If the code comes to this line it means invalid email has been supplied
        // View the message to the user and do the needful
        $this->session->set_flashdata('reset_error', 'Invalid email address');
        redirect(site_url('login/forgot_password'), 'refresh');
    }

    // Logout function
    public function logout(){
    	// Reroute direct calls to this method
    	$this->checkAccess();

        // Dev note: Destroying a session also removes flash data
        // Using unset_userdata instead
        $session_vars = array(
            'admin_login',
            'admin_id',
            'student_login',
            'student_id',
            'parent_login',
            'parent_id',
            'teacher_login',
            'teacher_id',
            'librarian_login',
            'librarian_id',
            'accountant_login',
            'accountant_id',
            'login_user_id',
            'name',
            'login_type',
            'ajax_num_rows'
        );

        // Unset sessions now
        $this->session->unset_userdata($session_vars);

        // Set flash data
        $this->session->set_flashdata('logout_notification', 'Logged out successfully!');

        // Redirect to login page
        redirect(site_url('login'), 'refresh');
    }
}