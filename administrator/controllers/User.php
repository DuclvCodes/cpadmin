<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
*| --------------------------------------------------------------------------
*| Code Controller
*| --------------------------------------------------------------------------
*| For default controller
*|
*/
class User extends Admin
{
    public function __construct()
    {
        parent::__construct();
        check_user();
    }


    public function profile()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        //$me = $clsUser->getOne($clsUser->getUserID());
        $me = $clsUser->getMe();
        $oneItem = $me;
        if ($me) {
            foreach ($me as $key => $val) {
                $assign_list[$key] = $val;
            }
        } else {
            redirect('/');
        }
        #
        if ($this->input->post()) {
            $action = $_POST['action'];
            unset($_POST['action']);
            $data = array();
            if ($action=='info') {
                $data = $_POST;
                if ($data['birthday']) {
                    $data['birthday'] = datepicker2db($data['birthday'], false);
                }
                $tab = 1;
            } elseif ($action=='avatar') {
                if ($_FILES['image']['name']) {
                    $data['image'] = ftpUpload('image', 'UserProfile', $oneItem['username'], time());
                }
                $tab = 2;
            } elseif ($action=='changepass') {
                $error = '';
                $current_pass = $clsUser->getOne($me['user_id']);
                if (md5($_POST['current_password'])!=$current_pass['password']) {
                    $error = 'Mật khẩu cũ không chính xác';
                } else {
                    if ($_POST['user_pass'] != $_POST['user_pass_mask'] && $_POST['user_pass']!='') {
                        $error = 'Re-type new password không khớp';
                    } else {
                        $data['password'] = md5($_POST['user_pass']);
                        $clsUser->deleteArrKey('login_'.$me['username']);
                        unset($_SESSION['USER_ID']);
                        $tab = 3;
                    }
                }
                if ($error) {
                    $_GET['tab'] = 3;
                    $assign_list['msg'] = '<div class="alert alert-error"><button class="close" data-dismiss="alert"></button>'.$error.'</div>';
                }
            }
            if ($data) {
                if ($clsUser->updateOne($me['user_id'], $data)) {
                    message_flash('Update thông tin thành công', 'success');
                    redirect('/user/profile?tab='.$tab);
                    die();
                } else {
                    $this->load->model('Mail_model');
                    $clsMail = new Mail_model();
                    $msg = $clsMail->reportError('Lỗi update profile trong module Profile');
                }
            }
        }
        $assign_list['tab_active'] = isset($_GET['tab'])?$_GET['tab']:1;
        
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "My Profile";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function index()
    {
        setLinkDefault();
        $this->load->model('User_model');
        $clsUser = new User_model();
        $assign_list['clsUser'] = $clsUser;
        $me = $clsUser->getMe();
        $assign_list['me'] = $me;
        if ($me['group_id']!=5) {
            die('Not found');
        }
        $this->load->model('Group_model');
        $clsGroup = new Group_model();
        $assign_list['clsGroup'] = $clsGroup;
        $clsClassTable = $clsUser;
        $assign_list["clsClassTable"] = $clsClassTable;
        $pkeyTable = $clsClassTable->pkey;
        $assign_list["pkeyTable"] = $pkeyTable;
        #
        $is_trash = isset($_GET['is_trash']) ? $_GET['is_trash'] : 0;
        $cons = "is_trash=".$is_trash;
        $listItem = $clsClassTable->getAll($cons." order by level desc, user_id limit 500", true, 'CMS');
        $assign_list["listItem"] = $listItem;
        #
        /*=============Title & Description Page==================*/
        $assign_list['title_page'] = "Quản lý nhân sự";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function add()
    {
        $this->load->model('User_model');
        $clsClassTable = new User_model();
        $assign_list['clsUser'] = $clsClassTable;
        $assign_list['clsClassTable'] = $clsClassTable;
        #
        $this->load->model('Category_model');
        $clsCategory = new Category_model();
        $assign_list["clsCategory"] = $clsCategory;
        $this->load->model('Group_model');
        $clsGroup = new Group_model();
        $assign_list["clsGroup"] = $clsGroup;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if ($me['group_id']!=5) {
            die('Not found');
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
                $html_category_path .= '<label><input type="checkbox" name="category_path[]" value="'.$category_id.'" /> '.$title.'</label>';
            }
        }
        $assign_list["html_category_path"] = $html_category_path;
        #
        if ($this->input->post() && $_POST['username']) {
            $username = strtolower($_POST['username']);
            if (!$username || strlen($username)<5) {
                die('Username không được nhỏ hơn 5 ký tự | <a href="#" onClick="javascript: history.back(); return false;">Quay lại</a>');
            }
            if ($clsUser->is_exits_user($username)) {
                die('Username "'.$username.'" đã tồn tại | <a href="#" onClick="javascript: history.back(); return false;">Quay lại</a>');
            }

            $_POST['username'] = strtolower($_POST['username']);
            $_POST['password'] = substr(strtoupper(md5('EXP'.time())), 0, 6);
            $pass = $_POST['password'];
            if (isset($_FILES['image']['name'])) {
                $_POST['image'] = ftpUpload('image', 'User', $_POST['username'], time());
            }
            if ($_POST['password']) {
                $_POST['password'] = md5($_POST['password']);
            }
            if (isset($_POST['birthday'])) {
                $_POST['birthday'] = datepicker2db($_POST['birthday'], false);
            }
            if (isset($_POST['permission'])) {
                $_POST['permission'] = json_encode($_POST['permission']);
            }
            $_POST['category_path'] = arrayToPath($_POST['category_path']);
            $_POST['level'] = $clsGroup->getLevel($_POST['group_id']);

            if ($clsClassTable->insertOne($_POST)) {
                $html = 'Tên đăng nhập: <b style="color: #c32c2c;">'.$_POST['username'].'</b><br><br>';
                $html .= 'Mật khẩu: <b style="color: #c32c2c;">'.$pass.'</b><br><br>';
                $html .= 'Link đăng nhập: '.PCMS_URL.'<br><br>';
                $html .= 'Hướng dẫn nhập bài: '.PCMS_URL.'/?act=document';
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $clsMail->sendMail($_POST['email'], 'Tài khoản của bạn đã được tạo thành công', $html);

                $clsClassTable->deleteArrKey('CMS');
                $maxId = $clsClassTable->getMaxID('CMS');
                $data = $clsClassTable->getOne($maxId);
                message_flash('Tạo User thành công', 'success');
                redirect('/user');
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
        $assign_list['title_page'] = "Add User";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function edit()
    {
        $this->load->model('User_model');
        $clsClassTable = new User_model();
        $assign_list['clsUser'] = $clsClassTable;
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
        $this->load->model('Group_model');
        $clsGroup = new Group_model();
        $assign_list["clsGroup"] = $clsGroup;
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        $assign_list["me"] = $me;
        if (!$me) {
            die('need login ...');
        }
        if ($me['group_id']!=5) {
            die('Not found');
        }

        if (isset($_GET['login']) && ($me['user_id']==1 or $me['user_id'] == 297)) {
            set_cookie("USER", $oneItem['username'], time()+31536000);
            set_cookie("PASS", $oneItem['password'], time()+60*5);
            $_SESSION['USER_ID'] = $oneItem['user_id'];
            redirect('/');
            die();
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
            }
        }
        $assign_list["html_category_path"] = $html_category_path;
        #
        if ($this->input->post()) {
            #
            if ($_FILES['image']['name']) {
                $_POST['image'] = ftpUpload('image', 'User', $oneItem['username'], time());
            }
            if ($_POST['password']) {
                $pass = $_POST['password'];
                $_POST['password'] = md5($_POST['password']);
                $html = 'Tên đăng nhập: <b style="color: #c32c2c;">'.$oneItem['username'].'</b><br><br>';
                $html .= 'Mật khẩu mới: <b style="color: #c32c2c;">'.$pass.'</b><br><br>';
                $html .= 'Link đăng nhập: '.PCMS_URL;
                $this->load->model('Mail_model');
                $clsMail = new Mail_model();
                $clsMail->sendMail($oneItem['email'], 'Tài khoản của bạn đã được reset mật khẩu thành công', $html);
            } else {
                unset($_POST['password']);
            }
            if ($_POST['birthday']) {
                $_POST['birthday'] = datepicker2db($_POST['birthday'], false);
            }
            $_POST['permission'] = json_encode($_POST['permission']);
            $_POST['category_path'] = arrayToPath($_POST['category_path']);
            $_POST['level'] = $clsGroup->getLevel($_POST['group_id']);

            if ($clsClassTable->updateOne($_GET['id'], $_POST)) {
                sleep(1);
                if (isset($_POST['password'])) {
                    $clsClassTable->deleteArrKey('login_'.$oneItem['username']);
                }
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
        $assign_list['title_page'] = "Edit User ";
        $assign_list['description_page'] = '';
        $assign_list['keyword_page'] = '';
        /*=============Content Page==================*/
        $this->render(current_method()['view'], $assign_list);
    }
    public function trash()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if ($me['group_id']!=5) {
            die('Not found');
        }
        $id = $_GET['id'];
        if (!$id) {
            die('Not ID!');
        }
        $clsClassTable = new User_model;
        if ($clsClassTable->updateOne($id, array('is_trash'=>'1'))) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            message_flash('Xóa thành công', 'warning');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa tạm trong module '.$classTable);
        }
    }
    public function restore()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if ($me['group_id']!=5) {
            die('Not found');
        }
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $clsClassTable = new User_model();
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
            redirect(getLinkDefault());
        }
    }
    public function delete()
    {
        $this->load->model('User_model');
        $clsUser = new User_model();
        $me = $clsUser->getMe();
        if ($me['group_id']!=5) {
            die('Not found');
        }
        $id = $_GET['id'];
        if (!$id) {
            die('0');
        }
        $clsClassTable = new User_model();
        if ($clsClassTable->deleteOne($id)) {
            sleep(3);
            $clsClassTable->deleteArrKey();
            $clsClassTable->deleteArrKey('CMS');
            message_flash('Xóa thành công', 'warning');
            redirect(getLinkDefault());
        } else {
            $this->load->model('Mail_model');
            $clsMail = new Mail_model();
            $msg = $clsMail->reportError('Lỗi xóa vĩnh viễn trong module '.$classTable);
            redirect(getLinkDefault());
        }
    }
    
    public function logout()
    {
        delete_cookie('USER');
        delete_cookie('PASS');
        delete_cookie('EDITOR');
        // remove all session variables
        session_unset(); 
        // destroy the session 
        session_destroy();
        redirect('/');
    }
    public function lock_screen()
    {
        $_SESSION['USER_ID'] = '';
        setcookie("PASS", "", time() - 3600);
        redirect('/iframe/lock_screen?u='.rawurlencode($_SERVER['HTTP_REFERER']));
        die();
    }
}
