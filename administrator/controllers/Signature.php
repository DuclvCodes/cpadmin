<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Signature extends Admin
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
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $clsClassTable = new Signature_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $is_trash = 0;
        if (isset($_GET['is_trash']) && $_GET['is_trash']==1) {
            $is_trash = 1;
            $listItem = $clsClassTable->getAll("is_trash=1", true, 'CMS');
            $assign_list["listItem"] = $listItem;
        } else {
            $listItem = $clsUser->getAll("is_trash=0", true, 'CMS');
            $assign_list["listItem"] = $listItem;
        }
        $assign_list["is_trash"] = $is_trash;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "List Signature | Module Signature Manager";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $clsClassTable = new Setting_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $_POST['title']) {
            if ($clsClassTable->insertOne($_POST)) {
                sleep(3);
                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                redirect('/signature/edit?id='.$maxId.'&mes=insertSuccess');
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
        $assign_list['title_page'] = "Add Signature";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        $classTable = ucfirst(strtolower($mod));
        $assign_list["classTable"] = $classTable;
        $clsClassTable = new Signature_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $clsClassTable->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        #
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $_POST['title']) {
            #

            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $data = $clsClassTable->getOne(intval($_GET['id']));
                message_flash('Update thông tin thành công', 'success');
                redirect('/'. current_method()['mod'].'/'. current_method()['act'].'?id='.$_GET['id']);
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
        $assign_list['title_page'] = "Edit ".$classTable;
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function trash()
    {
        global $assign_list, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $core, $msg;
        #
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $classTable = ucfirst(strtolower($mod));
        $clsClassTable = new $classTable;
        if ($clsClassTable->updateOne($id, array('is_trash'=>'1'))) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa tạm trong module '.$classTable);
        }
    }
    public function restore()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        //$classTable = ucfirst(strtolower($mod));
        $clsClassTable = new Signature_model();
        if ($clsClassTable->updateOne($id, array('is_trash'=>'0'))) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi khôi phục trong module '.$classTable);
        }
    }
    public function delete()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        //$classTable = ucfirst(strtolower($mod));
        $clsClassTable = new Signature_model();
        if ($clsClassTable->deleteOne($id)) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
        }
    }
}
