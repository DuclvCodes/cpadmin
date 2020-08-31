<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Code extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }

    public function index()
    {
        setLinkDefault();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        $classTable = ucfirst(strtolower('code'));
        $assign_list["classTable"] = $classTable;
        $this->load->model('Code_model');
        $clsClassTable = new Code_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $listItem = $clsClassTable->getAll("1=1 order by title", true, 'CMS');
        $assign_list["listItem"] = $listItem;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Danh sách Quảng cáo | Module ".$classTable." Manager";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        $classTable = ucfirst(strtolower('code'));
        $assign_list["classTable"] = $classTable;
        $this->load->model('Code_model');
        $clsClassTable = new Code_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $_POST['title']) {
            $_POST['todate'] = datepicker2db($_POST['todate'], false);
            if (strtotime($_POST['todate'])<strtotime(date('Y-m-d', strtotime('-1 day')).' 23:59:59')) {
                $_POST['is_show'] = 0;
            }
            $_POST['user_edit'] = $me['user_id'];
            $_POST['last_edit'] = time();

            if ($clsClassTable->insertOne($_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                if (isset($_GET['ads_id'])) {
                    $this->load->model('Ads_model');
                    $clsAds = new Ads_model();
                    $oneAds = $clsAds->getOne($_GET['ads_id']);
                    $name = $_GET['name'];
                    $all = '|'.rtrim($maxId.$oneAds[$name], '|').'|';
                    $clsAds->updateOne($_GET['ads_id'], array($name=>$all));
                    redirect('/ads/edit?id='.$_GET['ads_id'].'&mes=insertSuccess&name='.$_GET['name']);
                } elseif (isset($_GET['area_id'])) {
                    $clsArea = new Area_model();
                    $oneArea = $clsArea->getOne($_GET['area_id']);
                    $name = $_GET['name'];
                    $all = '|'.rtrim($maxId.$oneArea[$name], '|').'|';
                    $clsArea->updateOne($_GET['area_id'], array($name=>$all));
                    redirect('/ads/editcat?id='.$_GET['area_id'].'&mes=insertSuccess&name='.$_GET['name']);
                } else {
                    redirect('code/edit?id='.$maxId.'&mes=insertSuccess');
                }
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi thêm bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Tạo mới Quảng cáo';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        $classTable = ucfirst(strtolower('code'));
        $assign_list["classTable"] = $classTable;
        $this->load->model('Code_model');
        $clsClassTable = new Code_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $clsClassTable->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        #
        $this->load->model('Ads_model');
        $this->load->model('Area_model');
        $clsAds = new Ads_model();
        $assign_list["clsAds"] = $clsAds;
        $clsArea = new Area_model();
        $assign_list["clsArea"] = $clsArea;
        $allAds = $clsAds->getIDs($oneItem['code_id']);
        $assign_list['allAds'] = $allAds;
        $allArea = $clsArea->getIDs($oneItem['code_id']);
        $assign_list['allArea'] = $allArea;

        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if (!$clsUser->permission('ads')) {
            die('Not found');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $this->input->post('title')) {
            #
            $_POST['todate'] = datepicker2db($_POST['todate'], false);
            if (strtotime($_POST['todate'])<strtotime(date('Y-m-d', strtotime('-1 day')).' 23:59:59')) {
                $_POST['is_show'] = 0;
            }
            $_POST['user_edit'] = $me['user_id'];
            $_POST['last_edit'] = time();

            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $data = $clsClassTable->getOne(intval($_GET['id']));
                message_flash('Update thông tin thành công', 'success');
                redirect('/code/edit?id='.$_GET['id']);
            } else {
                foreach ($_POST as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
            unset($_POST);
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Chỉnh sửa Quảng cáo -  Admin Control Panel';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function generator()
    {
        if ($this->input->post()) {
            $this->load->model('Image_model');
            if ($_POST['type']==1) {
                $file_type=$_FILES['file']['type'];
                $file_size=$_FILES['file']['size'];
                $allowed = array('jpg', 'jpeg', 'png', 'gif', 'mp4');
                $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), $allowed)) {
                    die('Do not support this extension');
                }
                $file_dir = 'uploads/'.basename($_FILES['file']['name']);
                if ((($file_type == "image/gif") || ($file_type == 'application/octet-stream') || ($file_type == "image/jpeg") || ($file_type == "image/png")) && ($file_size < 10000000)) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_dir)) {
                        $clsImage = new Image_model();
                        $file = MEDIA_DOMAIN.$clsImage->moveToMedia($file_dir, 'qc');
                        echo '<a href="'.$_POST['link'].'" target="_blank" rel="nofollow"><img src="'.$file.'" alt="'.DOMAIN_NAME.'" /></a>';
                    }
                }
            } elseif ($_POST['type']==2) {
                $file_type=$_FILES['file']['type'];
                $file_size=$_FILES['file']['size'];
                $allowed = array('jpg', 'jpeg', 'png', 'gif', 'mp4');
                $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), $allowed)) {
                    die('Do not support this extension');
                }
                $file_dir = 'uploads/'.basename($_FILES['file']['name']);
                if ((($file_type == "application/x-shockwave-flash")) && ($file_size < 10000000)) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $file_dir)) {
                        $clsImage = new Image_model();
                        $file = MEDIA_DOMAIN.$clsImage->moveToMedia($file_dir, 'qc');
                        echo '<object data="'.$file.'"></object>';
                    }
                }
            }
        }
        die();
    }
}
