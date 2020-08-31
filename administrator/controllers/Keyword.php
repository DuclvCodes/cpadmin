<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Keyword extends Admin
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
        
        $clsClassTable = new Keyword_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        if ($_FILES['file']['name']) {
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowed)) {
                die('Do not support this extension');
            }
            $file_type=$_FILES['file']['type'];
            if ($file_type!='application/vnd.ms-excel') {
                die('Filetype not support');
            }
            #
            $all = $clsClassTable->getAll('1=1');
            if ($all) {
                foreach ($all as $id) {
                    $clsClassTable->deleteOne($id);
                }
            }
            #
            $file = @file($_FILES["file"]["tmp_name"]);
            if ($file) {
                foreach ($file as $key=>$line) {
                    if ($key>0) {
                        $arr = explode(',', $line);
                        $clsClassTable->insertOne(array('title'=>trim($arr[0], "\""), 'views'=>$arr[1], 'click'=>$arr[3], 'crt'=>$arr[5]));
                    }
                }
            }
            sleep(1);
            $clsClassTable->deleteArrKey('CMS');
            redirect(getAddress());
            die();
        }
        #
        $cons = "1=1";
        $listItem = $clsClassTable->getListPage($cons." order by views desc", RECORD_PER_PAGE, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, RECORD_PER_PAGE, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "List Keyword";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        $clsClassTable = new Keyword_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $oneItem = $clsClassTable->getOne($_GET['id']);
        if ($oneItem) {
            foreach ($oneItem as $key => $val) {
                $assign_list[$key] = $val;
            }
        }
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($_POST && $_POST['title']) {
            #

            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $data = $clsClassTable->getOne(intval($_GET['id']));
                message_flash('Update thông tin thành công', 'success');
                redirect('/keyword/edit?id='.$_GET['id']);
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
        $assign_list['title_page'] = "Edit Keyword";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function delete()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        
        $clsClassTable = new Keyword_model();
        if ($clsClassTable->deleteOne($id)) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            header(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
        }
    }
}
