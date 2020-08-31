<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Box Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Box extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }

    public function index()
    {
        setLinkDefault();
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list['clsCategory'] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        $classTable = 'Box';
        $assign_list["classTable"] = $classTable;
        $this->load->model('Box_model');
        $clsClassTable = new Box_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "1=1 ";
        if (!isset($_GET['is_trash'])) {
            $_GET['is_trash'] = '0';
        }
        #
        if (isset($_GET['is_trash'])) {
            $cons .= " and is_trash=".$_GET['is_trash'];
        }
        #
        if (isset($_GET['category_id'])) {
            $cons.=" and (category_id = ".$_GET['category_id']." OR category_id in (".implode(',', $clsCategory->getChild($_GET['category_id']))."))";
        }
        if (isset($_GET['keyword'])) {
            $cons .= " and slug like '%".toSlug($_GET['keyword'])."%'";
        }
        #
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = 'box_id desc';
        }
        #
        $listItem = $clsClassTable->getListPage($cons." order by ".$order, 500, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, 500, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "List ".$classTable." | Module ".$classTable." Manager";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/box/box', $assign_list);
    }
    public function add()
    {
        $classTable = ucfirst(strtolower('box'));
        $assign_list["classTable"] = $classTable;
        $this->load->model('Box_model');
        $clsClassTable = new Box_model();
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
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post() && $this->input->post('title')) {
            if ($clsClassTable->insertOne($_POST, false)) {
                sleep(3);
                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                redirect('/box/edit?id='.$maxId.'&mes=insertSuccess');
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
        $assign_list['title_page'] = 'Add Box';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/box/add', $assign_list);
    }
    public function edit()
    {
        $classTable = ucfirst(strtolower('box'));
        $assign_list["classTable"] = $classTable;
        $this->load->model('Box_model');
        $clsClassTable = new Box_model();
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
        $assign_list['clsUser'] = $clsUser;
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        if ($this->input->post()) {
            #
            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $data = $clsClassTable->getOne(intval($_GET['id']));
                message_flash('Update thông tin thành công', 'success');
                redirect('/box/edit?id='.$_GET['id']);
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
        $assign_list['title_page'] = 'Edit Box';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/box/edit', $assign_list);
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $classTable = ucfirst(strtolower('box'));
        $this->load->model('Box_model');
        $clsClassTable = new Box_model();
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
        $classTable = ucfirst(strtolower('box'));
        $this->load->model('Box_model');
        $clsClassTable = new Box_model();
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
        $classTable = ucfirst(strtolower('box'));
        $this->load->model('Box_model');
        $clsClassTable = new Box_model();
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
