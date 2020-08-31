<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Channel extends Admin
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
        $this->load->model('Channel_model');
        $clsClassTable = new Channel_model;
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        if ($this->input->post()) {
            if ($_POST['is_hot']) {
                foreach ($_POST['is_hot'] as $key=>$val) {
                    $clsClassTable->updateOne($key, array('is_hot'=>$val));
                }
            }
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            header('Location: '.getAddress());
        }
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
        if (isset($_GET['keyword'])) {
            $cons .= " and slug like '%".toSlug($_GET['keyword'])."%'";
        }
        #
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = 'is_hot';
        }
        #
        $listItem = $clsClassTable->getListPage($cons." order by ".$order, RECORD_PER_PAGE, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, RECORD_PER_PAGE, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Dòng sự kiện";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        //$this->render('backend/standart/administrator/channel/channel',$assign_list);
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        //$classTable = ucfirst(strtolower($mod));  $assign_list["classTable"] = $classTable;
        $this->load->model('Channel_model');
        $clsClassTable = new Channel_model();
        $assign_list['clsClassTable'] = $clsClassTable;
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
        $assign_list['clsUser'] = $clsUser;
        #
        $assign_list['tableName'] = $clsClassTable->tbl;
        $assign_list['pkeyTable'] = $clsClassTable->pkey;
        #
        if ($this->input->post() && $this->input->post('title')) {
            $_POST['slug'] = toSlug($_POST['title']);
            //if(isset($_FILES['image']['name'])) $_POST['image'] = ftpUpload('image', 'channel', $_POST['slug'], time());

            if ($clsClassTable->insertOne($_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                message_flash('Update Channel thành công', 'success');
                redirect('/channel/edit?id='.$maxId);
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
        $assign_list['title_page'] = 'Thêm sự kiện';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/channel/add', $assign_list);
    }
    public function edit()
    {
        //$classTable = ucfirst(strtolower($mod));  $assign_list["classTable"] = $classTable;
        $this->load->model('Channel_model');
        $clsClassTable = new Channel_model();
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
            #

            $_POST['slug'] = toSlug($_POST['title']);
            if (isset($_FILES['image']['name'])) {
                $_POST['image'] = ftpUpload('image', 'channel', $_POST['slug'], time()).'?t='.time();
            }

            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                message_flash('Update thông tin thành công', 'success');
                redirect('/channel/edit?id='.$_GET['id']);
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
        $assign_list['title_page'] = 'Sửa sự kiện';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/channel/edit', $assign_list);
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        //$classTable = ucfirst(strtolower($mod));
        $this->load->model('Channel_model');
        $clsClassTable = new Channel_model();
        if ($clsClassTable->updateOne($id, array('is_trash'=>'1'))) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            message_flash('Xóa Channel thành công', 'warning');
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
        $this->load->model('Channel_model');
        $clsClassTable = new Channel_model();
        if ($clsClassTable->updateOne($id, array('is_trash'=>'0'))) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            message_flash('Phục hồi thành công', 'success');
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
        $this->load->model('Channel_model');
        $clsClassTable = new Channel_model();
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
    
    public function reset()
    {
        $this->load->model('Channel_model');
        $clsClassTable = new Channel_model();
        $all = $clsClassTable->getAll('is_trash=0 order by '.$clsClassTable->pkey.' desc');
        if ($all) {
            foreach ($all as $key=>$id) {
                $clsClassTable->updateOne($id, array('is_hot'=>($key+1)));
            }
        }
        $clsClassTable->deleteArrKey();
        $clsClassTable->deleteArrKey('CMS');
        redirect('/channel');
    }
}
