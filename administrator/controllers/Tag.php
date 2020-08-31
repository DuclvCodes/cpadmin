<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Tag extends Admin
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
        $this->load->model('Tag_model');
        $clsClassTable = new Tag_model();
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $cons = "1=1";
        $keyopen = 'CMS';
        if (!isset($_GET['is_trash'])) {
            $_GET['is_trash'] = '0';
        }
        #
        if (isset($_GET['is_trash'])) {
            $cons .= " and is_trash=".$_GET['is_trash'];
        }
        if (isset($_GET['is_pick']) && $_GET['is_pick']==1) {
            $cons .= " and is_pick=1";
            $keyopen = 'PICK';
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
        $listItem = $clsClassTable->getListPage($cons." order by ".$order, RECORD_PER_PAGE, $keyopen);
        $paging = $clsClassTable->getNavPage($cons, RECORD_PER_PAGE, $keyopen);
        $assign_list["listItem"] = $listItem;
        $assign_list["paging"] = $paging;
        $assign_list["cursorPage"] = isset($_GET["page"])? $_GET["page"] : 1;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Quản lý từ khóa CMS";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Tag_model');
        $clsClassTable = new Tag_model();
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
            $_POST['title'] = trim($_POST['title']);
            $_POST['slug'] = toSlug($_POST['title']);
            $check_id = $clsClassTable->slugToID($_POST['slug']);
            if ($check_id) {
                die('Trùng từ khóa. <a href="/tag/add">Back</a>');
            }

            if ($clsClassTable->insertOne($_POST)) {
                $clsClassTable->deleteArrKey('CMS');
                if ($_POST['is_pick']==1) {
                    $clsClassTable->deleteArrKey('PICK');
                }
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                redirect('/tag/edit?id='.$maxId.'&mes=insertSuccess');
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
        $assign_list['title_page'] = "Thêm mới từ khóa";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Tag_model');
        $clsClassTable = new Tag_model();
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
        if ($this->input->post() && $_POST['title']) {
            #
            $_POST['title'] = trim($_POST['title']);
            $_POST['slug'] = toSlug($_POST['title']);
            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                #
                if ($_POST['is_pick']!=$oneItem['is_pick']) {
                    $clsClassTable->deleteArrKey('PICK');
                }
                $id = $_GET['id'];
                $this->load->model('News_model');
                $clsNews = new News_model();
                $allNews = $clsNews->getAll("tag_path like '%|".$id."|%'");
                if ($allNews) {
                    foreach ($allNews as $news_id) {
                        $clsNews->syncTag($news_id);
                    }
                }
                #
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
        $assign_list['title_page'] = "Chỉnh sửa từ khóa";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        //$classTable = ucfirst(strtolower($mod));
        $this->load->model('Tag_model');
        $clsClassTable = new Tag_model();
        $one = $clsClassTable->getOne($id);
        if ($clsClassTable->updateOne($id, array('is_trash'=>'1'))) {
            if ($oneItem['is_pick']==1) {
                $clsClassTable->deleteArrKey('PICK');
            }
            $this->load->model('News_model');
            $clsNews = new News_model();
            $allNews = $clsNews->getAll("tag_path like '%|".$id."|%'");
            if ($allNews) {
                foreach ($allNews as $news_id) {
                    $oneNews = $clsNews->getOne($news_id);
                    $tag_path = $oneNews['tag_path'];
                    $tag_path = str_replace('|'.$id.'|', '|', $tag_path);
                    $clsNews->updateOne($news_id, array('tag_path'=>$tag_path));
                    $clsNews->syncTag($news_id);
                }
            }

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
        //$classTable = ucfirst(strtolower($mod));
        $this->load->model('Tag_model');
        $clsClassTable = new Tag_model();
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
        $this->load->model('Tag_model');
        $clsClassTable = new Tag_model();
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
