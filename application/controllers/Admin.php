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
        $this->load->view('view_index', $data);
    }
}