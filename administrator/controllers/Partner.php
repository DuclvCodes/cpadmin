<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Partner extends Admin
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
        $this->load->model('Partner_model');
        $clsClassTable = new Partner_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        if ($this->input->post()) {
            if ($_POST['order_no']) {
                foreach ($_POST['order_no'] as $key=>$val) {
                    $data = array('order_no'=>$val);
                    $one = $clsClassTable->getOne($key);
                    if ($one['order_no']!=$val) {
                        $data['last_update'] = time();
                    }
                    $clsClassTable->updateOne($key, $data);
                }
            }
            $clsClassTable->deleteArrKey('CMS');
            redirect(getAddress());
        }
        #
        $listItem = $clsClassTable->getAll('1=1 order by order_no, partner_id desc limit 1000', true, 'CMS');
        $assign_list["listItem"] = $listItem;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Danh sách Partner";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        $this->load->model('Partner_model');
        $clsClassTable = new Partner_model();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        if (!$me) {
            die('need login ...');
        }
        $assign_list['tableName'] = $clsClassTable->tbl;
        $assign_list['keyTable'] = $clsClassTable->pkey;
        #
        if ($this->input->post() && $this->input->post('title')) {
            $_POST['title'] = trim($_POST['title']);
            if ($_FILES['image']['name']) {
                $_POST['image'] = ftpUpload('image', $mod, toSlug($_POST['title']), time(), 200, 200).'?v='.time();
            }
            if ($clsClassTable->insertOne($_POST, true, 'CMS')) {
                $clsClassTable->deleteArrKey('BOX');
                redirect('/partner?mes=insertSuccess');
            } else {
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi thêm bài trong module Partner', false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        $this->load->model('Partner_model');
        $clsClassTable = new Partner_model();
        $assign_list['oneItem'] = $clsClassTable->getOne($_GET['id']);
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        if (!$me) {
            die('need login ...');
        }
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $_POST['title']) {
            $_POST['title'] = trim($_POST['title']);

            if ($_FILES['image']['name']) {
                $_POST['image'] = ftpUpload('image', $mod, toSlug($_POST['title']), time(), 200, 200).'?v='.time();
            }
            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $data = $clsClassTable->getOne(intval($_GET['id']));
                redirect('/partner?mes=updateSuccess');
            } else {
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        $assign_list['mod'] = 'partner';
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function delete()
    {
        $id = intval($_GET['id']);
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        if (!$me) {
            die('need login ...');
        }
        $this->load->model('Partner_model');
        $clsClassTable = new Partner_model();
        if ($clsClassTable->deleteOne($id)) {
            $clsClassTable->deleteArrKey('CMS');
            $clsClassTable->deleteArrKey('BOX');
            redirect('/partner?mes=deleteSuccess');
        } else {
            die('Error delete.');
        }
        die();
    }
}
