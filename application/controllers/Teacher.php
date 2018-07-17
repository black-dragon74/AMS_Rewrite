<?php
/**
 * Created by nick.
 */

defined ('BASEPATH') or die('Direct access prohibitted');

class Teacher extends CI_Controller {

    private function parentOrGTFO(){ // Parent or get the fuck out!
        if ($this->session->userdata('teacher_login') != 1){
            // Only parents should access this area
            $this->session->set_flashdata('login_error', "You must login first!");
            redirect(site_url('login'.'?redirect='.uri_string()), 'refresh');
        }
    }


    public function __construct()
    {
        parent::__construct();
        $this->parentOrGTFO();
    }

    public function index(){
        // Parent should never be able to use forceLogin parameter
        if ($this->crud_model->get_config('site_offline') == 'yes'){
            $data['title'] = 'Maintenance';
            $this->load->view('maintenance', $data);
            return;
        }

        print_r($this->session->userdata());
        if ($this->session->userdata('teacher_login') != 1){
            // Only parents should access this area
            $this->session->set_flashdata('login_error', "Invalid teacher access rerouted!");
            redirect(site_url('login'), 'refresh');
        }
        $data['usertype'] = $this->session->userdata('login_type');
        $this->load->view('view_index', $data);
    }
}