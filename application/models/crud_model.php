<?php
/**
 * Created by nick.
 */

class crud_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_profile_pic($type, $id){
        if (file_exists('uploads/' .$type. '_image/' .$id. '.jpg')){
            $imageURL = base_url('uploads/' .$type. '_image/' .$id. '.jpg');
        }
        else {
            $imageURL = base_url('uploads/user.jpg');
        }

        return $imageURL;
    }

    public function clear_cache(){
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
}