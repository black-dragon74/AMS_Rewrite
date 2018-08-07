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
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0');
        $this->output->set_header('Pragma: no-cache');
    }

    /**
     * @param $inputField string Input Field
     * @param $usertype string User Type
     * @return void
     */
    public function update_profile_pic($inputField, $usertype) {

        $user_id = ''; $uploadedImg = $_FILES[$inputField]['tmp_name'];

        // Determine the user type first
        switch ($usertype) {
            case 'student':
                $user_id = 'student_id';
                break;
            case 'teacher':
                $user_id = 'teacher_id';
                break;
            case 'admin':
                $user_id = 'admin_id';
                break;
            case 'parent':
                $user_id = 'parent_id';
                break;
            default:
                break;
        }
        // Init the config for image_lib
        $config['image_library'] = 'gd2';
        $config['source_image'] = $uploadedImg;
        $config['maintain_ratio'] = FALSE;
        $config['width']         = 160;
        $config['height']       = 160;
        $config['new_image'] = 'uploads/'.$usertype.'_image/' . $this->session->userdata($user_id) . '.jpg';

        // Load the library with the config
        $this->load->library('image_lib', $config);

        // Resize image and profile pic with the new image
        $this->image_lib->resize();

        // Delete un-resized image from the server
        if (file_exists($uploadedImg)){
            unlink($uploadedImg);
        }
    }

    // Function to get login details of a usertype from an input field based on params
    public function get_login_info($inputField, $usertype){
        $this->db->where('uid', $this->input->post($inputField));
        $this->db->or_where('email', $this->input->post($inputField));
        $result = $this->db->get($usertype);

        // Return row if there is
        if ($result->num_rows() != 0){
            return $result->row();
        }
    }

    // This function takes table name as input and returns the count as result
    function get_count_of($table){
        return $this->db->get($table)->num_rows();
    }

    // Function to redirect with success

    /**
     * Redirects to a specific page by setting a flash data along with a flash message.
     * @param $flashData string Key of flash data to be set
     * @param $flashMsg string Flash message that will be displayed to the user
     * @param $redirectURL string The site url to redirect to
     * @return void
     */
    function redirect($flashData, $flashMsg, $redirectURL) {
        $this->session->set_flashdata($flashData, $flashMsg);
        // Redirect
        redirect($redirectURL);
    }

    // Sets the config value of a config_key into the database
    function set_config($configKey, $configValue){
        $this->db->where('config_key', $configKey);
        return $this->db->update('config', array('config_value' => $configValue));
    }

    // Returns the config value of a config_key from the database
    function get_config($configKey){
        return $this->db->get_where('config', array('config_key' => $configKey))->row()->config_value;
    }
}