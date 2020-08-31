<?php
defined('BASEPATH') or exit('No direct script access allowed');

class message
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
        $clsCategory = $CI->load->model('Category_model');
        
        $clsUser = $CI->load->model("User_model");
        $clsLog = $CI->load->model('Log_model');
        
        $news_id = $_GET['id'];
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $user_id = $clsUser->getUserID();
        $assign_list['user_id'] = $user_id;
        $assign_list['news_id'] = $news_id;

        $clsLog = new Log_model();
        $assign_list['clsLog'] = $clsLog;
        $allLog = $clsLog->getAll("news_id='".$news_id."' order by log_id", true, 'news_'.$news_id);
        $assign_list['allLog'] = $allLog;
        
        
        $html_return = $CI->load->view($this->path_html, $assign_list, true);

        return $html_return;
    }
}
