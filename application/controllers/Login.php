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

    public function validate_login(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Check for admin
        $query = $this->db->get_where('admin', array('email' => $email));
        if ($query->num_rows() > 0){
            $row = $query->row(); // Gets a single row
            if (password_verify($password, $row->password)){
                // Login is successful
                $this->session->set_userdata('admin_login', '1');
                $this->session->set_userdata('admin_id', $row->admin_id);
                $this->session->set_userdata('login_user_id', $row->admin_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'admin');

                // Action to do post login success (redirect)
                redirect(site_url('admin'), 'refresh');
            }
        }

        // Check for student
        $query = $this->db->get_where('student', array('email' => $email));
        if ($query->num_rows() > 0){
            $row = $query->row(); // Gets a single row
            if (password_verify($password, $row->password)){
                // Login is successful
                $this->session->set_userdata('student_login', '1');
                $this->session->set_userdata('student_id', $row->student_id);
                $this->session->set_userdata('login_user_id', $row->student_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'student');

                // Action to do post login success (redirect)
                redirect(site_url('student'), 'refresh');
            }
        }

        // Check for parent
        $query = $this->db->get_where('parent', array('email' => $email));
        if ($query->num_rows() > 0){
            $row = $query->row(); // Gets a single row
            if (password_verify($password, $row->password)){
                // Login is successful
                $this->session->set_userdata('parent_login', '1');
                $this->session->set_userdata('parent_id', $row->parent_id);
                $this->session->set_userdata('login_user_id', $row->parent_id);
                $this->session->set_userdata('name', $row->name);
                $this->session->set_userdata('login_type', 'parent');

                // Action to do post login success (redirect)
                redirect(site_url('parents'), 'refresh');
            }
        }

        // If code comes here it means login has failed
        // Redirect to login with the error message
        $this->session->set_flashdata('login_error', "Login failed. Check your credentials");
        redirect(site_url('login'), 'refresh');
    }

    // Forgot password method (just loads forgot password view)
    public function forgot_password(){
        $data['title'] = "Reset Password";
        $this->load->view('view_forgot', $data);
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

            // Tell the user that the password has been resetted and tell new password.
            $this->session->set_flashdata('reset_success', "Password resetted as: $newpassword");
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

            // Tell the user that the password has been resetted and tell new password.
            $this->session->set_flashdata('reset_success', "Password resetted as: $newpassword");
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

            // Tell the user that the password has been resetted and tell new password.
            $this->session->set_flashdata('reset_success', "Password resetted as: $newpassword");
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
            'librarian_login',
            'librarian_id',
            'accountant_login',
            'accountant_id',
            'login_user_id',
            'name',
            'login_type'
        );

        // Unset sessions now
        $this->session->unset_userdata($session_vars);

        // Set flash data
        $this->session->set_flashdata('logout_notification', 'Logged out successfully!');

        // Redirect to login page
        redirect(site_url('login'), 'refresh');
    }
}