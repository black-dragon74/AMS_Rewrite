<?php
/**
 * Created by nick.
 */

defined ('BASEPATH') or die('Direct access prohibitted');

class Admin extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
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