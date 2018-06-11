<?php
/**
 * Created by nick.
 */

defined ('BASEPATH') or die('Direct access prohibitted');

class Parents extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        print_r($this->session->userdata());
        if ($this->session->userdata('parent_login') != 1){
            // Only parents should access this area
            $this->session->set_flashdata('login_error', "Invalid parent access rerouted!");
            redirect(site_url('login'), 'refresh');
        }
        $data['usertype'] = $this->session->userdata('login_type');
        $this->load->view('view_index', $data);
    }
}