<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class Group extends Admin
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
        $this->load->model('Group_model');
        $clsClassTable = new Group_model();
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
        if ($_GET['keyword']) {
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
        $assign_list['title_page'] = "List Group";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        $assign_list['mod'] = 'group';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Group_model');
        $clsClassTable = new Group_model();
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list["clsUser"] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        $category_path = $clsCategory->getChild(0);
        $html_category_path = '';
        if ($category_path) {
            foreach ($category_path as $category_id) {
                $title = $clsCategory->getTitle($category_id);
                $html_category_path .= '<label><input type="checkbox" name="category_path" value="'.$category_id.'" /> '.$title.'</label>';
                $allChild = $clsCategory->getChild($category_id);
                if ($allChild) {
                    foreach ($allChild as $child_id) {
                        $title = $clsCategory->getTitle($child_id);
                        $html_category_path .= '<label class="lv2"><input type="checkbox" name="category_path[]" value="'.$child_id.'" /> '.$title.'</label>';
                    }
                }
                $html_category_path .= '</optgroup">';
            }
        }
        $assign_list["html_category_path"] = $html_category_path;
        #
        if ($_POST && $_POST['title']) {
            $_POST['permission'] = json_encode($_POST['permission']);

            if ($clsClassTable->insertOne($_POST)) {
                sleep(3);
                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                redirect('/group/edit?id='.$maxId.'&mes=insertSuccess');
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
        $assign_list['title_page'] = "Add Group";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        $assign_list['mod'] = 'group';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        //$classTable = ucfirst(strtolower($mod)); $assign_list["classTable"] = $classTable;
        $this->load->model('Group_model');
        $clsClassTable = new Group_model();
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
        $assign_list["clsUser"] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        #
        $tableName = $clsClassTable->tbl;
        $pkeyTable = $clsClassTable->pkey;
        #
        $category_path = $clsCategory->getChild(0);
        $html_category_path = '';
        $_category_path = array();
        if ($oneItem['category_path']) {
            $_category_path = explode('|', trim($oneItem['category_path'], '|'));
        }
        if ($category_path) {
            foreach ($category_path as $category_id) {
                $title = $clsCategory->getTitle($category_id);
                $checked = '';
                if (in_array($category_id, $_category_path)) {
                    $checked = 'checked="checked"';
                }
                $html_category_path .= '<label><input '.$checked.' type="checkbox" name="category_path[]" value="'.$category_id.'" /> '.$title.'</label>';
                $allChild = $clsCategory->getChild($category_id);
                if ($allChild) {
                    foreach ($allChild as $child_id) {
                        $title = $clsCategory->getTitle($child_id);
                        $checked = '';
                        if (in_array($child_id, $_category_path)) {
                            $checked = 'checked="checked"';
                        }
                        $html_category_path .= '<label class="lv2"><input '.$checked.' type="checkbox" name="category_path[]" value="'.$child_id.'" /> '.$title.'</label>';
                    }
                }
                $html_category_path .= '</optgroup">';
            }
        }
        $assign_list["html_category_path"] = $html_category_path;
        #
        if ($_POST && $_POST['title']) {
            #

            $_POST['permission'] = json_encode($_POST['permission']);

            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                $data = $clsClassTable->getOne(intval($_GET['id']));
                message_flash('Update thông tin thành công', 'success');
                redirect('/group/edit?id='.$_GET['id']);
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
        $assign_list['title_page'] = "Edit Group";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        $assign_list['mod'] = 'group';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function trash()
    {
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $this->load->model('Group_model');
        $clsClassTable = new Group_model();
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
        $this->load->model('Group_model');
        $clsClassTable = new Group_model();
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
        $this->load->model('Group_model');
        $clsClassTable = new Group_model();
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
