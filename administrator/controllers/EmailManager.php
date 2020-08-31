<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class EmailManager extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }
        
    public function index()
    {
        setLinkDefault();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $clsClassTable = new Email_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $listItem = $clsClassTable->getChild(0);
        $assign_list["listItem"] = $listItem;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Danh sách Email";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        //$classTable = ucfirst(strtolower($mod));
        $clsClassTable = new Email_model;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('need login ...');
        }
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $_POST['title']) {
            $_POST['title'] = trim($_POST['title']);

            if (isset($_POST['email'])) {
                $_POST['email'] = trim($_POST['email']);
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    die('Email chưa đúng định dạng');
                }
            }
            if ($clsClassTable->insertOne($_POST, true, 'CMS')) {
                redirect('/emailManager?mes=insertSuccess');
            } else {
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi thêm bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        //$classTable = ucfirst(strtolower($mod));
        $clsClassTable = new Email_model();
        $oneItem = $clsClassTable->getOne($_GET['id']);
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('need login ...');
        }
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $_POST['title']) {
            $_POST['title'] = trim($_POST['title']);

            if (isset($_POST['email'])) {
                $_POST['email'] = trim($_POST['email']);
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    die('Email chưa đúng định dạng');
                }
            }
            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $data = $clsClassTable->getOne(intval($_GET['id']));
                redirect('/emailManager?mes=updateSuccess');
            } else {
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module '.$classTable, false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
        }
        #
        $this->render(current_method()['view'], $assign_list);
    }
    public function delete()
    {
        $id = intval($_GET['id']);
        //$classTable = ucfirst(strtolower($mod));
        $clsClassTable = new Email_model();
        if ($clsClassTable->deleteOne($id)) {
            $clsClassTable->deleteArrKey('CMS');
            redirect('/EmailManager?mes=deleteSuccess');
        } else {
            die('Error delete.');
        }
        die();
    }
}
