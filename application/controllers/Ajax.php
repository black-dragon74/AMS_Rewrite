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
        $teacher = $this->db->get('student');
        // TODO ADD DYNAMIC BACKGROUND TO FACULTY CARDS
        $this->session->set_userdata('ajax_num_rows', $teacher->num_rows());
        if ($teacher->num_rows() != 0){
            foreach ($teacher->result() as $row){
                echo '<div class="col-lg-4 col-md-6">
                        <div class="box box-widget widget-user">
                            <div class="widget-user-header">
                                <h3 class="widget-user-username">'.$row->name.'</h3>
                                <h5 class="widget-user-desc">Professor</h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" src="'.$this->crud_model->get_profile_pic("student", $row->student_id).'" alt="User Avatar">
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
}