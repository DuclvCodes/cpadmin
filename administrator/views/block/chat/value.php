<?php
defined('BASEPATH') or exit('No direct script access allowed');

class tinymce
{
    private $block_name 	= '';
    private $path_html = '';

    public function setBlockName($name)
    {
        $this->block_name = $name;
        $this->path_html = 'block/'.$this->block_name.'/html';
    }

    public function var_html()
    {
        $CI =& get_instance();
        $CI->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $CI->load->mode('Room_model');
        $clsRoom = new Room_model();
        $assign_list['clsRoom'] = $clsRoom;
        #
        $allUser = $clsUser->getAll("is_trash=0", true, 'CMS');
        $assign_list['allUser'] = $allUser;
        $user_id = $clsUser->getUserID();
        $assign_list['me_id'] = $user_id;
        $assign_list['me'] = $clsUser->getOne($user_id);

        $me = $clsUser->getOne($user_id);
        $chat_read = json_decode($me['chat_read']);
        if (is_object($chat_read)) {
            $chat_read = get_object_vars($chat_read);
        }
        $assign_list['chat_read'] = $chat_read;
        #
        $allRoom = $clsRoom->getAll("user_path LIKE '%\_".$user_id."\_%' order by last_update desc limit 1000", true, 'USER_'.$user_id);
        $assign_list['allRoom'] = $allRoom;
        $html_return = $CI->load->view($this->path_html, $assign_list, true);

        return $html_return;
    }
}
    
   
?>

    
    
?>