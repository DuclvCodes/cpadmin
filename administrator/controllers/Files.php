<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Files extends Admin
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
        $this->load->model('File_model');
        $clsClassTable = new File_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "1=1 ";
        $listItem = $clsClassTable->getListPage($cons." order by file_id desc", 100, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, 100, 'CMS');
        $assign_list['mod'] = 'files';
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Thư viện File";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function detail()
    {
        $file_id = $_GET['id'];
        $this->load->model('File_model');
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        $clsFile = new File_model();
        $assign_list['oneItem'] = $clsFile->getOne($file_id);
        if ($this->input->post()) {
            $id = $_POST['file_id'];
            $res = $clsFile->updateOne($id, $_POST);
            redirect('/files/?mes=insertSuccess');
        }
        $view = $this->load->view(current_method()['view'], $assign_list, true);
        echo $view;
        die();
    }
    public function delete()
    {
        $file_id = $_GET['id'];
        $this->load->model('File_model');
        $clsFile = new File_model();
        $oneItem = $clsFile->getOne($file_id);
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if (!$me) {
            die('Need login');
        }
        if ($me['user_id'] != $oneItem['user_id']) {
            die('0');
        }
        $delete = ftpDelete($oneItem['file']);
        $clsFile->deleteOne($file_id);
        die(1);
    }
}
