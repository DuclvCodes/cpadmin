<?php
defined('BASEPATH') or exit('No direct script access allowed');

class menu
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
        
        $user_id = $CI->User_model->getUserID();
        if (!$user_id) {
            if (get_cookie('USER')) {
                redirect('/iframe/lock_screen?u='.rawurlencode(getAddress()));
            } else {
                redirect('/iframe/login?u='.rawurlencode(getAddress()));
            }
            die();
        } else {
            $oneUser = $CI->User_model->getOne($user_id);
            if ($oneUser['is_token'] && $oneUser['code_login']) {
                redirect('/iframe/confirm?u='.rawurlencode(getAddress()));
                die();
            }
        }
        
        $me = $CI->User_model->getMe();
        $data["me"] = $me;
        #
        $listModule = $CI->User_model->getModule();
        if ($me['permission']) {
            $listMenu = json_decode($me['permission']);
        }
        if ($listMenu) {
            foreach ($listMenu as $key=>$val) {
                $title = isset($listModule[$key]) ? $listModule[$key] : '';
                if ($title != '') {
                    $menu_top[] = array('mod'=>$key, 'title'=>$title);
                }
            }
        } else {
            foreach ($listModule as $key=>$val) {
                $menu_top[] = array('mod'=>$key, 'title'=>$val);
            }
        }
        
        $data['menu_top'] = $menu_top;
        
        $html_return = $CI->load->view($this->path_html, $data, true);

        return $html_return;
    }
}
