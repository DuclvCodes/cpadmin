<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Setting extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }

    public function index()
    {
        setLinkDefault();
        $letter = "Setting";
        $assign_list["letter"] = $letter;
        
        $this->load->model('Setting_model');
        $clsClassTable = new Setting_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        if (!$clsUser->permission('setting')) {
            die('Not found');
        }
        $oneItem = $clsClassTable->info;
        $options = json_decode($oneItem['options']);
        if (is_object($options)) {
            $options = get_object_vars($options);
        }
        $assign_list['options'] = $options;
        #
        if ($this->input->post()) {
            $action = $this->input->post('action');
            $data = array();
            if ($action=='seo') {
                $data['title'] = isset($_POST['title']) ? $_POST['title'] : '';
                $data['name_page'] = isset($_POST['name_page']) ? $_POST['name_page'] : '';
                $data['keyword'] = isset($_POST['keyword']) ? $_POST['keyword'] : '';
                $data['description'] = isset($_POST['description']) ? $_POST['description'] : '';
                $data['analytics'] = isset($_POST['analytics']) ? $_POST['analytics'] : '';
                $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
                $tab = 1;
            } elseif ($action=='logo') {
                $file_type=$_FILES['file']['type'];
                if ((($file_type == "image/gif") || ($file_type == "image/bmp") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/pjpeg")) && ($file_size < 10000000)) {
                    $filename = $_FILES['file']['name'];
                    $directory = 'templates/themes/images/logo.png';

                    $res = move_uploaded_file($_FILES['file']["tmp_name"], $directory);
                    if ($res) {
                        $clsClassTable->updateLogo('/'.$directory);
                        message_flash('Update thông tin thành công', 'success');
                        redirect('/Setting?tab=2');
                    } else {
                        message_flash('Update không thành công', 'warning');
                        redirect('Setting?tab=2');
                    }
                    die();
                }
                $tab = 2;
            } elseif ($action=='info') {
                $data['options'] = json_encode($_POST['options']);
                $tab = 3;
            } elseif ($action=='textlink') {
                $_POST['textlink'] = str_replace('<p> </p>', '', $_POST['textlink']);
                $data['textlink'] = $_POST['textlink'];
                $tab = 4;
            } elseif ($action=='about') {
                $data['about'] = $_POST['about'];
                $tab = 5;
            } elseif ($action=='contact') {
                $data['footer_desktop'] = json_encode($_POST['footer_desktop']);
                $data['footer_mobile'] = json_encode($_POST['footer_mobile']);
                $tab = 6;
            }
            $clsClassTable->deleteArrKey('BOX');
            if ($clsClassTable->updateOne(1, $data)) {
                message_flash('Update thông tin thành công', 'success');
                redirect('/setting?tab='.$tab);
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi config trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        $assign_list['tab_active'] = isset($_GET['tab'])?$_GET['tab']:1;
        #
        $oneItem = $clsClassTable->getOne(1);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey ;
        if ($oneItem['options']) {
            $options = json_decode($oneItem['options']);
        }
        if ($options) {
            $assign_list['options'] = get_object_vars($options);
        }

        if ($oneItem['contact']) {
            $contact = json_decode($oneItem['contact']);
        }
        if (is_object($contact)) {
            $contact = get_object_vars($contact);
        }
        $assign_list['contact'] = $contact;
        //print_r($contact); die();
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Setting | Config The Website";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
}
