<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Web Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Source extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }
    public function index()
    {
        setLinkDefault();
        $assign_list['mod'] = 'source';
        $this->load->model('User_model');
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        
        $this->load->model('Source_model');
        $clsClassTable = new Source_model();
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
        if (isset($_GET['keyword'])) {
            $cons .= " and slug like '%".toSlug($_GET['keyword'])."%'";
        }
        #
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        } else {
            $order = $pkeyTable.' desc';
        }
        #
        $listItem = $clsClassTable->getListPage($cons." order by ".$order, RECORD_PER_PAGE, 'CMS');
        $paging = $clsClassTable->getNavPage($cons, RECORD_PER_PAGE, 'CMS');
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Quản lý nguồn tin";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/source/source', $assign_list);
    }
    public function add()
    {
        $assign_list['mod'] = 'source';
        $this->load->model('Source_model');
        
        $clsClassTable = new Source_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('Category_model');
        $this->load->model('User_model');
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
            $data['title'] = $this->input->post('title');
            $data['slug'] = toSlug($data['title']);
            $data['meta_title'] = $this->input->post('meta_title');
            $data['meta_keyword'] = $this->input->post('meta_keyword');
            $data['meta_description'] = $this->input->post('meta_description');
            $data['domain'] = $this->input->post('domain');
            $data['tag_title'] = $this->input->post('tag_title');
            $data['tag_sapo'] = $this->input->post('tag_sapo');
            $data['tag_content'] = $this->input->post('tag_content');
            
            if ($clsClassTable->insertOne($_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                $clsClassTable->deleteArrKey();
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                redirect('/source/edit?id='.$maxId.'&mes=insertSuccess');
            } else {
                foreach ($this->input->post() as $key => $val) {
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
        $assign_list['title_page'] = 'Thêm nguồn tin';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/source/add', $assign_list);
    }
    public function edit()
    {
        $assign_list['mod'] = 'source';
        $this->load->model('Source_model');
        
        $clsClassTable = new Source_model();
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
        if ($this->input->post() && $this->input->post('title')) {
            #
            $data['title'] = $this->input->post('title');
            $data['slug'] = toSlug($data['title']);
            $data['meta_title'] = $this->input->post('meta_title');
            $data['meta_keyword'] = $this->input->post('meta_keyword');
            $data['meta_description'] = $this->input->post('meta_description');
            $data['domain'] = $this->input->post('domain');
            $data['tag_title'] = $this->input->post('tag_title');
            $data['tag_sapo'] = $this->input->post('tag_sapo');
            $data['tag_content'] = $this->input->post('tag_content');
            
            $id = $this->input->get('id');
            if ($clsClassTable->updateOne($id, $data)) {
                message_flash('Update thông tin thành công', 'success');
                redirect('/source/edit?id='.$_GET['id']);
            } else {
                foreach ($this->input->post() as $key => $val) {
                    $assign_list[$key] = $val;
                }
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $msg = $clsMail->reportError('Lỗi sửa bài trong module Source', false);
                $msg = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$msg.'</div>';
            }
            unset($data);
        }
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = 'Sửa nguồn tin';
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render('backend/standart/administrator/source/edit', $assign_list);
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $this->load->model('Source_model');
        $clsClassTable = new Source_model();
        if ($clsClassTable->updateOne($id, array('is_trash'=>'1'))) {
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
        #
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $this->load->model('Source_model');
        $clsClassTable = new Source_model();
        if ($clsClassTable->updateOne($id, array('is_trash'=>'0'))) {
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
        #
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $this->load->model('Source_model');
        $clsClassTable = new Source_model();
        if ($clsClassTable->deleteOne($id)) {
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
