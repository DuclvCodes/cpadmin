<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Tvc extends Admin
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
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Tvc_model');
        $clsClassTable = new Tvc_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $listItem = $clsClassTable->getAll("1=1 order by title", true, 'CMS');
        $assign_list["listItem"] = $listItem;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Danh sách Quảng cáo";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Tvc_model');
        $clsClassTable = new Tvc_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list['clsUser'] = $clsUser;
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
            $_POST['todate'] = datepicker2db($_POST['todate'], false);
            if (strtotime($_POST['todate'])<strtotime(date('Y-m-d', strtotime('-1 day')).' 23:59:59')) {
                $_POST['is_show'] = 0;
            }

            if ($_FILES['file']) {
                $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $slug = toSlug($this->input->post('title'));
                $file = $slug.'-'.date('His').'.'.$extension;
                if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$file)) {
                    $this->load->model('Image_model');
                    $clsImage = new Image_model();
                    $_POST['file'] = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH.$file, 'tvc', $slug, time());
                }
            }

            if ($clsClassTable->insertOne($_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                message_flash('Thêm thông tin thành công', 'success');
                redirect('/tvc?mes=insertSuccess');
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
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function edit()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Tvc_model');
        $clsClassTable = new Tvc_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $clsClassTable->getOne($_GET['id']);
        if ($oneItem) {
            $assign_list['oneItem'] = $oneItem;
        }
        #
        $this->load->model('Ads_model');
        $clsAds = new Ads_model();
        $assign_list["clsAds"] = $clsAds;
        $this->load->model('Area_model');
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

            if ($_FILES['file']) {
                $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                $slug = toSlug($this->input->post('title'));
                $file = date('His').'.'.$extension;
                if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$file)) {
                    $this->load->model('Image_model');
                    $clsImage = new Image_model();
                    $_POST['file'] = $clsImage->moveToMedia(LOCAL_UPLOAD_PATH.$file, 'tvc', $slug, time());
                }
            }

            if ($clsClassTable->updateOne(intval($_GET['id']), $_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                message_flash('Update thông tin thành công', 'success');
                redirect('/tvc?mes=updateSuccess');
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
        $this->render(current_method()['view'], $assign_list);
    }
    public function fix()
    {
        if (!function_exists('ssh2_connect')) {
            die('SSH2 not install ...');
        }
        $this->load->model('System_model');
        $clsSystem = new System_model('MEDIA');
        $home_dir = '/home/media.'.DOMAIN;
        $id = intval($_GET['id']);
        $this->load->model('Tvc_model');
        $clsTvc = new Tvc_model();
        $oneVideo = $clsTvc->getOne($id);
        $file = $oneVideo['file'];
        $out = str_replace('/files/tvc/', '/files/tvc_fix/', $file);
        $path = explode('/', $out);
        array_pop($path);
        $out_path = implode('/', $path);
        $clsSystem->ssh('mkdir -p '.$home_dir.$out_path.'/; chmod 777 '.$home_dir.$out_path.'/; ffmpeg -i '.$home_dir.$file.' -vcodec libx264 -preset medium -vprofile baseline -s 854x480 -b 500k -r 24  -ac 2 -ab 128k -ar 44100 -n -movflags faststart '.$home_dir.$out);
        $clsTvc->updateOne($id, array('file'=>$out, 'is_fix'=>1));
        redirect('/tvc?mes=updateSuccess');
        die();
    }
}
